<?php
include("./system_config.php");

$field = array();

if ($_POST['customerId'] == 'New') {

	$required_fields = array('cust_first_name', 'cust_last_name', 'cust_email', 'cust_phone', 'cust_password', 'cust_state', 'cust_city', 'cust_billing_address');

	foreach ($required_fields as $field_name) {
		$field_value = get_safe_post($field_name);
		if (empty($field_value)) {
			$errors[] = ucfirst(str_replace('_', ' ', $field_name)) . " is required.";
		}
	}

	// Check if there are any validation errors
	if ($errors != '') {
		$_SESSION['msg'] = implode(",", $errors);
		$_SESSION['alert_type'] = 'error';
		header("Location: " . $_SERVER['HTTP_REFERER']);
		exit;
	}

	$checkDealer = getcustomer_byID($_POST['cust_email']);

	if ($checkDealer) {
		$_SESSION['msg'] = "You are already registered. Our team will connect with you shortly.";
		$_SESSION['alert_type'] = 'warning';
		header("Location: " . $_SERVER['HTTP_REFERER']);
		exit;
	} else {

		$field['cust_first_name'] = get_safe_post('cust_first_name');
		$field['cust_last_name'] = get_safe_post('cust_last_name');
		$field['cust_email'] = get_safe_post('cust_email');
		$field['cust_phone'] = get_safe_post('cust_phone');
		$field['cust_password'] = encryptIt(get_safe_post('cust_password'));
		$field['cust_state'] = get_safe_post('cust_state');
		$field['cust_city'] = get_safe_post('cust_city');
		$field['cust_billing_address'] = get_safe_post('cust_billing_address');
		$field['cust_status'] = 1;
		$field['cust_country'] = 101;


		//Profile image
		if ($_FILES["cust_profile"]["error"] == 0) {
			$file_name = $_FILES["cust_profile"]["name"];
			$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
			$unique_name = time() . "_" . uniqid() . strtolower(str_replace(" ", "_", $field['dealer_name'])) . '_profile';
			$customer_img_name = $unique_name . '.' . $file_ext;
			$path = ABSPATH . $config['Images'] . $customer_img_name;
			if (move_uploaded_file($_FILES["cust_profile"]["tmp_name"], $path)) {
				$field['cust_profile'] = $customer_img_name;
			}
		}

		$_SESSION['msg'] = "Your registration procedure has been completed. Our team will connect with you shortly.";
		$output = save_command(tbl_customer, $field, "cust_id", $primary_value);
		$_SESSION['alert_type'] = 'success';
		header("Location: " . $_SERVER['HTTP_REFERER']);
		exit;
	}
} else if (isset($_POST['customerId'])) {

	
	// Validate required fields
	// if (empty($field['cust_phone']) || empty($field['cust_billing_address']) || empty($field['cust_pincode']) || empty($field['cust_state']) || empty($field['cust_city'])) {

	// 	$_SESSION['msg'] = 'Please fill in all required fields.';
	// 	$_SESSION['alert_type'] = 'error';
	// 	header("Location: " . $_SERVER['HTTP_REFERER']);
	// 	exit;
	// }
	
	$primary_value = decryptIt(get_safe_post('customerId'));

	$field = array();
	$field['cust_first_name'] = trim(get_safe_post('cust_first_name'));
	$field['cust_last_name'] = trim(get_safe_post('cust_last_name'));
	$field['cust_phone'] = get_safe_post('cust_phone');
	$field['cust_billing_address'] = get_safe_post('cust_billing_address');
	$field['cust_pincode'] = get_safe_post('cust_pincode');
	$field['cust_state'] = get_safe_post('cust_state');
	$field['cust_city'] = get_safe_post('cust_city');
	// pr($field);

	if (!empty($_FILES["cust_profile"]["name"]) && $_FILES["cust_profile"]["error"] == 0) {
		$file_name = $_FILES["cust_profile"]["name"];
		$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
		$customer_img_name = $field['cust_first_name'] . '_' . rand() . '_' . time() . "_" . strtolower(str_replace(" ", "_", $field['cust_last_name'] . '.' . $file_ext));
		$path = ABSPATH . $config['Images'] . $customer_img_name;
		// pr($path);
		if (move_uploaded_file($_FILES["cust_profile"]["tmp_name"], $path)) {
			$field['cust_profile'] = $customer_img_name;
		}

		if ($primary_value) {
			$custDetails = getcustomer_byID($primary_value);
			unlink(ABSPATH . $config['Images'] . $custDetails['cust_profile']);
		}
	}


	$output = save_command(tbl_customer, $field, "cust_id", $primary_value);
	$_SESSION['msg'] = 'Your Profile has been updated successfully.';
	$_SESSION['alert_type'] = 'success';
	header("Location: " . $_SERVER['HTTP_REFERER']);
	exit;
} else {
	$_SESSION['msg'] = "You are not authorized at this location. Please try again.";
	$_SESSION['alert_type'] = 'error';
	header("Location: " . $_SERVER['HTTP_REFERER']);
	exit;
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
