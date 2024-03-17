<?php
include("../system_config.php");

function sanitizeInput($data)
{
    return htmlspecialchars(strip_tags(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['key']) && $_POST['key'] === 'qwertyupasdfghjklzxcvbnm') {

    // pr($_POST);exit;

    $customerId = isset($_POST['customerId']) ? (int)$_POST['customerId'] : null;
    $user_updated_by = sanitizeInput($_POST['user_updated_by']);

    $requiredFields = [
        'customerId' => $customerId,
        'user_updated_by' => $user_updated_by
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

    if (!$custDetails || !$customerId) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['status' => false, 'error' => 'Invalid customer details.']);
        exit;
    } else {


        $getFoodLicenceByCustId = getFoodLicenceByCustId($customerId);
        if ($getFoodLicenceByCustId) {
            $sql = "UPDATE food_licence SET user_updated_by=? WHERE customer_id=?";
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, 'si', $user_updated_by, $customerId);
            if (mysqli_stmt_execute($stmt)) {
                $response = ['status' => true, 'message' => 'Food license has been update successfully.'];
                http_response_code(200);
            } else {
                $response = ['status' => false, 'error' => 'Data not updated, please try again later.'];
                http_response_code(500);
            }
        } else {
            // Insert new record
            $sql = "INSERT INTO food_licence (customer_id, user_updated_by) VALUES (?, ?)";
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, 'is', $customerId, $user_updated_by);
            if (mysqli_stmt_execute($stmt)) {
                $response = ['status' => true, 'message' => 'New food license procedure has been added successfully.'];
                http_response_code(201);
            } else {
                $response = ['status' => false, 'error' => 'Data not inserted, please try again later.'];
                http_response_code(500);
            }
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
