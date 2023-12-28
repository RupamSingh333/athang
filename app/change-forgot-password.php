<?php
include("./system_config.php");
// print_r($_POST);die;
$role = $_POST['role'];
$dates = date('Y-m-d');

if (isset($_POST['dealerId'])) {

    $encPass = encryptIt($_POST['oldpassword']);
    $dealerId = decryptIt($_POST['dealerId']);

    // Code for dealer
    $sql = "SELECT * FROM dealer WHERE dealer_id=? AND password=? AND dealer_status='0' LIMIT 1";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "ss",  $dealerId,  $encPass);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        if ($_POST["newpassword"] == $_POST["cpassword"]) {
            $sql = "UPDATE `dealer` SET `password` = ? WHERE `dealer`.`dealer_id` = ?";
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, "si", encryptIt($_POST["newpassword"]), $dealerId);
            mysqli_stmt_execute($stmt);
            $_SESSION['msg'] = "Your Password has been updated successfully.";
            $_SESSION['alert_type'] = 'success';
        } else {
            $_SESSION['msg'] = "Your New Password and Confirm Password both not same";
            $_SESSION['alert_type'] = 'error';
        }
    } else {
        $_SESSION['msg'] = "Your old Password not match Please enter correct old Password.";
        $_SESSION['alert_type'] = 'error';
    }
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
} else if (isset($_POST['customerId'])) {

    $encPass = encryptIt($_POST['oldpassword']);
    $customerId = decryptIt($_POST['customerId']);

    $sql = "SELECT * FROM customer WHERE cust_id=? AND cust_password=? AND cust_status='0' LIMIT 1";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "ss",  $customerId, $encPass);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        if ($_POST["newpassword"] == $_POST["cpassword"]) {
            $sql = "UPDATE `customer` SET `cust_password` = ? WHERE `customer`.`cust_id` = ?";
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, "si", encryptIt($_POST["newpassword"]), $customerId);
            mysqli_stmt_execute($stmt);
            $_SESSION['msg'] = "Your Password has been updated successfully.";
            $_SESSION['alert_type'] = 'success';
        } else {
            $_SESSION['msg'] = "Your New Password and Confirm Password both not same";
            $_SESSION['alert_type'] = 'error';
        }
    } else {
        $_SESSION['msg'] = "Your old Password not match Please enter correct old Password.";
        $_SESSION['alert_type'] = 'error';
    }
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
} elseif ($role === 'customer') {
    $customerEmail = $_POST['email'];

    $sql = "SELECT * FROM customer WHERE cust_email=? AND cust_status='0' LIMIT 1";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "s", $customerEmail);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $randomString = generateRandomString(10);
        $customerId = $row['cust_id'];

        $sql = "UPDATE customer SET cust_forgot_string=? WHERE cust_id=?";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $randomString, $customerId);
        mysqli_stmt_execute($stmt);
        $link = SITEPATH . "authurised/" . $randomString;

        $to = $customerEmail;
        $subject = "Forgot Password";
        $message = "Dear Customer, you have requested to reset your password. Please click on the following link to reset your password: " . $link;
        $headers = "From: rupam@doomshell.com";

        if (mail($to, $subject, $message, $headers)) {
            $_SESSION['msg'] = "Password reset email sent to the customer.";
            $_SESSION['alert_type'] = 'success';
        } else {
            $_SESSION['msg'] = "Failed to send the password reset email.";
            $_SESSION['alert_type'] = 'error';
        }
    } else {
        $_SESSION['msg'] = "Invalid email address.";
        $_SESSION['alert_type'] = 'error';
    }
} elseif ($role === 'dealer') {
    $_SESSION['msg'] = "We are working on this module";
    $_SESSION['alert_type'] = 'error';
} else {
    $_SESSION['msg'] = "Invalid request.";
    $_SESSION['alert_type'] = 'error';
}
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;

// header('Location: account-settings');
