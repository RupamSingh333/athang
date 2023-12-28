<?php
include("../../system_config.php");
$action = get_safe_get('action');
$url_return = "../customer";

switch ($action) {
	case "save":
		$primary_value = get_safe_post('data_id');
		$field = array();

		$field['cust_email'] = get_safe_post('cust_email');
		$field['cust_phone'] = get_safe_post('cust_phone');
		$field['cust_alter_phone'] = get_safe_post('cust_alter_phone');
		$field['cust_password'] = encryptIt(get_safe_post('cust_password'));
		$field['cust_first_name'] = get_safe_post('cust_first_name');
		$field['cust_org_name'] = get_safe_post('cust_org_name');
		$field['cust_org_type'] = get_safe_post('cust_org_type');
		$field['cust_aadhar_no'] = get_safe_post('cust_aadhar_no');
		$field['cust_gst_no'] = get_safe_post('cust_gst_no');
		$field['cust_state'] = get_safe_post('cust_state');
		$field['cust_district_id'] = get_safe_post('cust_district_id');
		$field['cust_taluka_id'] = get_safe_post('cust_taluka_id');
		$field['cust_pincode'] = get_safe_post('cust_pincode');
		$field['cust_address'] = get_safe_post('cust_address');
		$field['cust_country'] = 101;
		$field['cust_status'] = get_safe_post('cust_status');
		$field['cust_desc'] = get_safe_post('cust_desc');

		if ($_FILES["cust_selfie"]["error"] == 0) {
			$file_name = $_FILES["cust_selfie"]["name"];
			$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
			$img_name = rand() . '_' . time() . "_selfie" . $file_ext;
			move_uploaded_file($_FILES["cust_selfie"]["tmp_name"], "../../" . $config['Images'] . $img_name);
			$field['cust_selfie'] = $img_name;

			if ($primary_value) {
				$custDetails = getcustomer_byID($primary_value);
				unlink("../../" . $config['Images'] . $custDetails['cust_selfie']);
			}
		} else if ($_FILES["cust_agreement_copy"]["error"] == 0) {
			$file_name = $_FILES["cust_agreement_copy"]["name"];
			$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
			$img_name = rand() . '_' . time() . "_agreement_copy" . $file_ext;
			move_uploaded_file($_FILES["cust_agreement_copy"]["tmp_name"], "../../" . $config['Images'] . $img_name);
			$field['cust_agreement_copy'] = $img_name;

			if ($primary_value) {
				$custDetails = getcustomer_byID($primary_value);
				unlink("../../" . $config['Images'] . $custDetails['cust_agreement_copy']);
			}
		} else if ($_FILES["cust_signature"]["error"] == 0) {
			$file_name = $_FILES["cust_signature"]["name"];
			$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
			$img_name = rand() . '_' . time() . "_signature" . $file_ext;
			move_uploaded_file($_FILES["cust_signature"]["tmp_name"], "../../" . $config['Images'] . $img_name);
			$field['cust_signature'] = $img_name;

			if ($primary_value) {
				$custDetails = getcustomer_byID($primary_value);
				unlink("../../" . $config['Images'] . $custDetails['cust_signature']);
			}
		} else if ($_FILES["cust_pan_card"]["error"] == 0) {
			$file_name = $_FILES["cust_pan_card"]["name"];
			$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
			$img_name = rand() . '_' . time() . "_pan_card" . $file_ext;
			move_uploaded_file($_FILES["cust_pan_card"]["tmp_name"], "../../" . $config['Images'] . $img_name);
			$field['cust_pan_card'] = $img_name;

			if ($primary_value) {
				$custDetails = getcustomer_byID($primary_value);
				unlink("../../" . $config['Images'] . $custDetails['cust_pan_card']);
			}
		} else if ($_FILES["cust_aadhar_card_back"]["error"] == 0) {
			$file_name = $_FILES["cust_aadhar_card_back"]["name"];
			$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
			$img_name = rand() . '_' . time() . "_aadhar_card_back" . $file_ext;
			move_uploaded_file($_FILES["cust_aadhar_card_back"]["tmp_name"], "../../" . $config['Images'] . $img_name);
			$field['cust_aadhar_card_back'] = $img_name;

			if ($primary_value) {
				$custDetails = getcustomer_byID($primary_value);
				unlink("../../" . $config['Images'] . $custDetails['cust_aadhar_card_back']);
			}
		} else if ($_FILES["cust_aadhar_card_front"]["error"] == 0) {
			$file_name = $_FILES["cust_aadhar_card_front"]["name"];
			$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
			$img_name = rand() . '_' . time() . "_aadhar_card_front" . $file_ext;
			move_uploaded_file($_FILES["cust_aadhar_card_front"]["tmp_name"], "../../" . $config['Images'] . $img_name);
			$field['cust_aadhar_card_front'] = $img_name;

			if ($primary_value) {
				$custDetails = getcustomer_byID($primary_value);
				unlink("../../" . $config['Images'] . $custDetails['cust_aadhar_card_front']);
			}
		}
		$output =  save_command(tbl_customer, $field, "cust_id", $primary_value);
		$_SESSION['msg'] = $output;
		break;
	case "del":
		$field = array();
		$primary_value = urlencode(decryptIt(get_safe_get('id')));
		$custDetails = getcustomer_byID($primary_value);
		unlink("../../" . $config['Images'] . $custDetails['cust_profile']);
		$output =  del_command(tbl_customer, "cust_id", $primary_value, false);

		$_SESSION['msg'] = $output;
		break;

	case "status":
		if (isset($_GET['id'])) {
			$id = urlencode(decryptIt($_GET['id']));
			$row = getcustomer_byID($id);
			$st = $row['cust_status'];
		}
		if ($st == "0") {
			$status = "1";
		} else {
			$status = "0";
		}
		$field['cust_status'] = $status;
		$primary_value = $id;
		$output =  save_command(tbl_customer, $field, "cust_id", $primary_value);
		$_SESSION['msg'] = $output;
		break;
}

header("Location:" . $url_return);
