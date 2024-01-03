<?php
include("../system_config.php");

function sanitizeInput($data)
{
    return htmlspecialchars(strip_tags(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['key']) && $_POST['key'] === 'qwertyupasdfghjklzxcvbnm') {

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

    if ($custDetails && !$customerId) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['status' => false, 'error' => 'Invalid customer details.']);
        exit;
    } else {
        $sql = "UPDATE customer SET  user_updated_by=?,food_licence_approvedby=?,food_licence=? WHERE cust_id=?";
        $stmt = mysqli_prepare($link, $sql);
        $food_licence = 'Y';
        mysqli_stmt_bind_param($stmt, 'issi',  $user_updated_by, $user_updated_by, $food_licence, $customerId);
        if (mysqli_stmt_execute($stmt)) {
            $response = ['status' => true, 'message' => 'Food License procedure has been update successfully.'];
            http_response_code($customerId ? 200 : 201);
        } else {
            $response = ['status' => false, 'error' => 'Data not update please try after some time.'];
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
