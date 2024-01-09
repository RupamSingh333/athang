<?php
include("../system_config.php");

function sanitizeInput($data)
{
    return htmlspecialchars(strip_tags(trim($data)));
}

function getResults($link, $query, $key)
{
    $result = mysqli_query($link, $query);
    $data = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    $response = array(
        'status' => true,
        $key => $data
    );

    header('Content-Type: application/json');
    http_response_code(200);
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['key']) && $_POST['key'] === 'qwertyupasdfghjklzxcvbnm') {

    if (!empty($_POST['countryId'])) {
        $countryId = sanitizeInput($_POST['countryId']);
        $state_query = "SELECT id, name FROM states WHERE country_id = $countryId";
        getResults($link, $state_query, 'states');
    } elseif (!empty($_POST['stateId'])) {
        $stateId = sanitizeInput($_POST['stateId']);
        $district_query = "SELECT district_id, district_name FROM district WHERE state_id = $stateId";
        getResults($link, $district_query, 'districts');
    } elseif (!empty($_POST['distId'])) {
        $distId = sanitizeInput($_POST['distId']);
        $district_query = "SELECT taluka_id, taluka_name FROM taluka WHERE taluka_district_id = $distId";
        getResults($link, $district_query, 'talukas');
    } elseif (!empty($_POST['action'])) {
        $action = sanitizeInput($_POST['action']);
        if ($action == 'bank_links') {
            $bank_links = "SELECT * FROM `bank_link` WHERE status = 'Y' ORDER BY bank_link_id DESC";
            getResults($link, $bank_links, 'bank_link');
        } else if ($action == 'demat_links') {
            $demat_links = "SELECT * FROM `demat_link` WHERE status = 'Y' ORDER BY demat_link_id DESC";
            getResults($link, $demat_links, 'demat_link');
        }
    }
    

    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode(['status' => false, 'error' => 'Invalid request method or key']);
    exit;
} else {
    // Invalid request method or key
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode(['status' => false, 'error' => 'Invalid request method or key']);
    exit;
}
