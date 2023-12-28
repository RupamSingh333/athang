<?php	
include './system_config.php';	
session_start();
session_destroy();
header("Location: " . SITEPATH);
exit;

