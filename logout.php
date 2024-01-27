<?php 
ob_start();
session_start();
include 'webadmin/config.php';
unset($_SESSION['seller']);
header("location: login.php"); 
?>