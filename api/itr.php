<?php
include("../system_config.php");

function sanitizeInput($data)
{
    return htmlspecialchars(strip_tags(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['key']) && $_POST['key'] === 'qwertyupasdfghjklzxcvbnm') {

    $customerId = isset($_POST['customerId']) ? (int)$_POST['customerId'] : null;
    $user_updated_by = sanitizeInput($_POST['user_updated_by']);
    $aadhar_link_mobile = sanitizeInput($_POST['aadhar_link_mobile']);

    $form16 = sanitizeInput($_FILES['form16']['name']);
    // $salary_sheet = sanitizeInput($_FILES['salary_sheet']['name']);
    // $itr_bank_statement = sanitizeInput($_FILES['itr_bank_statement']['name']);

    $salary_sheet = sanitizeInput($_FILES['salary_sheet']);
    $itr_bank_statement = sanitizeInput($_FILES['itr_bank_statement']);

    $requiredFields = [
        'customerId' => $customerId,
        'user_updated_by' => $user_updated_by,
        'aadhar_link_mobile' => $aadhar_link_mobile,
        'form16' => $form16,
        // 'salary_sheet' => $salary_sheet,
        // 'itr_bank_statement' => $itr_bank_statement
    ];


    $emptyFields = [];
    foreach ($requiredFields as $fieldName => $fieldValue) {
        if (empty($fieldValue)) {
            $emptyFields[] = $fieldName;
        }
    }

    if (!empty($emptyFields)) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['status' => false, 'error' => 'The following fields are required: ' . implode(', ', $emptyFields)]);
        exit;
    }

    // Check if the customer already exists
    $custDetails = getcustomer_byID($customerId);

    function handleFileUpload($fileKey, $columnName, $customerId)
    {
        global $link, $config;

        if (!empty($_FILES[$fileKey]["name"]) && $_FILES[$fileKey]["error"] == 0) {
            $updCustomer = getcustomer_byID($customerId);

            $customerNameWithoutSpacesLowercase = strtolower(str_replace(' ', '', $updCustomer['cust_first_name']));
            $phone = empty($updCustomer['cust_phone']) ? 'NoPhone' : $updCustomer['cust_phone'];
            $imageName = $customerNameWithoutSpacesLowercase . '_' . $phone;

            $file_name = $_FILES[$fileKey]["name"];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $customer_img_name = $imageName . '_' . time() . '_' . $fileKey . "." . $file_ext;
            $path = '../' . $config['Images'] . $customer_img_name;

            if (move_uploaded_file($_FILES[$fileKey]["tmp_name"], $path)) {
                $getPrevious = getItrCustId($customerId)[$columnName];
                unlink('../' . $config['Images'] . $getPrevious);
                $update_sql = "UPDATE itr SET $columnName = ? WHERE customer_id = ?";
                $update_stmt = mysqli_prepare($link, $update_sql);
                mysqli_stmt_bind_param($update_stmt, 'si', $customer_img_name, $customerId);
                mysqli_stmt_execute($update_stmt);
            }
        }
    }

    function handleMultipleFileUpload($fileKey, $columnName, $customerId)
    {
        global $link, $config;

        $existingFilenames = explode(',', getItrCustId($customerId)[$columnName]);

        $imageNames = [];

        foreach ($_FILES[$fileKey]['name'] as $index => $filename) {
            if ($_FILES[$fileKey]['error'][$index] == 0) {
                $updCustomer = getcustomer_byID($customerId);
                $customerNameWithoutSpacesLowercase = strtolower(str_replace(' ', '', $updCustomer['cust_first_name']));
                $phone = empty($updCustomer['cust_phone']) ? 'NoPhone' : $updCustomer['cust_phone'];
                $imageName = $customerNameWithoutSpacesLowercase . '_' . $phone;

                $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                $customer_img_name = $imageName . '_' . time() . '_' . $fileKey . $index . "." . $file_ext;
                $path = '../' . $config['Images'] . $customer_img_name;

                if (move_uploaded_file($_FILES[$fileKey]["tmp_name"][$index], $path)) {
                    $imageNames[] = $customer_img_name;
                }
            }
        }

        // Unlink existing files that are not present in the new list
        foreach ($existingFilenames as $existingFilename) {
            if (!in_array($existingFilename, $imageNames)) {
                unlink('../' . $config['Images'] . $existingFilename);
            }
        }

        // Update the database with the comma-separated list of image names
        if (!empty($imageNames)) {
            $newImageNames = implode(',', $imageNames);
            $update_sql = "UPDATE itr SET $columnName = ? WHERE customer_id = ?";
            $update_stmt = mysqli_prepare($link, $update_sql);
            mysqli_stmt_bind_param($update_stmt, 'si', $newImageNames, $customerId);
            mysqli_stmt_execute($update_stmt);
        }
    }


    if (!$custDetails || !$customerId) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['status' => false, 'error' => 'Invalid customer details.']);
        exit;
    }

    $getItrCustId = getItrCustId($customerId);

    if ($getItrCustId) {

        $sql = "UPDATE itr SET aadhar_link_mobile=?, user_updated_by=? WHERE customer_id=?";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, 'sii', $aadhar_link_mobile, $user_updated_by, $customerId);
        if (mysqli_stmt_execute($stmt)) {
            $last_inserted_id = mysqli_insert_id($link);
            handleFileUpload("form16", "form16", $customerId);
            handleMultipleFileUpload("salary_sheet", "salary_sheet", $customerId);
            handleMultipleFileUpload("itr_bank_statement", "itr_bank_statement", $customerId);
            $response = ['status' => true, 'message' => 'ITR procedure has been update successfully.'];
            http_response_code($customerId ? 200 : 201);
        } else {
            $response = ['status' => false, 'error' => 'Data not updated, please try again later.'];
            http_response_code(500);
        }
    } else {
        // Insert new record
        $sql = "INSERT INTO itr (customer_id, user_updated_by, aadhar_link_mobile) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, 'iis', $customerId, $user_updated_by, $aadhar_link_mobile);
        if (mysqli_stmt_execute($stmt)) {
            handleFileUpload("form16", "form16", $customerId);
            handleMultipleFileUpload("salary_sheet", "salary_sheet", $customerId);
            handleMultipleFileUpload("itr_bank_statement", "itr_bank_statement", $customerId);
            $response = ['status' => true, 'message' => 'ITR Account Opening procedure has been added successfully.'];
            http_response_code(201);
        } else {
            $response = ['status' => false, 'error' => 'Data not inserted, please try again later.'];
            http_response_code(500);
        }
    }


    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
} else {
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode(['status' => false, 'error' => 'Invalid request method or key']);
    exit;
}
