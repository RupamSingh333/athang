<?php
include("../system_config.php");

function sanitizeInput($data)
{
    return htmlspecialchars(strip_tags(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['key']) && $_POST['key'] === 'qwertyupasdfghjklzxcvbnm') {

    $customerId = isset($_POST['customerId']) ? (int)$_POST['customerId'] : null;
    $user_updated_by = sanitizeInput($_POST['user_updated_by']);
    $b_acc_name_of_link = sanitizeInput($_POST['b_acc_name_of_link']);

    $b_acc_screenshot = sanitizeInput($_FILES['b_acc_screenshot']['name']);

    $requiredFields = [
        'customerId' => $customerId,
        'user_updated_by' => $user_updated_by,
        'b_acc_name_of_link' => $b_acc_name_of_link,
        'b_acc_screenshot' => $b_acc_screenshot
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
            $upcustDetails = getcustomer_byID($customerId);
            $file_name = $_FILES[$fileKey]["name"];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $customer_img_name = $fileKey . '_' . rand() . '_' . time() . "_" . strtolower(str_replace(" ", "_", $upcustDetails['cust_first_name'] . '.' . $file_ext));
            $path = '../' . $config['Images'] . $customer_img_name;

            if (move_uploaded_file($_FILES[$fileKey]["tmp_name"], $path)) {
                unlink('../' . $config['Images'] . $upcustDetails[$columnName]);
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
        $sql = "UPDATE customer SET b_acc_name_of_link=?, user_updated_by=?,bank_acc_opening_approvedby=?,bank_acc_opening=? WHERE cust_id=?";
        $stmt = mysqli_prepare($link, $sql);
        $bank_acc_opening = 'Y';
        mysqli_stmt_bind_param($stmt, 'siisi', $b_acc_name_of_link, $user_updated_by, $user_updated_by, $bank_acc_opening, $customerId);
        if (mysqli_stmt_execute($stmt)) {
            $last_inserted_id = mysqli_insert_id($link);
            handleFileUpload("b_acc_screenshot", "b_acc_screenshot", $customerId);
            $response = ['status' => true, 'message' => 'Bank Account Opening procedure has been update successfully.'];
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
