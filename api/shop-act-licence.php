<?php
include("../system_config.php");

function sanitizeInput($data)
{
    return htmlspecialchars(strip_tags(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['key']) && $_POST['key'] === 'qwertyupasdfghjklzxcvbnm') {

    $customerId = isset($_POST['customerId']) ? (int)$_POST['customerId'] : null;
    $cust_org_name = sanitizeInput($_POST['cust_org_name']);
    $cust_org_type = sanitizeInput($_POST['cust_org_type']);
    $user_updated_by = sanitizeInput($_POST['user_updated_by']);

    $cust_selfie = sanitizeInput($_FILES['cust_selfie']['name']);
    $cust_agreement_copy = sanitizeInput($_FILES['cust_agreement_copy']['name']);
    $cust_signature = sanitizeInput($_FILES['cust_signature']['name']);

    $requiredFields = [
        'cust_org_name' => $cust_org_name,
        'cust_org_type' => $cust_org_type,
        'user_updated_by' => $user_updated_by,
        'cust_selfie' => $cust_selfie,
        'cust_agreement_copy' => $cust_agreement_copy,
        'cust_signature' => $cust_signature
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
                unlink('../' . $config['Images'] . $updCustomer[$columnName]);
                $update_sql = "UPDATE customer SET $columnName = ? WHERE cust_id = ?";
                $update_stmt = mysqli_prepare($link, $update_sql);
                mysqli_stmt_bind_param($update_stmt, 'si', $customer_img_name, $customerId);
                mysqli_stmt_execute($update_stmt);
            }
        }
    }


    if ($custDetails && !$customerId) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['status' => false, 'error' => 'Invalid customer details.']);
        exit;
    } else {
        $sql = "UPDATE customer SET cust_org_name=?, cust_org_type=? ,user_updated_by=?,shop_act_licence_approvedby=?,shop_act_licence=? WHERE cust_id=?";
        $stmt = mysqli_prepare($link, $sql);
        $shop_act_licence = 'Y';
        mysqli_stmt_bind_param($stmt, 'sssssi', $cust_org_name, $cust_org_type, $user_updated_by, $user_updated_by, $shop_act_licence, $customerId);
        if (mysqli_stmt_execute($stmt)) {

            handleFileUpload("cust_selfie", "cust_selfie", $customerId);
            handleFileUpload("cust_agreement_copy", "cust_agreement_copy", $customerId);
            handleFileUpload("cust_signature", "cust_signature", $customerId);
            $response = ['status' => true, 'message' => 'Shop Act procedure has been update successfully.'];
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
    // Invalid request method or key
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode(['status' => false, 'error' => 'Invalid request method or key']);
    exit;
}
