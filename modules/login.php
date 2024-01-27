<?php
if (!defined('ABSPATH'))
    die('-1');
define("tbl_login", "reg_user");

function check_authorization($login_detail)
{
    $username = $login_detail['user_email'];
    $userpassword = encryptIt($login_detail['user_pass']);
    $sql = "select * from " . tbl_login . " where user_email ='" . $username . "' and user_pass='" . $userpassword . "'  and user_status = '0' limit 0,1 ";
    $array = FetchRow($sql);
    // print_r($array);
    // die;
    if (empty($array)) {
        $array['error'] = "No records Founds. Pleae try again";
    }
    return $array;
}

function user_authorization($login_detail)
{
    $username = $login_detail['user_email'];
    $userpassword = encryptIt($login_detail['user_pass']);
    $sql = "select * from " . tbl_login . " where user_email ='" . $username . "' and user_pass='" . $userpassword . "'  and user_status = '0' and user_type=0 limit 0,1 ";
    $array = FetchRow($sql);

    if (empty($array)) {
        $array['error'] = "No records Founds. Pleae try again";
    }
    return $array;
}

function password_generator($length = 8)
{
    $output = "";
    return $output;
}

function forgot_password($email = "")
{

    $output = "";
    return $output;
}
function change_password($email = "", $oldpassword = "")
{

    $output = "";
    return $output;
}
