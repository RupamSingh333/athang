<?php
include("../../system_config.php");
$action = get_safe_get('action');
$url_return = "../user/";

// pr($_FILES);exit;

// File uploads
function handleFileUpload($fileKey, $imageName, $primaryValue, &$config, &$field)
{
	if ($_FILES[$fileKey]["error"] == 0) {
		if ($primaryValue) {
			$getUserById = getuser_byID($primaryValue);
			$oldFileName = $getUserById[$fileKey];
			if ($oldFileName) {
				unlink("../../" . $config['Images'] . $oldFileName);
			}
		}

		$fileInfo = pathinfo($_FILES[$fileKey]["name"]);
		$fileExt = strtolower($fileInfo['extension']);
		$imgName = $imageName . '_' . time() . "_" . $fileKey . "." . $fileExt;

		move_uploaded_file($_FILES[$fileKey]["tmp_name"], "../../" . $config['Images'] . $imgName);
		$field[$fileKey] = $imgName;
	}
}

// Multiple File Upload 
function handleMultipleFileUpload($fileKey, $columnName, $userId)
{
	global $link, $config;

	$existingFilenames = explode(',', getuser_byID($userId)[$columnName]);

	$imageNames = [];
	foreach ($_FILES[$fileKey]['name'] as $index => $filename) {
		if ($_FILES[$fileKey]['error'][$index] == 0) {
			$getUserById = getuser_byID($userId);
			$customerNameWithoutSpacesLowercase = strtolower(str_replace(' ', '', $getUserById['first_name']));
			$imageName = $customerNameWithoutSpacesLowercase;

			$file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
			$user_img_name = $imageName . '_' . time() . '_' . $fileKey . $index . "." . $file_ext;
			$path = "../../" . $config['Images'] . $user_img_name;

			if (move_uploaded_file($_FILES[$fileKey]["tmp_name"][$index], $path)) {
				$imageNames[] = $user_img_name;
			}
		}
	}

	// Unlink existing files that are not present in the new list
	foreach ($existingFilenames as $existingFilename) {
		if (!in_array($existingFilename, $imageNames)) {
			unlink("../../" . $config['Images'] . $existingFilename);
		}
	}

	// Update the database with the comma-separated list of image names
	if (!empty($imageNames)) {
		$newImageNames = implode(',', $imageNames);
		$update_sql = "UPDATE reg_user SET $columnName = ? WHERE user_id = ?";
		$update_stmt = mysqli_prepare($link, $update_sql);
		mysqli_stmt_bind_param($update_stmt, 'si', $newImageNames, $userId);
		mysqli_stmt_execute($update_stmt);
	}
	// pr($imageNames);exit;
}

switch ($action) {
	case "save":
		$field = array();
		$primary_value = get_safe_post('data_id');

		if (empty($primary_value)) {
			$field['user_startfrom'] = date('Y-m-d H:i:s');
			$field['user_email'] = get_safe_post('user_email');
		}

		$field['first_name'] = get_safe_post('first_name');
		$field['user_phone'] = get_safe_post('user_phone');
		$field['user_pass'] = encryptIt(get_safe_post('confirm_password'));
		$field['taluka_id'] = get_safe_post('taluka_id');
		$field['user_district'] = get_safe_post('district_id');
		$field['user_state'] = get_safe_post('user_state');
		$field['user_tel'] = get_safe_post('user_tel');
		$field['user_address'] = get_safe_post('user_address');
		$field['user_desc'] = get_safe_post('user_desc');
		$field['food_license_point'] = get_safe_post('food_license_point');
		$field['shop_act_license_point'] = get_safe_post('shop_act_license_point');
		$field['bank_acc_point'] = get_safe_post('bank_acc_point');
		$field['demat_acc_point'] = get_safe_post('demat_acc_point');
		$field['itr_management_point'] = get_safe_post('itr_management_point');
		$field['basic_salary'] = get_safe_post('basic_salary');
		$field['bs_point'] = get_safe_post('bs_point');
		$field['petrol'] = get_safe_post('petrol');
		$field['mobile_recharge'] = get_safe_post('mobile_recharge');
		$field['extra_allowance'] = get_safe_post('extra_allowance');
		$field['working_target'] = get_safe_post('working_target');
		$field['user_type'] = get_safe_post('user_type');

		$field['alter_mobile_number'] = get_safe_post('alter_mobile_number');
		$field['reference1_name'] = get_safe_post('reference1_name');
		$field['reference1_mobile_number'] = get_safe_post('reference1_mobile_number');
		$field['reference1_relation'] = get_safe_post('reference1_relation');
		$field['reference2_name'] = get_safe_post('reference2_name');
		$field['reference2_mobile_number'] = get_safe_post('reference2_mobile_number');
		$field['reference2_relation'] = get_safe_post('reference2_relation');
		// pr($field);exit;

		$userNameWithoutSpacesLowercase = strtolower(str_replace(' ', '', $field['first_name']));
		$phone = empty($field['user_phone']) ? 'NoPhone' : $field['user_phone'];
		$imageName = $userNameWithoutSpacesLowercase . '_' . $phone;

		// Usage:
		handleFileUpload("user_logo", $imageName, $primary_value, $config, $field);
		handleFileUpload("aadhar_front_image", $imageName, $primary_value, $config, $field);
		handleFileUpload("aadhar_back_image", $imageName, $primary_value, $config, $field);
		handleFileUpload("dl_front_image", $imageName, $primary_value, $config, $field);
		handleFileUpload("dl_back_image", $imageName, $primary_value, $config, $field);
		handleFileUpload("pan_card_image", $imageName, $primary_value, $config, $field);

		// multiple files upload 
		handleMultipleFileUpload("other_documents", "other_documents", $primary_value);

		$field['user_status'] = get_safe_post('user_status');
		$output =  save_command(tbl_user, $field, "user_id", $primary_value);
		$_SESSION['msg'] = $output;
		break;


	case "del":
		$field = array();
		$primary_value = urlencode(decryptIt(get_safe_get('id')));
		$output =  del_command(tbl_user_permission, "user_id", $primary_value, false);
		$output =  del_command(tbl_user, "user_id", $primary_value, false);
		$_SESSION['msg'] = $output;
		break;


	case "status":
		if (isset($_GET['id'])) {
			$id = urlencode(decryptIt($_GET['id']));
			$row = getuser_byID($id);
			$st = $row['user_status'];
		}
		if ($st == "0") {
			$status = "1";
		} else {
			$status = "0";
		}
		$field['user_status'] = $status;
		$primary_value = $id;
		$output =  save_command(tbl_user, $field, "user_id", $primary_value);
		$_SESSION['msg'] = $output;

		break;
}
header("Location:" . $url_return);
