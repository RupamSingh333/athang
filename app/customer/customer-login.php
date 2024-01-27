<?php
include("./system_config.php");
$dates = date('Y-m-d');
$customer_email = $_REQUEST['username'];
$password = $_REQUEST['password'];

$sql = "SELECT cust_email,cust_id,cust_status,cust_first_name,cust_last_name FROM customer WHERE cust_email = ? AND cust_password = ?";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, 'ss', $customer_email, encryptIt($password));
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 1) {
	$row = mysqli_fetch_assoc($result);
	// print_r($row);die;
	if ($row['cust_status'] == 0) {
		$_SESSION['customerId'] = $row['cust_id'];
		$_SESSION['customerName'] = $row['cust_first_name'];
		$_SESSION['type'] = 4; //For customer 4
		header("Location: " . SITEPATH);
		exit;
	} else {
		$_SESSION['msg'] = 'You account is under review. Our team will connect with you shortly.';
	}
} else {
	$_SESSION['msg'] = 'Authorization failed. Please try again.';
}

$_SESSION['alert_type'] = 'error';
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
