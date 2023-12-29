<?php
include("../system_config.php");

function sanitizeInput($data)
{
    return htmlspecialchars(strip_tags(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['key']) && $_POST['key'] === 'qwertyupasdfghjklzxcvbnm') {
    if (isset($_POST['user_id'])) {
        $userId = sanitizeInput($_POST['user_id']);
        $user_query = "SELECT * FROM " . tbl_user . " WHERE user_id = $userId";
        $result = mysqli_query($link, $user_query);

        if ($result && mysqli_num_rows($result) > 0) {
            $userData = mysqli_fetch_assoc($result);
            $userData['user_logo'] = SITEPATH . (($userData['user_logo']) ? $config['Images'] .  $userData['user_logo'] : NOIMAGE);

            $response = array(
                'status' => true,
                'user' => $userData
            );

            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode($response);
            exit;
        } else {
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode(['status' => false, 'error' => 'User not found']);
            exit;
        }
    } else {
        $user_query = "SELECT user_id, first_name FROM " . tbl_user . " WHERE user_status = '0' ORDER BY user_id DESC";
        $result = mysqli_query($link, $user_query);

        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        $response = array(
            'status' => true,
            'users' => $data
        );

        header('Content-Type: application/json');
        http_response_code(200);
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
