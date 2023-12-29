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

    if ($custExist && !$customerId) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['status' => false, 'error' => 'You are already registered. Our team will connect with you shortly.']);
        exit;
    } else {
        // Prepare SQL statement based on whether it's an insert or update
        if ($customerId) {
            // Update existing customer
            $sql = "UPDATE customer SET cust_first_name=?, cust_aadhar_no=?, cust_alter_phone=?, cust_phone=?, cust_password=?, cust_state=?, cust_district_id=?, cust_taluka_id=?, cust_pincode=?, cust_address=? WHERE cust_id=?";
            $stmt = mysqli_prepare($link, $sql);

            // Note the correct order of parameters in the next line
            mysqli_stmt_bind_param($stmt, 'ssssssssssi', $first_name, $cust_aadhar_no, $cust_alter_phone, $phone, $hashed_password, $cust_state, $cust_district_id, $cust_taluka_id, $cust_pincode, $cust_address, $customerId);
        } else {

            // Insert new customer
            $sql = "INSERT INTO customer (cust_first_name, cust_aadhar_no, cust_email, cust_phone, cust_alter_phone, cust_state, cust_district_id, cust_taluka_id, cust_pincode, cust_address, cust_password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, 'sssssssssss', $first_name, $cust_aadhar_no, $email, $phone, $cust_alter_phone, $cust_state, $cust_district_id, $cust_taluka_id, $cust_pincode, $cust_address, $hashed_password);
        }
        // Execute the SQL statement
        if (mysqli_stmt_execute($stmt)) {
            // Registration/update successful
            if ($customerId) {
                // If it's an update, handle file upload for cust_profile
                if (!empty($_FILES["cust_selfie"]["name"]) && $_FILES["cust_selfie"]["error"] == 0) {
                    $file_name = $_FILES["cust_selfie"]["name"];
                    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                    $customer_img_name = $first_name . '_' . rand() . '_' . microtime() . "_" . strtolower(str_replace(" ", "_", $last_name . '.' . $file_ext));
                    $path = ABSPATH . $config['Images'] . $customer_img_name;
                    if (move_uploaded_file($_FILES["cust_selfie"]["tmp_name"], $path)) {
                        // image unlink 
                        $custDetails = getcustomer_byID($customerId);
                        unlink(ABSPATH . $config['Images'] . $custDetails['cust_selfie']);
                        $update_sql = "UPDATE customer SET cust_selfie = ? WHERE cust_id = ?";
                        $update_stmt = mysqli_prepare($link, $update_sql);
                        mysqli_stmt_bind_param($update_stmt, 'si', $customer_img_name, $customerId);
                        mysqli_stmt_execute($update_stmt);
                    }
                }

                $response = ['status' => true, 'message' => 'Your Profile has been updated successfully.'];
                http_response_code($customerId ? 200 : 201);
                header('Content-Type: application/json');
                echo json_encode($response);
                exit;
            }

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
