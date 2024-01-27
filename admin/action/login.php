<?php
include("../../system_config.php");
$action = get_safe_get('action');
$url_return = "../index.php";
switch ($action) {
	case "login":
		$login_detail = array();
		$FileName = $_POST['txt_userId'];
		$FileName2 = $_POST['txt_password'];
		$email = $_POST['txt_userId'];
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$emailErr = "Invalid email format";
			$_SESSION['msg'] = $emailErr;
		} else {
			$login_detail['user_email'] = $FileName;
			$login_detail['user_pass'] = $FileName2;
			$authorization = check_authorization($login_detail);
			// print_r($authorization);
			// die;
			if (!isset($authorization['error'])) {
				$_SESSION['AdminLogin'] = $authorization['user_id'];
				$_SESSION['type'] = $authorization['user_type'];
				$url_return = "../dashboard.php";
			} else {
				$_SESSION['msg'] = "Authorization failed. Please try again.";
			}
		}
		break;
	default:
		break;
}
header("Location:" . $url_return);
