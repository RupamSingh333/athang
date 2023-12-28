<?php
include("../../system_config.php");
$action = get_safe_get('action');
$url_return = "../dealer/";
// pr($_GET); die;

switch ($action) {
	case "save":
		$field = array();
		$primary_value = get_safe_post('data_id');
		$field['dealer_name'] = get_safe_post('dealer_name');
		$field['dealer_email'] = get_safe_post('dealer_email');
		$field['dealer_phone'] = get_safe_post('dealer_phone');
		$field['dealer_altenate_phone'] = get_safe_post('dealer_altenate_phone');
		$field['password'] = encryptIt(get_safe_post('password'));
		$field['dealer_org_name'] = get_safe_post('dealer_org_name');
		$field['dealer_gst_no'] = get_safe_post('dealer_gst_no');
		$field['dealer_pan_no'] = get_safe_post('dealer_pan_no');
		$field['dealer_billing_address'] = get_safe_post('dealer_billing_address');
		$field['dealer_state'] = get_safe_post('dealer_state');
		$field['dealer_city'] = get_safe_post('dealer_city');
		$field['dealer_pincode'] = get_safe_post('dealer_pincode');
		$field['dealer_desc'] = get_safe_post('dealer_desc');
		$dealer_cate = get_safe_post('dealer_cate');
		if ($dealer_cate) {
			$field['dealer_cate'] = implode(',', $dealer_cate);
		}
		if ($field['dealer_country']) {
			$field['dealer_country'] = get_safe_post('dealer_country');
		} else {
			$field['dealer_country'] = 101;
		}
		if ($field['dealer_status']) {
			$field['dealer_status'] = get_safe_post('dealer_status');
		}

		//dealer_profile image
		if ($_FILES["dealer_profile"]["error"] == 0) {
			$file_name = $_FILES["dealer_profile"]["name"];
			$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
			$unique_name = time() . "_" . uniqid() . strtolower(str_replace(" ", "_", $field['dealer_name'])) . '_profile';
			$dealer_img_name = $unique_name . '.' . $file_ext;
			move_uploaded_file($_FILES["dealer_profile"]["tmp_name"], "../../" . $config['Images'] . $dealer_img_name);
			$field['dealer_profile'] = $dealer_img_name;

			if ($primary_value) {
				$dealer_profile = getDealerID($primary_value);
				unlink("../../" . $config['Images'] . $dealer_profile['dealer_profile']);
			}
		}

		//visiting_card image
		if ($_FILES["visiting_card"]["error"] == 0) {
			$file_name = $_FILES["visiting_card"]["name"];
			$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
			$unique_name = time() . "_" . uniqid() . strtolower(str_replace(" ", "_", $field['dealer_name'])) . '_vist_card';
			$visiting_card_img_name = $unique_name . '.' . $file_ext;
			move_uploaded_file($_FILES["visiting_card"]["tmp_name"], "../../" . $config['Images'] . $visiting_card_img_name);
			$field['visiting_card'] = $visiting_card_img_name;

			if ($primary_value) {
				$visiting_card = getDealerID($primary_value);
				unlink("../../" . $config['Images'] . $visiting_card['visiting_card']);
			}
		}

		$output = save_command(tbl_dealer, $field, "dealer_id", $primary_value);
		$_SESSION['msg'] = $output;
		break;

	case "del":
		$field = array();
		$primary_value = urlencode(decryptIt(get_safe_get('id')));
		if ($primary_value) {
			$visiting_card = getDealerID($primary_value);
			unlink("../../" . $config['Images'] . $visiting_card['visiting_card']);
			unlink("../../" . $config['Images'] . $visiting_card['dealer_profile']);
			$output =  del_command(tbl_dealer, "dealer_id", $primary_value, false);
			$_SESSION['msg'] = $output;
		} else {
			$_SESSION['msg'] = 'Invalid Dealer Id';
		}

		break;

	case "status":
		if (isset($_GET['id'])) {
			$id = decryptIt($_GET['id']);
			$row = getDealerID($id);
			$st = $row['dealer_status'];
		}
		// pr($st);die;
		if ($st == "0") {
			$status = "1";
		} else {
			$status = "0";
		}
		$field['dealer_status'] = $status;
		$primary_value = $id;
		$output =  save_command(tbl_dealer, $field, "dealer_id", $primary_value);
		$_SESSION['msg'] = $output;
		break;
}

// header("Location:" . $url_return);
// exit;
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
