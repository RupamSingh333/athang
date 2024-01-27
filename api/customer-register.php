<?php
include("../system_config.php");

function sanitizeInput($data)
{
    return htmlspecialchars(strip_tags(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['key']) && $_POST['key'] === 'qwertyupasdfghjklzxcvbnm') {

    // Get and sanitize user input
    $customerId = isset($_POST['customerId']) ? (int)$_POST['customerId'] : null;
    $first_name = sanitizeInput($_POST['cust_first_name']);
    $email = sanitizeInput($_POST['cust_email']);
    $phone = sanitizeInput($_POST['cust_phone']);
    $cust_alter_phone = sanitizeInput($_POST['cust_alter_phone']);
    $cust_aadhar_no = sanitizeInput($_POST['cust_aadhar_no']);
    $cust_state = sanitizeInput($_POST['cust_state']);
    $cust_district_id = sanitizeInput($_POST['cust_district_id']);
    $cust_taluka_id = sanitizeInput($_POST['cust_taluka_id']);
    $cust_pincode = sanitizeInput($_POST['cust_pincode']);
    $cust_address = sanitizeInput($_POST['cust_address']);
    $password = sanitizeInput($_POST['cust_password']);
    $hashed_password = encryptIt($password);

    $cust_pan_card = sanitizeInput($_FILES['cust_pan_card']['name']);
    $cust_aadhar_card_front = sanitizeInput($_FILES['cust_aadhar_card_front']['name']);
    $cust_aadhar_card_back = sanitizeInput($_FILES['cust_aadhar_card_back']['name']);

    // Validate required fields
    $requiredFields = [
        'first_name' => $first_name,
        'email' => $email,
        'phone' => $phone,
        'password' => $password,
        'cust_aadhar_no' => $cust_aadhar_no,
        'cust_district_id' => $cust_district_id,
        'cust_taluka_id' => $cust_taluka_id,
        'cust_state' => $cust_state,
        'cust_address' => $cust_address,
        'cust_pincode' => $cust_pincode,
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
    $custExist = getcustomer_byID($email);

    // fileupload funtion 
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


    if ($custExist && !$customerId) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['status' => false, 'error' => 'You are already registered. Our team will connect with you shortly.']);
        exit;
    } else {
        if ($customerId) {
            $sql = "UPDATE customer SET cust_first_name=?, cust_aadhar_no=?, cust_alter_phone=?, cust_phone=?, cust_password=?, cust_state=?, cust_district_id=?, cust_taluka_id=?, cust_pincode=?, cust_address=? WHERE cust_id=?";
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, 'ssssssssssi', $first_name, $cust_aadhar_no, $cust_alter_phone, $phone, $hashed_password, $cust_state, $cust_district_id, $cust_taluka_id, $cust_pincode, $cust_address, $customerId);
        } else {
            $sql = "INSERT INTO customer (cust_first_name, cust_aadhar_no, cust_email, cust_phone, cust_alter_phone, cust_state, cust_district_id, cust_taluka_id, cust_pincode, cust_address, cust_password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, 'sssssssssss', $first_name, $cust_aadhar_no, $email, $phone, $cust_alter_phone, $cust_state, $cust_district_id, $cust_taluka_id, $cust_pincode, $cust_address, $hashed_password);
        }
        if (mysqli_stmt_execute($stmt)) {
            $last_inserted_id = mysqli_insert_id($link);
            if ($customerId) {

                handleFileUpload("cust_pan_card", "cust_pan_card", $customerId);
                handleFileUpload("cust_aadhar_card_front", "cust_aadhar_card_front", $customerId);
                handleFileUpload("cust_aadhar_card_back", "cust_aadhar_card_back", $customerId);
                $response = ['status' => true, 'message' => 'Your Profile has been updated successfully.'];
                http_response_code($customerId ? 200 : 201);
                header('Content-Type: application/json');
                echo json_encode($response);
                exit;
            }

            handleFileUpload("cust_pan_card", "cust_pan_card", $last_inserted_id);
            handleFileUpload("cust_aadhar_card_front", "cust_aadhar_card_front", $last_inserted_id);
            handleFileUpload("cust_aadhar_card_back", "cust_aadhar_card_back", $last_inserted_id);

            $response = ['status' => true, 'message' => 'Your registration procedure has been completed. Our team will connect with you shortly.'];
            http_response_code($customerId ? 200 : 201);
        } else {
            // Registration/update failed
            $response = ['status' => false, 'error' => 'Registration/update failed. Please try again.'];
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
