<?php
@session_start();
date_default_timezone_set('asia/calcutta');
define("ABSPATH", $_SERVER['DOCUMENT_ROOT'] . '/');
define("SITEPATH", "https://new.sumiran.co/");
// define("SITEPATH", "http://localhost/athang/");
define("NOIMAGE", "upload/noimage.jpg");
define("DEFAULTCATADDIMG", "upload/thumb/DEFAULTCATADDIMG.png");
define("USER", "1");
define("CUSTOMER", "4");
define("DEALER", "5");

error_reporting(1);
define("ADMIN_FOLDER", "admin");
function myUrlEncode($string)
{
    $entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
    $replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
    return str_replace($entities, $replacements, urlencode($string));
}

function encryptIt($q)
{
    $ciphering_value = "AES-128-CTR";
    $encryption_key = "JavaTpoint";
    $encryption_value   = openssl_encrypt($q, $ciphering_value, $encryption_key);
    return ($encryption_value);
}

function decryptIt($q)
{
    $ciphering_value = "AES-128-CTR";
    $encryption_key = "JavaTpoint";
    $encryption_value   = openssl_decrypt($q, $ciphering_value, $encryption_key);
    return ($encryption_value);
}

function encryptor($action, $string)
{
    $output = false;
    $encrypt_method = "aes128";
    //pls set your unique hashing key
    $secret_key = 'muni';
    $secret_iv = 'muni123';
    // hash
    $key = hash('sha256', $secret_key);
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    //do the encyption given text/string/number
    if ($action == 'encrypt') {
        $output = openssl_encrypt($string, $encrypt_method, $secret_iv);
        $output = base64_encode($output);
    } else if ($action == 'decrypt') {
        //decrypt the given text/string/number
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $secret_iv);
    }

    return $output;
}

function RemoveSpecialChar($str)
{
    // Using str_replace() function
    // to replace the word
    $res = str_replace(array(
        '\'', '"',
        ',', ';', '<', '>'
    ), ' ', $str);

    // Returning the result
    return $res;
}

function pr($data)
{
    // Convert the data to a string representation
    if (is_array($data) || is_object($data)) {
        $formatted_data = print_r($data, true);
    } else {
        $formatted_data = htmlentities($data);
    }

    // Echo the formatted data
    echo "<pre>{$formatted_data}</pre>";
    // die;
}

// Function to generate a random string
// function generateRandomString($length = 10)
// {
//     $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
//     $randomString = '';
//     for ($i = 0; $i < $length; $i++) {
//         $randomString .= $characters[rand(0, strlen($characters) - 1)];
//     }
//     return $randomString;
// }


include("config_setting/database.php");
include("config_setting/common_function.php");
include("modules/cms.php");
include("modules/login.php");


$config['category_thumb'] = "upload/thumb/";
$config['productImages'] = "upload/productImages/";
$config['Images'] = "upload/Images/";
$config['category_large'] = "upload/large/";
$config['category_video'] = "upload/video/";
$config['video_directory'] = "upload/video/";
$config['display_status'] = array("0" => "Active", "1" => "Inactive");
$config['user_type'] = array("0" => "Admin", "1" => "User", "2" => "Supplier", "3" => "Salesman", "4" => "Customer", "5" => "Dealer");
