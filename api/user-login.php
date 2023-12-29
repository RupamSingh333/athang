<?php
include("./system_config.php");
include('../admin/common/head.php');


// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['key']=='qwertyupasdfghjklzxcvbnm' && isset($_POST['username'], $_POST['password'], $_POST['userType'])) {

    $email = sanitizeInput($_POST['username']);
    $password = sanitizeInput($_POST['password']);
    $userType = sanitizeInput($_POST['userType']);

    if ($userType == 'C' || $userType == 'c') {
        $sql = "SELECT cust_email, cust_id, cust_status, cust_first_name, cust_last_name, cust_password FROM customer WHERE cust_email = ?";
    } elseif ($userType == 'D' || $userType == 'd') {
        $sql = "SELECT dealer_id, dealer_name, dealer_email, password, dealer_status FROM dealer WHERE dealer_email = ?";
    } else {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['status' => false, 'error' => 'Invalid user type']);
        exit;
    }

    $response = handleLogin($sql, $email, $password, $userType);

    http_response_code($response['status'] ? 200 : 401);
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
} else {
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode(['status' => false, 'error' => 'Invalid request']);
    exit;
}



function sanitizeInput($data)
{
    return htmlspecialchars(strip_tags(trim($data)));
}

function handleLogin($sql, $email, $password, $userType)
{
    global $link;

    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        if ($userType == 'C' || $userType == 'c') {
            if (encryptIt($password) == $row['cust_password']) {
                return handleCustomerLogin($row);
            }
        } elseif ($userType == 'D' || $userType == 'd') {
            if (encryptIt($password) == $row['password']) {
                return handleDealerLogin($row);
            }
        }
    }

    return ['status' => false, 'error' => 'Authorization failed'];
}

// Function to handle customer login
function handleCustomerLogin($row)
{
    if ($row['cust_status'] == 0) {
        return [
            'status' => true,
            'customerId' => $row['cust_id'],
            'customerName' => $row['cust_first_name'],
            'type' => 4,
        ];
    } else {
        return ['status' => false, 'error' => 'Account under review'];
    }
}

// Function to handle dealer login
function handleDealerLogin($row)
{
    if ($row['dealer_status'] == 0) {
        return [
            'status' => true,
            'dealerId' => $row['dealer_id'],
            'dealerName' => $row['dealer_name'],
            'type' => 5,
        ];
    } else {
        return [
            'status' => false,
            'error' => 'You are already registered. Our team will connect with you shortly.',
        ];
    }
}
