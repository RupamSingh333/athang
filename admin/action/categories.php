<?php
include("../../system_config.php");
$action = get_safe_get('action');
$url_return = "../Category/index.php";
switch ($action) {
    case "save":
        $field = array();
        $primary_value = get_safe_post('data_id');
        $getCategory = getCategory_byID($primary_value);
        $field['cat_name'] = get_safe_post('cat_name');
        $field['cat_status'] = get_safe_post('cat_status');
        $field['sort'] = get_safe_post('sort');
        $field['cat_description'] = get_safe_post('cat_description');
        $field['cat_startfrom'] = date('Y-m-d H:i:s');
        $img_name = "";

        if ($_FILES["cat_thumbimg"]["error"] == 0) {
            $img_name = time() . "_" . strtolower(str_replace(" ", "_", $_FILES["cat_thumbimg"]["name"]));
            move_uploaded_file($_FILES["cat_thumbimg"]["tmp_name"], "../../" . $config['category_thumb'] . $img_name);
            $field['cat_thumbimg'] = $img_name;
            if ($getCategory) {
                unlink("../../" . $config['category_thumb'] . $getCategory['cat_thumbimg']);
            }
        }

        $output =  save_command(tbl_categories, $field, "cat_id", $primary_value);
        $_SESSION['msg'] = $output;
        break;

    case "del":
        $field = array();
        $primary_value = urlencode(decryptIt(get_safe_get('id')));
        // print_r($primary_value);die;
        $getCategory = getCategory_byID($primary_value);
        $output =  del_command(tbl_categories, "cat_id", $primary_value, false);

        if ($getCategory) {
            unlink("../../" . $config['category_thumb'] . $getCategory['cat_thumbimg']);
        }

        $_SESSION['msg'] = $output;
        break;

    case "status":

        if (isset($_GET['id'])) {
            $id = urlencode(decryptIt($_GET['id']));
            $row = getCategory_byID($id);
            $st = $row['cat_status'];
        }
        if ($st == "0") {
            $status = "1";
        } else {
            $status = "0";
        }

        $link = connectme();
        $statusField = "cat_status";
        $primaryValue = $status;
        $primaryKey = "cat_id";

        $result = update_status(tbl_categories, $statusField, $primaryValue, $primaryKey, $id);
        $_SESSION['msg'] = $result;
        break;

    case "featured":

        if (isset($_GET['id'])) {
            $id = urlencode(decryptIt($_GET['id']));
            $row = getCategory_byID($id);
            $st = $row['featured'];
        }
        if ($st == "Y") {
            $status = "N";
        } else {
            $status = "Y";
        }

        $link = connectme();
        $primaryKey = "cat_id";
        $primaryValue = $status;
        $statusField = "featured";
        $result = update_status(tbl_categories, $statusField, $primaryValue, $primaryKey, $id);
        // print_r($result);die;
        $_SESSION['msg'] = $result;
        break;
}
header("Location:" . $url_return);
