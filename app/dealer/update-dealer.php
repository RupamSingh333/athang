<?php
include("./system_config.php");

if (isset($_POST['dealerId'])) {
    // Existing dealer ID is present, update the fields
    $field = array();
    $primary_value = decryptIt(get_safe_post('dealerId'));
    if ($primary_value) {
        $dealer_profile = getDealerID($primary_value);
    }

    $field['dealer_name'] = get_safe_post('dealer_name');
    $field['dealer_pan_no'] = get_safe_post('dealer_pan_no');
    $field['dealer_gst_no'] = get_safe_post('dealer_gst_no');
    $field['dealer_phone'] = get_safe_post('dealer_phone');
    $field['dealer_altenate_phone'] = get_safe_post('dealer_altenate_phone');
    $field['dealer_billing_address'] = get_safe_post('dealer_billing_address');
    $field['dealer_pincode'] = get_safe_post('dealer_pincode');
    $field['area_street'] = get_safe_post('area_street');
    $field['dealer_state'] = get_safe_post('dealer_state');
    $field['dealer_city'] = get_safe_post('dealer_city');
    $field['landmark'] = get_safe_post('landmark');

    $dealer_cate = get_safe_post('dealer_cate');
    if ($dealer_cate) {
        $field['dealer_cate'] = implode(',', $dealer_cate);
    }

    //dealer_profile image
    $path = ABSPATH . $config['Images'];
    if ($_FILES["dealer_profile"]["error"] == 0) {
        $file_name = $_FILES["dealer_profile"]["name"];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $unique_name = time() . "_" . uniqid() . strtolower(str_replace(" ", "_", $field['dealer_name'])) . '_profile';
        $dealer_img_name = $unique_name . '.' . $file_ext;
        if (move_uploaded_file($_FILES["dealer_profile"]["tmp_name"], $path . $dealer_img_name)) {
            unlink($path . $dealer_profile['dealer_profile']);
            $field['dealer_profile'] = $dealer_img_name;
        }
    }

    //visiting_card image
    if ($_FILES["visiting_card"]["error"] == 0) {
        $file_name = $_FILES["visiting_card"]["name"];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $unique_name = time() . "_" . uniqid() . strtolower(str_replace(" ", "_", $field['dealer_name'])) . '_vist_card';
        $visiting_card_img_name = $unique_name . '.' . $file_ext;
        if (move_uploaded_file($_FILES["visiting_card"]["tmp_name"], $path . $visiting_card_img_name)) {
            unlink($path . $dealer_profile['visiting_card']);
            $field['visiting_card'] = $visiting_card_img_name;
        }
    }
    // Save the changes and redirect
    $_SESSION['msg'] = "Your Profile has been updated successfully.";
    $_SESSION['alert_type'] = 'success';
    $output = save_command(tbl_dealer, $field, "dealer_id", $primary_value);
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
} else {
    $_SESSION['msg'] = "Not Authorized. Please try again.";
    $_SESSION['alert_type'] = 'error';
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}
