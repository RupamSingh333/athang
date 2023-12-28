<?php
include("../../system_config.php");

if (!empty($_POST['cust_email'])) {
	$email = $_POST['cust_email'];
	$sql_check = mysqli_query($link, "SELECT cust_email FROM customer WHERE cust_email='$email'");
	$row1 = mysqli_fetch_row($sql_check);
	if (!empty($row1)) {
		echo '<div style="color:#c40000;"><STRONG>' . $email . '</STRONG> is already in use.</div>';
	} else {
		echo 'OK';
	}
}
