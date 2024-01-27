<?php
include("./system_config.php");

$field = array();

$required_fields = array('dealer_name', 'dealer_email', 'dealer_phone', 'password', 'dealer_org_name', 'dealer_state', 'dealer_city', 'dealer_pincode');

foreach ($required_fields as $field_name) {
	$field_value = get_safe_post($field_name);
	if (empty($field_value)) {
		$errors[] = ucfirst(str_replace('_', ' ', $field_name)) . " is required.";
	} else {
		// Additional field-specific validation can be done here (e.g., email format, phone number format, etc.)
	}
}

// Check if there are any validation errors
if ($errors != '') {
	$_SESSION['msg'] = implode("<br>", $errors);
	$_SESSION['alert_type'] = 'error';
	header("Location: " . $_SERVER['HTTP_REFERER']);
	exit;
}

$field['dealer_name'] = get_safe_post('dealer_name');
$field['dealer_email'] = get_safe_post('dealer_email');
$field['dealer_phone'] = get_safe_post('dealer_phone');
$field['dealer_altenate_phone'] = get_safe_post('dealer_altenate_phone');
$field['password'] = encryptIt(get_safe_post('password'));
$field['dealer_org_name'] = get_safe_post('dealer_org_name');
$field['dealer_gst_no'] = get_safe_post('dealer_gst_no');
$field['dealer_pan_no'] = get_safe_post('dealer_pan_no');
$field['dealer_state'] = get_safe_post('dealer_state');
$field['dealer_city'] = get_safe_post('dealer_city');
$field['dealer_pincode'] = get_safe_post('dealer_pincode');
$field['dealer_desc'] = get_safe_post('dealer_desc');
// $field['dealer_billing_address'] = get_safe_post('dealer_billing_address');
$dealer_cate = get_safe_post('dealer_cate');
$field['dealer_status'] = 1;
if ($dealer_cate) {
	$field['dealer_cate'] = implode(',', $dealer_cate);
}
if ($field['dealer_country']) {
	$field['dealer_country'] = get_safe_post('dealer_country');
} else {
	$field['dealer_country'] = 101;
}


//dealer_profile image
if ($_FILES["dealer_profile"]["error"] == 0) {
	$file_name = $_FILES["dealer_profile"]["name"];
	$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
	$unique_name = time() . "_" . uniqid() . strtolower(str_replace(" ", "_", $field['dealer_name'])) . '_profile';
	$dealer_img_name = $unique_name . '.' . $file_ext;
	$path = ABSPATH . $config['Images'] . $dealer_img_name;
	if (move_uploaded_file($_FILES["dealer_profile"]["tmp_name"], $path)) {
		$field['dealer_profile'] = $dealer_img_name;
	}
}

//visiting_card image
if ($_FILES["visiting_card"]["error"] == 0) {
	$file_name = $_FILES["visiting_card"]["name"];
	$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
	$unique_name = time() . "_" . uniqid() . strtolower(str_replace(" ", "_", $field['dealer_name'])) . '_vist_card';
	$visiting_card_img_name = $unique_name . '.' . $file_ext;
	$path = ABSPATH . $config['Images'] . $visiting_card_img_name;
	if (move_uploaded_file($_FILES["visiting_card"]["tmp_name"], $path)) {
		$field['visiting_card'] = $visiting_card_img_name;
	}
}

$checkDealer = getDealerID($field['dealer_email']);
if ($checkDealer) {
	$_SESSION['msg'] = "You are already registered. Our team will connect with you shortly.";
	$_SESSION['alert_type'] = 'warning';
	header("Location: " . $_SERVER['HTTP_REFERER']);
	exit;
} else {
	$_SESSION['msg'] = "Your registration procedure has been completed. Our team will connect with you shortly.";
	$output = save_command(tbl_dealer, $field, "dealer_id", $primary_value);
	$_SESSION['alert_type'] = 'success';
	header("Location: " . $_SERVER['HTTP_REFERER']);
	exit;
}


header("Location:" . $url_return);
exit;
