<?php
include("../../system_config.php");
$action = get_safe_get('action');
$url_return = "../taluka/index.php";
switch ($action) {
    case "save":
        // pr($_POST);exit;
        $field = array();
        $primary_value = get_safe_post('data_id');
        $get_product = gettaluka_byID($primary_value);
        $field['taluka_state_id'] = get_safe_post('taluka_state_id');
        $field['taluka_district_id'] = get_safe_post('taluka_district_id');
        $field['taluka_name'] = get_safe_post('taluka_name');
        $field['taluka_desc'] = get_safe_post('taluka_desc');
        $field['taluka_status'] = get_safe_post('taluka_status');

        $output =  save_command(tbl_taluka, $field, "taluka_id", $primary_value);
        $_SESSION['msg'] = $output;
        $_SESSION['alert_type'] = 'success';
        break;

    case "del":
        $field = array();
        $primary_value = urlencode(decryptIt(get_safe_get('id')));
        $output =  del_command(tbl_taluka, "taluka_id", $primary_value, false);
        $_SESSION['msg'] = $output;
        $_SESSION['alert_type'] = 'success';
        break;

    case "status":
        if (isset($_GET['id'])) {
            $id = urlencode(decryptIt($_GET['id']));
            $row = gettaluka_byID($id);
            $st = $row['taluka_status'];
        }

        if ($st == "0") {
            $status = "1";
        } else {
            $status = "0";
        }


        $statusField = "taluka_status";
        $primaryValue = $status;
        $primaryKey = "taluka_id";

        $output =  update_status(tbl_taluka, $statusField, $primaryValue, $primaryKey, $id);
        $_SESSION['msg'] = $output;
        $_SESSION['alert_type'] = 'success';

        break;
}
header("Location:" . $url_return);
