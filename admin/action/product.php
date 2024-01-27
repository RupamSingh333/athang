<?php
include("../../system_config.php");
$action = get_safe_get('action');
$url_return = "../product/index.php";
switch ($action) {
	case "save":

		$field = array();
		$primary_value = get_safe_post('data_id');
		$get_product = getCategory_byID($primary_value);
		$field['product_name'] = get_safe_post('product_name');
		$field['product_status'] = get_safe_post('product_status');
		$field['sort'] = get_safe_post('sort');
		$field['product_description'] = get_safe_post('product_description');
		$field['p_cat'] = get_safe_post('p_cat');
		$field['product_startfrom'] = date('Y-m-d H:i:s');
		$img_name = "";

		if ($_FILES["product_thumbimg"]["error"] == 0) {

			if ($get_product) {
				unlink("../../" . $config['category_thumb'] . $get_product['product_thumbimg']);
			}

			$img_name = time() . "_" . strtolower(str_replace(" ", "_", $_FILES["product_thumbimg"]["name"]));
			move_uploaded_file($_FILES["product_thumbimg"]["tmp_name"], "../../" . $config['category_thumb'] . $img_name);
			$field['product_thumbimg'] = $img_name;
		}

		$output =  save_command(tbl_product, $field, "product_id", $primary_value);
		$_SESSION['msg'] = $output;
        $_SESSION['alert_type'] = 'success';
		break;

	case "del":
		$field = array();
		$primary_value = urlencode(decryptIt(get_safe_get('id')));
		echo $primary_value;die;
		$get_product = getproduct_byID($primary_value);
		$output =  del_command(tbl_product, "product_id", $primary_value, false);

		if ($get_product) {
			unlink("../../" . $config['category_thumb'] . $get_product['product_thumbimg']);
		}
		$_SESSION['msg'] = $output;
        $_SESSION['alert_type'] = 'success';
		break;

	case "status":
		if (isset($_GET['id'])) {
			$id = urlencode(decryptIt($_GET['id']));
			$row = getproduct_byID($id);
			$st = $row['product_status'];
		}

		if ($st == "0") {
			$status = "1";
		} else {
			$status = "0";
		}


		$statusField = "product_status";
		$primaryValue = $status;
		$primaryKey = "product_id";

		$output =  update_status(tbl_product, $statusField, $primaryValue, $primaryKey, $id);
		$_SESSION['msg'] = $output;
        $_SESSION['alert_type'] = 'success';

		break;
}
header("Location:" . $url_return);
