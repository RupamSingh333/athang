<?php
include("../system_config.php");

function sanitizeInput($data)
{
    return htmlspecialchars(strip_tags(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['key']) && $_POST['key'] === 'qwertyupasdfghjklzxcvbnm') {
    if (isset($_POST['cust_id'])) {
        $customerId = sanitizeInput($_POST['cust_id']);
        $customer_query = "SELECT * FROM " . tbl_customer . " WHERE cust_id = $customerId";
        $result = mysqli_query($link, $customer_query);

        if ($result && mysqli_num_rows($result) > 0) {
            $customerData = mysqli_fetch_assoc($result);
            $customerData['cust_selfie'] = SITEPATH . (($customerData['cust_selfie']) ? $config['Images'] .  $customerData['cust_selfie'] : NOIMAGE);

            $customerData['cust_agreement_copy'] = SITEPATH . (($customerData['cust_agreement_copy']) ? $config['Images'] .  $customerData['cust_agreement_copy'] : NOIMAGE);

            $customerData['cust_signature'] = SITEPATH . (($customerData['cust_signature']) ? $config['Images'] .  $customerData['cust_signature'] : NOIMAGE);

            $customerData['cust_pan_card'] = SITEPATH . (($customerData['cust_pan_card']) ? $config['Images'] .  $customerData['cust_pan_card'] : NOIMAGE);

            $customerData['cust_aadhar_card_back'] = SITEPATH . (($customerData['cust_aadhar_card_back']) ? $config['Images'] .  $customerData['cust_aadhar_card_back'] : NOIMAGE);

            $customerData['cust_aadhar_card_front'] = SITEPATH . (($customerData['cust_aadhar_card_front']) ? $config['Images'] .  $customerData['cust_aadhar_card_front'] : NOIMAGE);


            $response = array(
                'status' => true,
                'customer' => $customerData
            );

            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode($response);
            exit;
        } else {
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode(['status' => false, 'error' => 'Customer not found']);
            exit;
        }
    } else {
        $customer_query = "SELECT * FROM " . tbl_customer . " WHERE cust_status = '0' ORDER BY cust_id DESC";
        $result = mysqli_query($link, $customer_query);

        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        $response = array(
            'status' => true,
            'customers' => $data
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
