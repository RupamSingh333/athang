<?php
include("../system_config.php");

function sanitizeInput($data)
{
    return htmlspecialchars(strip_tags(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['key']) && $_POST['key'] === 'qwertyupasdfghjklzxcvbnm') {

    $customerId = isset($_POST['customerId']) ? (int)$_POST['customerId'] : null;
    $user_updated_by = sanitizeInput($_POST['user_updated_by']);
    $dmt_acc_name_of_link = sanitizeInput($_POST['dmt_acc_name_of_link']);
    $dmt_acc_screenshot = sanitizeInput($_FILES['dmt_acc_screenshot']);

    $requiredFields = [
        'customerId' => $customerId,
        'user_updated_by' => $user_updated_by,
        'dmt_acc_name_of_link' => $dmt_acc_name_of_link,
        // 'dmt_acc_screenshot' => $dmt_acc_screenshot
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

    // function handleFileUpload($fileKey, $columnName, $customerId)
    // {
    //     global $link, $config;

    //     if (!empty($_FILES[$fileKey]["name"]) && $_FILES[$fileKey]["error"] == 0) {
    //         $updCustomer = getcustomer_byID($customerId);

    //         $customerNameWithoutSpacesLowercase = strtolower(str_replace(' ', '', $updCustomer['cust_first_name']));
    //         $phone = empty($updCustomer['cust_phone']) ? 'NoPhone' : $updCustomer['cust_phone'];
    //         $imageName = $customerNameWithoutSpacesLowercase . '_' . $phone;

    //         $file_name = $_FILES[$fileKey]["name"];
    //         $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    //         $customer_img_name = $imageName . '_' . time() . '_' . $fileKey . "." . $file_ext;
    //         $path = '../' . $config['Images'] . $customer_img_name;

    //         if (move_uploaded_file($_FILES[$fileKey]["tmp_name"], $path)) {
    //             unlink('../' . $config['Images'] . $updCustomer[$columnName]);
    //             $update_sql = "UPDATE customer SET $columnName = ? WHERE cust_id = ?";
    //             $update_stmt = mysqli_prepare($link, $update_sql);
    //             mysqli_stmt_bind_param($update_stmt, 'si', $customer_img_name, $customerId);
    //             mysqli_stmt_execute($update_stmt);
    //         }
    //     }
    // }

    function handleMultipleFileUpload($fileKey, $columnName, $customerId)
    {
        global $link, $config;

        $existingFilenames = explode(',', getcustomer_byID($customerId)[$columnName]);

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
            $update_sql = "UPDATE customer SET $columnName = ? WHERE cust_id = ?";
            $update_stmt = mysqli_prepare($link, $update_sql);
            mysqli_stmt_bind_param($update_stmt, 'si', $newImageNames, $customerId);
            mysqli_stmt_execute($update_stmt);
        }
    }

    if ($custDetails && !$customerId) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['status' => false, 'error' => 'Invalid customer details.']);
        exit;
    } else {
        $sql = "UPDATE customer SET dmt_acc_name_of_link=?, user_updated_by=?,demate_acc_opening_approvedby=? ,demate_acc_opening=? WHERE cust_id=?";
        $stmt = mysqli_prepare($link, $sql);
        $demate_acc_opening = 'Y';
        mysqli_stmt_bind_param($stmt, 'siisi', $dmt_acc_name_of_link, $user_updated_by, $user_updated_by, $demate_acc_opening, $customerId);
        // pr($sql);exit;
        if (mysqli_stmt_execute($stmt)) {
            $last_inserted_id = mysqli_insert_id($link);
            handleMultipleFileUpload("dmt_acc_screenshot", "dmt_acc_screenshot", $customerId);
            $response = ['status' => true, 'message' => 'Demat Account Opening procedure has been update successfully.'];
            http_response_code($customerId ? 200 : 201);
        } else {
            $response = ['status' => false, 'error' => 'Data not update please try after some time.'];
            http_response_code(500);
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
} else {
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode(['status' => false, 'error' => 'Invalid request method or key']);
    exit;
}
