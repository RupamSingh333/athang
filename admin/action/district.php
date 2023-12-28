<?php
include("../../system_config.php");
$action = get_safe_get('action');
$url_return = "../District/index.php";
switch ($action) {
	case "save":
		$field = array();
		$field['district_name'] = get_safe_post('title');
		$field['district_description'] = get_safe_post('district_description');
		$field['state_id'] = get_safe_post('state_id');
		$field['district_startfrom'] = date('Y-m-d');
		$img_name = "";
		if ($_FILES["images"]["error"] == 0) {
			$img_name = time() . "_" . strtolower(str_replace(" ", "_", $_FILES["images"]["name"]));
			move_uploaded_file($_FILES["images"]["tmp_name"], "../../" . $config['category_thumb'] . $img_name);
		}
		if ((isset($_FILES["images"])) && !empty($img_name)) {
			$field['district_img'] = $img_name;
		}

		$field['district_status'] = get_safe_post('select');
		$primary_value = get_safe_post('data_id');
		$output =  save_command(tbl_district, $field, "district_id", $primary_value);
		$_SESSION['msg'] = $output;

		break;
	case "del":
		$field = array();
		$primary_value = urlencode(decryptIt(get_safe_get('id')));
		$output =  del_command(tbl_district, "district_id", $primary_value, false);
		$_SESSION['message'] = $output;
		break;
	case "status":
		if (isset($_GET['id'])) {
			$id = urlencode(decryptIt($_GET['id']));
			$row = getdistrict_byID($id);
			$st = $row['district_status'];
		}
		if ($st == "0") {
			$status = "1";
		} else {
			$status = "0";
		}
		$field['district_status'] = $status;
		$primary_value = $id;
		$output =  save_command(tbl_district, $field, "district_id", $primary_value);
		$_SESSION['msg'] = $output;
		break;
}
header("Location:" . $url_return);
