<?php
include("../../system_config.php");
$action = get_safe_get('action');
$url_return = "../Banner/index.php";
switch ($action) {
	case "save":
		$field = array();
		$primary_value = get_safe_post('data_id');
		$getbanner = getbanner_byID($primary_value);

		$field['banner_name'] = get_safe_post('title');
		$field['type'] = get_safe_post('type');
		$field['banner_startfrom'] = date('Y-m-d');
		$field['imageURL'] = get_safe_post('imageURL');
		$categoryIds = get_safe_post('categoryIds');
		if ($categoryIds) {
			$field['categoryIds'] = implode(',', $categoryIds);
		}


		if ($_FILES["images"]["error"] == 0) {
			$img_name = time() . "_" . strtolower(str_replace(" ", "_", $_FILES["images"]["name"]));
			move_uploaded_file($_FILES["images"]["tmp_name"], "../../" . $config['category_thumb'] . $img_name);
			$field['banner_img'] = $img_name;
			if ($primary_value) {
				unlink("../../" . $config['category_thumb'] . $getbanner['banner_img']);
			}
		}

		if ($_FILES["videoFile"]["error"] == 0) {
			$video_name = time() . "_" . strtolower(str_replace(" ", "_", $_FILES["videoFile"]["name"]));
			move_uploaded_file($_FILES["videoFile"]["tmp_name"], "../../" . $config['video_directory'] . $video_name);
			$field['videoFile'] = $video_name;
			if ($primary_value) {
				unlink("../../" . $config['video_directory'] . $getbanner['videoFile']);
			}
		}

		$field['banner_status'] = get_safe_post('select');
		$output =  save_command(tbl_banner, $field, "banner_id", $primary_value);
		$_SESSION['msg'] = $output;
		break;

	case "del":
		$field = array();
		$primary_value = urlencode(decryptIt(get_safe_get('id')));
		$output =  del_command(tbl_banner, "banner_id", $primary_value, false);
		$_SESSION['msg'] = $output;
		break;

	case "status":
		if (isset($_GET['id'])) {
			$id = urlencode(decryptIt($_GET['id']));
			$row = getbanner_byID($id);
			$st = $row['banner_status'];
		}
		if ($st == "0") {
			$status = "1";
		} else {
			$status = "0";
		}
		$field['banner_status'] = $status;
		$primary_value = $id;
		$output =  save_command(tbl_banner, $field, "banner_id", $primary_value);
		$_SESSION['msg'] = $output;

		break;
}
header("Location:" . $url_return);
