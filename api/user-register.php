<?php
include("../system_config.php");

function sanitizeInput($data)
{
    return htmlspecialchars(strip_tags(trim($data)));
}

// fileUpload Function 
function handleFileUpload($fileKey, $columnName, $userId)
{
    global $link, $config;

    if (!empty($_FILES[$fileKey]["name"]) && $_FILES[$fileKey]["error"] == 0) {
        $getUserById = getuser_byID($userId);

        $userNameWithoutSpacesLowercase = strtolower(str_replace(' ', '', $getUserById['first_name']));
        $phone = empty($getUserById['user_phone']) ? 'NoPhone' : $getUserById['user_phone'];
        $imageName = $userNameWithoutSpacesLowercase . '_' . $phone;

        $file_name = $_FILES[$fileKey]["name"];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $customer_img_name = $imageName . '_' . time() . '_' . $fileKey . "." . $file_ext;
        $path = '../' . $config['Images'] . $customer_img_name;

        if (move_uploaded_file($_FILES[$fileKey]["tmp_name"], $path)) {
            unlink('../' . $config['Images'] . $getUserById[$columnName]);
            $update_sql = "UPDATE reg_user SET $columnName = ? WHERE user_id = ?";
            $update_stmt = mysqli_prepare($link, $update_sql);
            mysqli_stmt_bind_param($update_stmt, 'si', $customer_img_name, $userId);
            mysqli_stmt_execute($update_stmt);
        }
    }
}

// Multiple File Upload 
function handleMultipleFileUpload($fileKey, $columnName, $userId)
{
    global $link, $config;

    $existingFilenames = explode(',', getuser_byID($userId)[$columnName]);
    $imageNames = [];
    foreach ($_FILES[$fileKey]['name'] as $index => $filename) {
        if ($_FILES[$fileKey]['error'][$index] == 0) {
            $getUserById = getuser_byID($userId);
            $customerNameWithoutSpacesLowercase = strtolower(str_replace(' ', '', $getUserById['first_name']));
            $imageName = $customerNameWithoutSpacesLowercase;
            
            $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $user_img_name = $imageName . '_' . time() . '_' . $fileKey . $index . "." . $file_ext;
            $path = "../" . $config['Images'] . $user_img_name;
            
            if (move_uploaded_file($_FILES[$fileKey]["tmp_name"][$index], $path)) {
                $imageNames[] = $user_img_name;
            }
        }
    }
    
    // Unlink existing files that are not present in the new list
    foreach ($existingFilenames as $existingFilename) {
        if (!in_array($existingFilename, $imageNames)) {
            unlink("../" . $config['Images'] . $existingFilename);
        }
    }

    // Update the database with the comma-separated list of image names
    if (!empty($imageNames)) {
        $newImageNames = implode(',', $imageNames);
        $update_sql = "UPDATE reg_user SET $columnName = ? WHERE user_id = ?";
        $update_stmt = mysqli_prepare($link, $update_sql);
        mysqli_stmt_bind_param($update_stmt, 'si', $newImageNames, $userId);
        mysqli_stmt_execute($update_stmt);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['key']) && $_POST['key'] === 'qwertyupasdfghjklzxcvbnm') {

    // Validate and sanitize user ID
    $userId = isset($_POST['userId']) ? (int)$_POST['userId'] : null;
    if ($userId) {
        $userExist = getuser_byID($userId);
        if (!$userExist) {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(['status' => false, 'error' => 'Invalid User ID']);
            exit;
        }
    }


    $first_name = sanitizeInput($_POST['first_name']);
    $email = sanitizeInput($_POST['user_email']);
    $phone = sanitizeInput($_POST['user_phone']);
    $user_state = sanitizeInput($_POST['user_state']);
    $user_district = sanitizeInput($_POST['user_district']);
    $taluka_id = sanitizeInput($_POST['taluka_id']);
    $user_tel = sanitizeInput($_POST['user_tel']);
    $user_address = sanitizeInput($_POST['user_address']);
    $password = sanitizeInput($_POST['user_pass']);
    $user_type = sanitizeInput($_POST['user_type']);
    $hashed_password = encryptIt($password);
    $user_logo = sanitizeInput($_FILES['user_logo']['name']);

    $alter_mobile_number = sanitizeInput($_POST['alter_mobile_number']);
    $reference1_name = sanitizeInput($_POST['reference1_name']);
    $reference1_mobile_number = sanitizeInput($_POST['reference1_mobile_number']);
    $reference1_relation = sanitizeInput($_POST['reference1_relation']);
    $reference2_name = sanitizeInput($_POST['reference2_name']);
    $reference2_mobile_number = sanitizeInput($_POST['reference2_mobile_number']);
    $reference2_relation = sanitizeInput($_POST['reference2_relation']);

    // Validate required fields
    $requiredFields = [
        'first_name' => $first_name,
        'email' => $email,
        'phone' => $phone,
        'password' => $password,
        'user_state' => $user_state,
        'user_district' => $user_district,
        'taluka_id' => $taluka_id,
        'user_address' => $user_address,
        'user_tel' => $user_tel,
        'user_logo' => $user_logo
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

    // Check if the user already exists
    $userExist = getuser_byID($email);

    if ($userExist && !$userId) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['status' => false, 'error' => 'You are already registered. Our team will connect with you shortly.']);
        exit;
    }

    // Prepare and execute SQL query
    if ($userId) {
        $sql = "UPDATE reg_user SET first_name=?, user_pass=?, user_phone=?, user_state=?, user_district=?, taluka_id=?, user_tel=?, user_address=?, user_type=?, alter_mobile_number=?, reference1_name=?, reference1_mobile_number=?, reference1_relation=?, reference2_name=?, reference2_mobile_number=?, reference2_relation=? WHERE user_id=?";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            'ssssssssssssssssi',
            $first_name,
            $hashed_password,
            $phone,
            $user_state,
            $user_district,
            $taluka_id,
            $user_tel,
            $user_address,
            $user_type,
            $alter_mobile_number,
            $reference1_name,
            $reference1_mobile_number,
            $reference1_relation,
            $reference2_name,
            $reference2_mobile_number,
            $reference2_relation,
            $userId
        );
    } else {
        $sql = "INSERT INTO reg_user (first_name, user_email, user_pass, user_phone, user_state, user_district, taluka_id, user_tel, user_address,user_type, alter_mobile_number, reference1_name, reference1_mobile_number, reference1_relation, reference2_name, reference2_mobile_number, reference2_relation) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($link, $sql);
        // Bind parameters to the prepared statement
        mysqli_stmt_bind_param(
            $stmt,
            'ssssiiississsssss',
            $first_name,
            $email,
            $hashed_password,
            $phone,
            $user_state,
            $user_district,
            $taluka_id,
            $user_tel,
            $user_address,
            $user_type,
            $alter_mobile_number,
            $reference1_name,
            $reference1_mobile_number,
            $reference1_relation,
            $reference2_name,
            $reference2_mobile_number,
            $reference2_relation
        );
    }

    if (!mysqli_stmt_execute($stmt)) {
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode(['status' => false, 'error' => 'Registration/update failed. ' . mysqli_error($link)]);
        exit;
    }

    // Handle file upload
    $last_inserted_id = $userId ? $userId : mysqli_insert_id($link);
    handleFileUpload("user_logo", "user_logo", $last_inserted_id);
    handleFileUpload("aadhar_front_image", "aadhar_front_image", $last_inserted_id);
    handleFileUpload("aadhar_back_image", "aadhar_back_image", $last_inserted_id);
    handleFileUpload("dl_front_image", "dl_front_image", $last_inserted_id);
    handleFileUpload("dl_back_image", "dl_back_image", $last_inserted_id);
    handleFileUpload("pan_card_image", "pan_card_image", $last_inserted_id);
    // multiple files upload 
    handleMultipleFileUpload("other_documents", "other_documents", $last_inserted_id);

    // Respond with success message
    $response = ['status' => true, 'message' => $userId ? 'Your Profile has been updated successfully.' : 'Your registration procedure has been completed. Our team will connect with you shortly.'];
    http_response_code($userId ? 200 : 201);
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
} else {
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode(['status' => false, 'error' => 'Invalid request method or key']);
    exit;
}
