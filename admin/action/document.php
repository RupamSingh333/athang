<?php
include("../../system_config.php");
$action = get_safe_get('action');
$url_return = "../Document/index.php";
switch ($action) {
	case "save":
		$field = array();
		$field['cat_id'] = get_safe_post('cat_id');
		$field['count'] = get_safe_post('count');
		$field['price'] = get_safe_post('price');
		$field['document_name'] = get_safe_post('document_name');
		$field['document_description'] = get_safe_post('document_description');
		$field['s_desc'] = get_safe_post('s_desc');
		$field['document_status'] = get_safe_post('document_status');
		$field['document_startfrom'] = date('Y-m-d H:i:s');
		$img_name = "";
		if ($_FILES["document_sample"]["error"] == 0) {
			$img_name = time() . "_" . strtolower(str_replace(" ", "_", $_FILES["document_sample"]["name"]));
			move_uploaded_file($_FILES["document_sample"]["tmp_name"], "../../" . $config['document_sample'] . $img_name);
		}
		if ((isset($_FILES["document_sample"])) && !empty($img_name)) {
			$field['document_sample'] = $img_name;
		}

		$img_name = "";
		if ($_FILES["document_file"]["error"] == 0) {
			$img_name = time() . "_" . strtolower(str_replace(" ", "_", $_FILES["document_file"]["name"]));
			move_uploaded_file($_FILES["document_file"]["tmp_name"], "../../" . $config['document_file'] . $img_name);
		}
		if ((isset($_FILES["document_file"])) && !empty($img_name)) {
			$field['document_file'] = $img_name;
		}

		$primary_value = get_safe_post('data_id');

		$output =  save_command(tbl_document, $field, "document_id", $primary_value);
		// echo 'sdfsdf';die;
		$_SESSION['msg'] = $output;

		break;

	case "del":
		$field = array();
		$primary_value = urlencode(decryptIt(get_safe_get('id')));
		$output =  del_command(tbl_document, "document_id", $primary_value, false);
		$_SESSION['msg'] = $output;
		break;

	case "status":
		if (isset($_GET['id'])) {
			$id = urlencode(decryptIt($_GET['id']));
			$row = getdocument_byID($id);
			$st = $row['document_status'];
		}
		if ($st == "0") {
			$status = "1";
		} else {
			$status = "0";
		}
		$field['document_status'] = $status;
		$primary_value = $id;
		$output =  save_command(tbl_document, $field, "document_id", $primary_value);
		$_SESSION['msg'] = $output;

		break;
}
header("Location:" . $url_return);
