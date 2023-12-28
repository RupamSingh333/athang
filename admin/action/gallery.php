<?php
include("../../system_config.php");
$action = get_safe_get('action');
$url_return = "../gallery/index.php";
switch ($action) {
	case "save":
		$field = array();
		$field['gallery_category'] = get_safe_post('gallery_category');
		$field['user_id'] = get_safe_post('user_id');
		$field['gallery_name'] = get_safe_post('name');
		$field['gallery_description'] = get_safe_post('description');
		$field['gallery_startfrom'] = date('Y-m-d');
		$field['gallery_status'] = get_safe_post('status');
		$img_name = "";
		if ($_FILES["thumbimg"]["error"] == 0) {
			$img_name = time() . "_" . strtolower(str_replace(" ", "_", $_FILES["thumbimg"]["name"]));
			move_uploaded_file($_FILES["thumbimg"]["tmp_name"], "../../" . $config['category_thumb'] . $img_name);
			$field['thumbimg'] = $img_name;
		}



		$primary_value = get_safe_post('data_id');
		$output =  save_command(tbl_gallery, $field, "gallery_id", $primary_value);
		$_SESSION['msg'] = $output;

		break;
	case "del":
		$field = array();
		$primary_value = urlencode(decryptIt(get_safe_get('id')));
		$output =  del_command(tbl_gallery, "gallery_id", $primary_value, false);
		$_SESSION['msg'] = $output;

		break;
	case "status":
		if (isset($_GET['id'])) {
			$id = urlencode(decryptIt($_GET['id']));
			$row1 = gallery_byID($id);
			$st = $row1['gallery_status'];
		}
		if ($st == "0") {
			$status = "1";
		} else {
			$status = "0";
		}
		$field['gallery_status'] = $status;
		$primary_value = $id;
		$output =  save_command(tbl_gallery, $field, "gallery_id", $primary_value);
		$_SESSION['msg'] = $output;


		break;
}
header("Location:" . $url_return);
