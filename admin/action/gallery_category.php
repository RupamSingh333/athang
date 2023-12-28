<?php
include("../../system_config.php");
$action = get_safe_get('action');
$url_return = "../Gallery_Category/index.php";
switch ($action) {
	case "save":
		$field = array();
		$field['title'] = get_safe_post('title');
		$field['gallery_category'] = get_safe_post('gallery_category');
		/*$field['sort'] = get_safe_post('sort');*/
		/*$img_name = "";
            if ($_FILES["image"]["error"] == 0) {
                $img_name = time() . "_" . strtolower(str_replace(" ", "_", $_FILES["image"]["name"]));
                move_uploaded_file($_FILES["image"]["tmp_name"], "../../" . $config['category_thumb'] . $img_name);
            }
            if ((isset($_FILES["image"])) && !empty($img_name)) {
                $field['image'] = $img_name;
            }*/


		if ($_FILES["image"]["name"] !== "") {

			$fileName = $_FILES["image"]["name"]; // The file name
			$fileTmpLoc = $_FILES["image"]["tmp_name"]; // File in the PHP tmp folder
			$fileType = $_FILES["image"]["type"]; // The type of file it is
			$fileSize = $_FILES["image"]["size"]; // File size in bytes
			$fileErrorMsg = $_FILES["image"]["error"]; // 0 for false... and 1 for true
			$kaboom = explode(".", $fileName); // Split file name into an array using the dot
			$fileExt = end($kaboom); // Now target the last array element to get the file extension
			// START PHP Image Upload Error Handling --------------------------------------------------

			// END PHP Image Upload Error Handling ----------------------------------------------------
			// Place it into your "uploads" folder mow using the move_uploaded_file() function
			$img_name = time() . "_" . strtolower(str_replace(" ", "_", $_FILES["image"]["name"]));
			$field['image'] = "resized_$img_name";
			$moveResult = move_uploaded_file($fileTmpLoc, "./upload/$img_name");
			// Check to make sure the move result is true before continuing

			// ---------- Include Universal Image Resizing Function --------
			include_once("ak_php_img_lib_1.0.php");
			$target_file = "./upload/$img_name";
			$resized_file = "./upload/resized_$img_name";
			//$field['largeimage'] = "$img_name";
			$wmax = 600;
			$hmax = 300;
			ak_img_resize($target_file, $resized_file, $wmax, $hmax, $fileExt);
		}



		$field['cat_status'] = get_safe_post('cat_status');
		$primary_value = get_safe_post('data_id');
		$output =  save_command(tbl_gallery_category, $field, "id", $primary_value);
		$_SESSION['msg'] = $output;

		break;
	case "del":
		$field = array();
		$primary_value = urlencode(decryptIt(get_safe_get('id')));
		$output =  del_command(tbl_gallery_category, "id", $primary_value, false);
		$_SESSION['msg'] = $output;

		break;
	case "status":
		if (isset($_GET['id'])) {
			$id = urlencode(decryptIt($_GET['id']));
			$row = get_gallery_category_byID($id);
			$st = $row['cat_status'];
		}
		if ($st == "0") {
			$status = "1";
		} else {
			$status = "0";
		}
		$field['cat_status'] = $status;
		$primary_value = $id;
		$output =  save_command(tbl_gallery_category, $field, "id", $primary_value);
		$_SESSION['msg'] = $output;


		break;
}
header("Location:" . $url_return);
