<?php
include("../../system_config.php");
$action = $_GET['action'] ?? '';
$url_return = "../Number/index.php";
switch ($action) {
    case "save":
        // Retrieve and sanitize input values
        $primary_value = $_POST['data_id'];
        if ($primary_value) {
            $productDet = getnumberID($primary_value);
        }
        $field = array();
        $field['number_number'] = get_safe_post('number_number');
        $field['category_id'] = get_safe_post('category_id');
        $field['subcategory_id'] = get_safe_post('subcategory_id');
        $field['plan_id'] = get_safe_post('plan_id');
        $field['quantity'] = get_safe_post('quantity');
        $field['status'] = get_safe_post('status');
        $field['description'] = get_safe_post('description');
		$field['sim_number'] = get_safe_post('sim_number');
		$field['sku'] = get_safe_post('sku');
		$field['user_id'] = get_safe_post('user_id');
		$field['created_date'] = date('Y-m-d H:i:s');
		$field['updated_date'] = date('Y-m-d H:i:s');
      $field['sort'] = get_safe_post('sort');
        //Single image
        if ($_FILES["single_images"]["error"] == 0) {
            $file_name = $_FILES["single_images"]["name"];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $unique_name = time() . "_" . uniqid() . "_single";
            $img_name = $unique_name . '.' . $file_ext;
            move_uploaded_file($_FILES["single_images"]["tmp_name"], "../../" . $config['productImages'] . $img_name);
            $field['single_images'] = $img_name;
            if ($primary_value) {
                unlink("../../" . $config['productImages'] . $productDet['single_images']);
            }
        }

      
  			$output = save_command(tbl_number, $field, "number_id", $primary_value);
            $_SESSION['msg'] = $output;
            $_SESSION['alert_type'] = 'success';
            break;

    case "del":
        // Sanitize and decrypt the ID
        $primary_value = urlencode(decryptIt($_GET['id']));
        if ($primary_value) {
            $productDet = getPlanID($primary_value);
            unlink("../../" . $config['productImages'] . $productDet['single_images']);
            // Images delete from folder 
            $fileNames = explode(',', $productDet['multiple_images']);
            foreach ($fileNames as $fileName) {
                $filePath = $folderPath . '/' . trim($fileName);
                $pathToFolder = '../../' . $config['productImages'] . trim($fileName);
                if (file_exists($pathToFolder)) {
                    unlink($pathToFolder);
                }
            }
            $output = del_command(tbl_number, "number_id", $primary_value, false);
            $_SESSION['msg'] = $output;
            $_SESSION['alert_type'] = 'success';
        } else {
            $_SESSION['msg'] = 'Invalid Plan Id';
            $_SESSION['alert_type'] = 'error';
        }
        break;

    case "status":
        if (isset($_GET['id'])) {
            $id = urlencode(decryptIt($_GET['id']));
            $row = getnumberID($id);
            $st = $row['status'];
        }
        if ($st == "0") {
            $status = "1";
        } else {
            $status = "0";
        }
        $field['status'] = $status;
        $primary_value = $id;
        $output =  save_command(tbl_number, $field, "number_id", $primary_value);
        $_SESSION['msg'] = $output;
        $_SESSION['alert_type'] = 'success';
        break;
}

// Redirect to the appropriate URL
header("Location: " . $url_return);
