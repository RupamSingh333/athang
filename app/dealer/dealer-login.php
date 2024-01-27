<?php
include("./system_config.php");
$url_return = SITEPATH . 'index.php';
$dealer_email = $_REQUEST['username'];
$password = $_REQUEST['password'];

if (!filter_var($dealer_email, FILTER_VALIDATE_EMAIL)) {
    $emailErr = "Invalid email format";
    $_SESSION['msg'] = $emailErr;
    $_SESSION['alert_type'] = 'error';
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}

$sql = "SELECT dealer_id, dealer_name, dealer_email, dealer_status FROM dealer WHERE dealer_email = ? AND password = ?";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, 'ss', $dealer_email, encryptIt($password));
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    if ($row['dealer_status'] == 0) {
        $_SESSION['dealerId'] = $row['dealer_id'];
        $fistName = explode(' ', $row['dealer_name']);
        $_SESSION['dealerName'] = $fistName[0];
        $_SESSION['type'] = 5;
        header("Location: " . SITEPATH);
        exit;
    } else {
        $_SESSION['msg'] = 'You are already registered. Our team will connect with you shortly.';
    }
} else {
    $_SESSION['msg'] = 'Authorization failed. Please try again.';
}

$_SESSION['alert_type'] = 'error';
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
