<?php
$dbhost = "localhost";
$dbuser = "rupamsingh";
$dbpass = "ea9E@t068";
$db = "athang";

$link = mysqli_connect($dbhost, $dbuser, $dbpass);
mysqli_select_db($link, $db);

if ($link->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function connectme()
{
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $db = "athang";
    $con = mysqli_connect($dbhost, $dbuser, $dbpass);
    mysqli_select_db($con, $db);

    return $con;
}

function FetchAll($sql)
{
    $link = connectme();
    $rowObj = mysqli_query($link, $sql);
    $result = array();
    $i = 0;
    while ($rows = mysqli_fetch_object($rowObj)) {
        foreach ($rows as $k => $v) {
            $result[$i][$k] = stripslashes($v);
        }
        $i++;
    }
    mysqli_free_result($rowObj);
    return $result;
}

function FetchRow($sql)
{
    $link = connectme();
    $rowObj = mysqli_query($link, $sql);
    $result = array();
    while ($rows = mysqli_fetch_object($rowObj)) {
        foreach ($rows as $k => $v) {
            $result[$k] = stripcslashes($v);
        }
    }
    mysqli_free_result($rowObj);
    return $result;
}

function run_mysql_query($sql)
{
    $link = connectme();
    mysqli_query($link, $sql);
}
