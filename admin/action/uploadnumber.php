<?php
include("../../system_config.php");
$action = $_GET['action'] ?? '';
$url_return = "../Number/index.php";
switch ($action) {
    case "save":
	 if (($handle = fopen($_FILES['single_images']['tmp_name'], "r")) !== FALSE)
		 {
			
   			fgetcsv($handle);   
  			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
			{
				 $num = count($data);
				$sql_check = mysqli_query($link,"SELECT number_number FROM number WHERE number_number='".$data[0]."'");
				$row1 = mysqli_fetch_row($sql_check);
				
				if (!empty($row1))
				{
					 
					 $_SESSION['type']="1";
				}
				else
				{
					 $field = array();
			   
					$field['category_id'] = get_safe_post('category_id');
					$field['subcategory_id'] = get_safe_post('subcategory_id');
					$field['plan_id'] = get_safe_post('plan_id');
					 $field['number_number'] = $data[0];
					 $field['sim_number'] = $data[1];
					$field['quantity'] = $data[2];
					$field['sku'] = $data[3];
					$field['sort'] = $data[4];
					$field['description'] = $data[5];
					$field['user_id'] = get_safe_post('user_id');
					
					$field['created_date'] = date('Y-m-d H:i:s');
					$field['updated_date'] = date('Y-m-d H:i:s');
					
				  
						$output = save_command(tbl_number, $field, "number_id", $primary_value);
						$_SESSION['msg'] = $output;
						
				}
       
           
				}
   			fclose($handle);
		}
		if($_SESSION['type']=="1")
		{
			$_SESSION['msg'] = 'some number already used';
		}
		else
		{
			$_SESSION['msg'] = 'success';
		}
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
