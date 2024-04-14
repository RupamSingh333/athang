<?php
include("../../system_config.php");
$action = get_safe_get('action');
$url_return = "../customer";



switch ($action) {
	case "save":
		$primary_value = get_safe_post('data_id');
		$field = array();

		if (isset($_FILES["proof_of_buiseness"])) {
			$file_uploads = $_FILES["proof_of_buiseness"];
			$uploaded_files = [];
			for ($i = 0; $i < count($file_uploads['name']); $i++) {
				if ($file_uploads["error"][$i] == 0) {
					$file_name = $file_uploads["name"][$i];
					$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
					$img_name = $imageName . '_' . time() . "_proof_of_buiseness" . $i . "." . $file_ext;
					$upload_path = "../../" . $config['Images'] . $img_name;
					move_uploaded_file($file_uploads["tmp_name"][$i], $upload_path);
					$uploaded_files[] = $img_name;
				}
			}

			$field['proof_of_buiseness'] = implode(',', $uploaded_files);
			if ($primary_value) {
				$custDetails = getcustomer_byID($primary_value);
				$existing_files = explode(',', $custDetails['proof_of_buiseness']);
				foreach ($existing_files as $existing_file) {
					unlink("../../" . $config['Images'] . $existing_file);
				}
			}
		}

		$field['cust_email'] = get_safe_post('cust_email');
		$field['cust_phone'] = get_safe_post('cust_phone');
		$field['cust_alter_phone'] = get_safe_post('cust_alter_phone');
		$field['aadhar_link_mobile'] = get_safe_post('aadhar_link_mobile');
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
		$field['shop_act_licence'] = get_safe_post('shop_act_licence');
		$field['food_licence'] = get_safe_post('food_licence');
		$field['bank_acc_opening'] = get_safe_post('bank_acc_opening');
		$field['demate_acc_opening'] = get_safe_post('demate_acc_opening');
		$field['itr'] = get_safe_post('itr');
		$field['bs'] = get_safe_post('bs');
		$field['cust_desc'] = get_safe_post('cust_desc');

		// Image name
		$customerNameWithoutSpacesLowercase = strtolower(str_replace(' ', '', $field['cust_first_name']));
		$phone = empty($field['cust_phone']) ? 'NoPhone' : $field['cust_phone'];
		$imageName = $customerNameWithoutSpacesLowercase . '_' . $phone;
		// pr($_FILES);
		// die;


		if ($_FILES["cust_selfie"]["error"] == 0) {
			if ($primary_value) {
				$custDetails = getcustomer_byID($primary_value);
				unlink("../../" . $config['Images'] . $custDetails['cust_selfie']);
			}
			$file_name = $_FILES["cust_selfie"]["name"];
			$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
			$img_name = $imageName . '_' . time() . "_selfie." . $file_ext;
			move_uploaded_file($_FILES["cust_selfie"]["tmp_name"], "../../" . $config['Images'] . $img_name);
			$field['cust_selfie'] = $img_name;

		} else if ($_FILES["cust_agreement_copy"]["error"] == 0) {
			$file_name = $_FILES["cust_agreement_copy"]["name"];
			$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
			$img_name = $imageName . '_' . time() . "_agreement_copy." . $file_ext;
			move_uploaded_file($_FILES["cust_agreement_copy"]["tmp_name"], "../../" . $config['Images'] . $img_name);
			$field['cust_agreement_copy'] = $img_name;

			if ($primary_value) {
				$custDetails = getcustomer_byID($primary_value);
				unlink("../../" . $config['Images'] . $custDetails['cust_agreement_copy']);
			}
		} else if ($_FILES["cust_signature"]["error"] == 0) {
			$file_name = $_FILES["cust_signature"]["name"];
			$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
			$img_name = $imageName . '_' . time() . "_signature." . $file_ext;
			move_uploaded_file($_FILES["cust_signature"]["tmp_name"], "../../" . $config['Images'] . $img_name);
			$field['cust_signature'] = $img_name;

			if ($primary_value) {
				$custDetails = getcustomer_byID($primary_value);
				unlink("../../" . $config['Images'] . $custDetails['cust_signature']);
			}
		} else if ($_FILES["cust_pan_card"]["error"] == 0) {
			$file_name = $_FILES["cust_pan_card"]["name"];
			$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
			$img_name = $imageName . '_' . time() . "_pan_card." . $file_ext;
			move_uploaded_file($_FILES["cust_pan_card"]["tmp_name"], "../../" . $config['Images'] . $img_name);
			$field['cust_pan_card'] = $img_name;

			if ($primary_value) {
				$custDetails = getcustomer_byID($primary_value);
				unlink("../../" . $config['Images'] . $custDetails['cust_pan_card']);
			}
		} else if ($_FILES["cust_aadhar_card_back"]["error"] == 0) {
			$file_name = $_FILES["cust_aadhar_card_back"]["name"];
			$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
			$img_name = $imageName . '_' . time() . "_aadhar_card_back." . $file_ext;
			move_uploaded_file($_FILES["cust_aadhar_card_back"]["tmp_name"], "../../" . $config['Images'] . $img_name);
			$field['cust_aadhar_card_back'] = $img_name;

			if ($primary_value) {
				$custDetails = getcustomer_byID($primary_value);
				unlink("../../" . $config['Images'] . $custDetails['cust_aadhar_card_back']);
			}
		} else if ($_FILES["cust_aadhar_card_front"]["error"] == 0) {
			$file_name = $_FILES["cust_aadhar_card_front"]["name"];
			$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
			$img_name = $imageName . '_' . time() . "_aadhar_card_front." . $file_ext;
			move_uploaded_file($_FILES["cust_aadhar_card_front"]["tmp_name"], "../../" . $config['Images'] . $img_name);
			$field['cust_aadhar_card_front'] = $img_name;

			if ($primary_value) {
				$custDetails = getcustomer_byID($primary_value);
				unlink("../../" . $config['Images'] . $custDetails['cust_aadhar_card_front']);
			}
		} else if ($_FILES["form16"]["error"] == 0) {
			$file_name = $_FILES["form16"]["name"];
			$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
			$img_name = $imageName . '_' . time() . "_form16." . $file_ext;
			move_uploaded_file($_FILES["form16"]["tmp_name"], "../../" . $config['Images'] . $img_name);
			$field['form16'] = $img_name;

			if ($primary_value) {
				$custDetails = getcustomer_byID($primary_value);
				unlink("../../" . $config['Images'] . $custDetails['form16']);
			}
		} else if ($_FILES["b_acc_screenshot"]['error'][0] == 0) {
			$file_uploads = $_FILES["b_acc_screenshot"];
			$uploaded_files = [];
			for ($i = 0; $i < count($file_uploads['name']); $i++) {
				if ($file_uploads["error"][$i] == 0) {
					$file_name = $file_uploads["name"][$i];
					$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
					$img_name = $imageName . '_' . time() . "_b_acc_screenshot" . $i . "." . $file_ext;
					$upload_path = "../../" . $config['Images'] . $img_name;
					move_uploaded_file($file_uploads["tmp_name"][$i], $upload_path);
					$uploaded_files[] = $img_name;
				}
			}

			$field['b_acc_screenshot'] = implode(',', $uploaded_files);
			if ($primary_value) {
				$custDetails = getcustomer_byID($primary_value);
				$existing_files = explode(',', $custDetails['b_acc_screenshot']);
				foreach ($existing_files as $existing_file) {
					unlink("../../" . $config['Images'] . $existing_file);
				}
			}
		} else if ($_FILES["dmt_acc_screenshot"]['error'][0] == 0) {
			$file_uploads = $_FILES["dmt_acc_screenshot"];
			$uploaded_files = [];
			for ($i = 0; $i < count($file_uploads['name']); $i++) {
				if ($file_uploads["error"][$i] == 0) {
					$file_name = $file_uploads["name"][$i];
					$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
					$img_name = $imageName . '_' . time() . "_dmt_acc_screenshot" . $i . "." . $file_ext;
					$upload_path = "../../" . $config['Images'] . $img_name;
					move_uploaded_file($file_uploads["tmp_name"][$i], $upload_path);
					$uploaded_files[] = $img_name;
				}
			}

			$field['dmt_acc_screenshot'] = implode(',', $uploaded_files);
			if ($primary_value) {
				$custDetails = getcustomer_byID($primary_value);
				$existing_files = explode(',', $custDetails['dmt_acc_screenshot']);
				foreach ($existing_files as $existing_file) {
					unlink("../../" . $config['Images'] . $existing_file);
				}
			}
		} else if ($_FILES["itr_bank_statement"]['error'][0] == 0) {
			$file_uploads = $_FILES["itr_bank_statement"];
			$uploaded_files = [];
			for ($i = 0; $i < count($file_uploads['name']); $i++) {
				if ($file_uploads["error"][$i] == 0) {
					$file_name = $file_uploads["name"][$i];
					$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
					$img_name = $imageName . '_' . time() . "_itr_bank_statement" . $i . "." . $file_ext;
					$upload_path = "../../" . $config['Images'] . $img_name;
					move_uploaded_file($file_uploads["tmp_name"][$i], $upload_path);
					$uploaded_files[] = $img_name;
				}
			}

			$field['itr_bank_statement'] = implode(',', $uploaded_files);
			if ($primary_value) {
				$custDetails = getcustomer_byID($primary_value);
				$existing_files = explode(',', $custDetails['itr_bank_statement']);
				foreach ($existing_files as $existing_file) {
					unlink("../../" . $config['Images'] . $existing_file);
				}
			}
		} else if ($_FILES["salary_sheet"]['error'][0] == 0) {
			$file_uploads = $_FILES["salary_sheet"];
			$uploaded_files = [];
			for ($i = 0; $i < count($file_uploads['name']); $i++) {
				if ($file_uploads["error"][$i] == 0) {
					$file_name = $file_uploads["name"][$i];
					$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
					$img_name = $imageName . '_' . time() . "_salary_sheet" . $i . "." . $file_ext;
					$upload_path = "../../" . $config['Images'] . $img_name;
					move_uploaded_file($file_uploads["tmp_name"][$i], $upload_path);
					$uploaded_files[] = $img_name;
				}
			}

			$field['salary_sheet'] = implode(',', $uploaded_files);
			if ($primary_value) {
				$custDetails = getcustomer_byID($primary_value);
				$existing_files = explode(',', $custDetails['salary_sheet']);
				foreach ($existing_files as $existing_file) {
					unlink("../../" . $config['Images'] . $existing_file);
				}
			}
		} else if ($_FILES["bs_bank_statemenet"]['error'][0] == 0) {
			$file_uploads = $_FILES["bs_bank_statemenet"];
			$uploaded_files = [];
			for ($i = 0; $i < count($file_uploads['name']); $i++) {
				if ($file_uploads["error"][$i] == 0) {
					$file_name = $file_uploads["name"][$i];
					$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
					$img_name = $imageName . '_' . time() . "_bs_bank_statemenet" . $i . "." . $file_ext;
					$upload_path = "../../" . $config['Images'] . $img_name;
					move_uploaded_file($file_uploads["tmp_name"][$i], $upload_path);
					$uploaded_files[] = $img_name;
				}
			}

			$field['bs_bank_statemenet'] = implode(',', $uploaded_files);
			if ($primary_value) {
				$custDetails = getcustomer_byID($primary_value);
				$existing_files = explode(',', $custDetails['bs_bank_statemenet']);
				foreach ($existing_files as $existing_file) {
					unlink("../../" . $config['Images'] . $existing_file);
				}
			}
		} else if ($_FILES["proof_of_buiseness"]['error'][0] == 0) {
			$file_uploads = $_FILES["proof_of_buiseness"];
			$uploaded_files = [];
			for ($i = 0; $i < count($file_uploads['name']); $i++) {
				if ($file_uploads["error"][$i] == 0) {
					$file_name = $file_uploads["name"][$i];
					$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
					$img_name = $imageName . '_' . time() . "_proof_of_buiseness" . $i . "." . $file_ext;
					$upload_path = "../../" . $config['Images'] . $img_name;
					move_uploaded_file($file_uploads["tmp_name"][$i], $upload_path);
					$uploaded_files[] = $img_name;
				}
			}

			$field['proof_of_buiseness'] = implode(',', $uploaded_files);
			if ($primary_value) {
				$custDetails = getcustomer_byID($primary_value);
				$existing_files = explode(',', $custDetails['proof_of_buiseness']);
				foreach ($existing_files as $existing_file) {
					unlink("../../" . $config['Images'] . $existing_file);
				}
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
