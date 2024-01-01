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
    $cust_pan_card = sanitizeInput($_FILES['cust_pan_card']['name']);
    $cust_aadhar_card_front = sanitizeInput($_FILES['cust_aadhar_card_front']['name']);
    $cust_aadhar_card_back = sanitizeInput($_FILES['cust_aadhar_card_back']['name']);

    $requiredFields = [
        'Organizer Name' => $cust_org_name,
        'Organizer Type' => $cust_org_type,
        'User Login Id' => $user_updated_by,
        'Selfie' => $cust_selfie,
        'cust_agreement_copy' => $cust_agreement_copy,
        'cust_signature' => $cust_signature,
        'cust_pan_card' => $cust_pan_card,
        'cust_aadhar_card_front' => $cust_aadhar_card_front,
        'cust_aadhar_card_back' => $cust_aadhar_card_back
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
            $upcustDetails = getcustomer_byID($customerId); // Optional, depending on your requirements
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
                // echo "Database update successful";
                // } else {
                //     echo "Database update failed: " . mysqli_error($link);
                // }
            }
        }
    }


    if ($custDetails && !$customerId) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['status' => false, 'error' => 'You are already registered. Our team will connect with you shortly.']);
        exit;
    } else {
        $sql = "UPDATE customer SET cust_org_name=?, cust_org_type=? ,user_updated_by=?,shop_act_licence=? WHERE cust_id=?";
        $stmt = mysqli_prepare($link, $sql);
        $shop_act_licence = 'Y';
        mysqli_stmt_bind_param($stmt, 'ssssi', $cust_org_name, $cust_org_type, $user_updated_by, $shop_act_licence, $customerId);
        if (mysqli_stmt_execute($stmt)) {

            handleFileUpload("cust_selfie", "cust_selfie", $customerId);
            handleFileUpload("cust_agreement_copy", "cust_agreement_copy", $customerId);
            handleFileUpload("cust_signature", "cust_signature", $customerId);
            handleFileUpload("cust_pan_card", "cust_pan_card", $customerId);
            handleFileUpload("cust_aadhar_card_front", "cust_aadhar_card_front", $customerId);
            handleFileUpload("cust_aadhar_card_back", "cust_aadhar_card_back", $customerId);

            $response = ['status' => true, 'message' => 'Shop Act procedure has been update successfully.'];
            http_response_code($customerId ? 200 : 201);
        } else {
            // Registration/update failed
            $response = ['status' => false, 'error' => 'Data not upldate please try after some time.'];
            http_response_code(500);
        }

        // Send the JSON response
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
