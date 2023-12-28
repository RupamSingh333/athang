<?php
include("../../system_config.php");
$action = get_safe_get('action');
$url_return = "../Sub_category/index.php";
switch ($action) {
	case "save":

		$field = array();
		$primary_value = get_safe_post('data_id');
		$get_sub_cat = getCategory_byID($primary_value);
		$field['sub_cat_name'] = get_safe_post('sub_cat_name');
		$field['sub_cat_status'] = get_safe_post('sub_cat_status');
		$field['sort'] = get_safe_post('sort');
		$field['sub_cat_description'] = get_safe_post('sub_cat_description');
		$field['p_cat'] = get_safe_post('p_cat');
		$field['sub_cat_startfrom'] = date('Y-m-d H:i:s');
		$img_name = "";

		if ($_FILES["sub_cat_thumbimg"]["error"] == 0) {

			if ($get_sub_cat) {
				unlink("../../" . $config['category_thumb'] . $get_sub_cat['sub_cat_thumbimg']);
			}

			$img_name = time() . "_" . strtolower(str_replace(" ", "_", $_FILES["sub_cat_thumbimg"]["name"]));
			move_uploaded_file($_FILES["sub_cat_thumbimg"]["tmp_name"], "../../" . $config['category_thumb'] . $img_name);
			$field['sub_cat_thumbimg'] = $img_name;
		}

		$output =  save_command(tbl_sub_categories, $field, "sub_cat_id", $primary_value);
		$_SESSION['msg'] = $output;

		break;

	case "del":
		$field = array();
		$primary_value = urlencode(decryptIt(get_safe_get('id')));
		$get_sub_cat = getCategory_byID($primary_value);
		$output =  del_command(tbl_sub_categories, "sub_cat_id", $primary_value, false);

		if ($get_sub_cat) {
			unlink("../../" . $config['category_thumb'] . $get_sub_cat['sub_cat_thumbimg']);
		}

		$_SESSION['msg'] = $output;
		break;

	case "status":
		if (isset($_GET['id'])) {
			$id = urlencode(decryptIt($_GET['id']));
			$row = getSub_category_byID($id);
			$st = $row['sub_cat_status'];
		}

		if ($st == "0") {
			$status = "1";
		} else {
			$status = "0";
		}


		$statusField = "sub_cat_status";
		$primaryValue = $status;
		$primaryKey = "sub_cat_id";

		$output =  update_status(tbl_sub_categories, $statusField, $primaryValue, $primaryKey, $id);
		$_SESSION['msg'] = $output;

		break;
}
header("Location:" . $url_return);
