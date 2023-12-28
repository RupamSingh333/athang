<?php
include("./system_config.php");

// pr($_POST);
// update product 
$primary_value = decryptIt(urldecode(get_safe_post('data_id')));
$dealerId = decryptIt(get_safe_post('dealerId'));
$path = ABSPATH . $config['productImages'];
// pr($_POST);die;
if ($primary_value) {
    
    $productDet = getProductID($primary_value,'A'); // A is for admin
    // pr($_POST) ;die;
    // pr($productDet['status']);
    if ($productDet) {
        $field = array();
        $field['product_name'] = get_safe_post('product_name');
        $field['category_id'] = get_safe_post('category_id');
        $field['dealer_price'] = get_safe_post('dealer_price');
        $field['dealer_discount_price'] = get_safe_post('dealer_discount_price');
        $field['dealer_percentage'] = get_safe_post('dealer_percentage');
        $field['customer_price'] = get_safe_post('customer_price');
        $field['customer_discount_price'] = get_safe_post('customer_discount_price');
        $field['customer_percentage'] = get_safe_post('customer_percentage');
        $field['video'] = get_safe_post('video');
        $field['manufacturer'] = get_safe_post('manufacturer');
        $field['manufacturer_part_number'] = get_safe_post('manufacturer_part_number');
        $field['sku'] = get_safe_post('sku');
        $field['brand'] = get_safe_post('brand');
        $field['quantity'] = get_safe_post('quantity');
        $field['features'] = get_safe_post('features');
        $field['feature_details'] = get_safe_post('feature_details');
        $field['country_of_origin'] = get_safe_post('country_of_origin');
        $field['color'] = get_safe_post('color');
        $field['related_products'] = get_safe_post('related_products');
        $field['weight'] = get_safe_post('weight');
        $field['ratings'] = get_safe_post('ratings');
        // $field['status'] = get_safe_post('status');
        $field['description'] = get_safe_post('description');
        $field['visibility'] = get_safe_post('visibility');


        if (!empty($_POST['subcategory_id'][0])) {
            $subCatIds = array();
            foreach ($_POST['subcategory_id'] as $key => $value) {
                $subCatIds[] = $value;
            }
            $field['subcategory_id'] = implode(",", $subCatIds);
        }
        // pr($_POST);die;
        //Single image
        if ($_FILES["single_images"]["error"] == 0) {
            $file_name = $_FILES["single_images"]["name"];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $unique_name = time() . "_" . uniqid() . "_single";
            $img_name = $unique_name . '.' . $file_ext;
            move_uploaded_file($_FILES["single_images"]["tmp_name"], $path . $img_name);
            $field['single_images'] = $img_name;
            if ($primary_value) {
                unlink($path . $productDet['single_images']);
            }
        }

        // Multiple images 
        if ($_FILES["multiple_images"]["error"][0] == 0) {
            $multiple_images = array();
            foreach ($_FILES["multiple_images"]["tmp_name"] as $key => $tmp_name) {
                if ($_FILES["multiple_images"]["error"][$key] == 0) {
                    $file_name = $_FILES["multiple_images"]["name"][$key];
                    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                    $unique_name = substr(uniqid(), 0, 10); // Generate a shorter unique identifier
                    $img_name = time() . "_" . $unique_name . "_" . $key . '_multiple.' . $file_ext;
                    $img_name = substr($img_name, 0, 100);
                    move_uploaded_file($tmp_name,  $path . $img_name);
                    $multiple_images[] = $img_name;
                }
            }
            $field['multiple_images'] = implode(",", $multiple_images);

            // Images delete from folder 
            $fileNames = explode(',', $productDet['multiple_images']);
            foreach ($fileNames as $fileName) {
                $filePath = $folderPath . '/' . trim($fileName);
                $pathToFolder =  $path . trim($fileName);
                if (file_exists($pathToFolder)) {
                    unlink($pathToFolder);
                }
            }
        }
        // pr($field);die;
        // $field['status'] = (!empty($productDet['status'])) ? $productDet['status'] : 1;
        $field['dealer_id'] = decryptIt(get_safe_post('dealerId'));
        $_SESSION['msg'] = "Your Product has been added successfully.";
        $_SESSION['alert_type'] = 'success';
        $output = save_command(tbl_product, $field, "product_id", $primary_value);
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    } else {
        $_SESSION['msg'] = "Invalid Product.";
        $_SESSION['alert_type'] = 'error';
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
} elseif ($dealerId == $_SESSION['dealerId']) {
    // pr('else if') ;die;
    $field = array();
    $field['product_name'] = get_safe_post('product_name');
    $field['category_id'] = get_safe_post('category_id');
    $field['dealer_price'] = get_safe_post('dealer_price');
    $field['dealer_discount_price'] = get_safe_post('dealer_discount_price');
    $field['dealer_percentage'] = get_safe_post('dealer_percentage');
    $field['customer_price'] = get_safe_post('customer_price');
    $field['customer_discount_price'] = get_safe_post('customer_discount_price');
    $field['customer_percentage'] = get_safe_post('customer_percentage');
    $field['video'] = get_safe_post('video');
    $field['manufacturer'] = get_safe_post('manufacturer');
    $field['manufacturer_part_number'] = get_safe_post('manufacturer_part_number');
    $field['sku'] = get_safe_post('sku');
    $field['brand'] = get_safe_post('brand');
    $field['quantity'] = get_safe_post('quantity');
    $field['features'] = get_safe_post('features');
    $field['feature_details'] = get_safe_post('feature_details');
    $field['country_of_origin'] = get_safe_post('country_of_origin');
    $field['color'] = get_safe_post('color');
    $field['related_products'] = get_safe_post('related_products');
    $field['weight'] = get_safe_post('weight');
    $field['ratings'] = get_safe_post('ratings');
    $field['status'] = get_safe_post('status');
    $field['description'] = get_safe_post('description');
    $field['visibility'] = get_safe_post('visibility');

    if ($_POST['subcategory_id']) {
        $subCatIds = array();
        foreach ($_POST['subcategory_id'] as $key => $value) {
            $subCatIds[] = $value;
        }
        $field['subcategory_id'] = implode(",", $subCatIds);
    }


    //Single image
    if ($_FILES["single_images"]["error"] == 0) {
        $file_name = $_FILES["single_images"]["name"];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $unique_name = time() . "_" . uniqid() . "_single";
        $img_name = $unique_name . '.' . $file_ext;
        if (move_uploaded_file($_FILES["single_images"]["tmp_name"], $path . $img_name)) {
            $field['single_images'] = $img_name;
        }
    }

    // Multiple images 
    if ($_FILES["multiple_images"]["error"][0] == 0) {
        $multiple_images = array();
        foreach ($_FILES["multiple_images"]["tmp_name"] as $key => $tmp_name) {
            if ($_FILES["multiple_images"]["error"][$key] == 0) {
                $file_name = $_FILES["multiple_images"]["name"][$key];
                $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                $unique_name = substr(uniqid(), 0, 10); // Generate a shorter unique identifier
                $img_name = time() . "_" . $unique_name . "_" . $key . '_multiple.' . $file_ext;
                $img_name = substr($img_name, 0, 100);
                if (move_uploaded_file($tmp_name, $path . $img_name)) {
                    $multiple_images[] = $img_name;
                }
            }
        }
        $field['multiple_images'] = implode(",", $multiple_images);
    }

    $field['status'] = 1;
    $field['dealer_id'] = $dealerId;
    $_SESSION['msg'] = "Your Product has been added successfully.";
    $_SESSION['alert_type'] = 'success';
    $output = save_command(tbl_product, $field, "product_id", $primary_value);
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
} else {
    $_SESSION['msg'] = "Invalid Parameter.";
    $_SESSION['alert_type'] = 'error';
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}
