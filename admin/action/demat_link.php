<?php
include("../../system_config.php");
$action = get_safe_get('action');
$url_return = "../food_shop_bank_demate/add_view_demat_link.php";
switch ($action) {
    case "save":
        $field = array();
        $newLink = get_safe_post('newLink');
        $link_desc = get_safe_post('link_desc');

        // Check if the link already exists
        $getDematLink_byID = getDematLink_byID($newLink);
        if ($getDematLink_byID['demat_link_id']) {
            $_SESSION['msg'] = 'Link already exists.';
            $_SESSION['status'] = 'error';
            break;
        }

        $field['link'] = $newLink;
        $field['link_desc'] = $link_desc;
        $output = save_command(tbl_demat_link, $field, "demat_link_id ", $primary_value);
        $_SESSION['msg'] = $output;
        break;
    case "del":
        $field = array();
        $primary_value = urlencode(decryptIt(get_safe_get('id')));
        $getDematLink_byID = getDematLink_byID($primary_value);
        $output = del_command(tbl_demat_link, "demat_link_id", $primary_value, false);
        $_SESSION['msg'] = $output;
        break;

    case "status":
        if (isset($_GET['id'])) {
            $id = urlencode(decryptIt($_GET['id']));
            $row = getDematLink_byID($id);
            $st = $row['status'];
        }
        if ($st == "0") {
            $status = "1";
        } else {
            $status = "0";
        }

        $statusField = "status";
        $primaryValue = $status;
        $primaryKey = "demat_link_id";

        $result = update_status(tbl_demat_link, $statusField, $primaryValue, $primaryKey, $id);
        $_SESSION['msg'] = $result;
        break;
}

// Redirect to the previous URL
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
