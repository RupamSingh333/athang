<?php
include("system_config.php");
$url_return = SITEPATH . 'index.php';
$userName = $_REQUEST['userName'];
$userEmail = $_REQUEST['userEmail'];
$userPhone = $_REQUEST['userPhone'];
$userMsg = $_REQUEST['userMsg'];
$dates = date('Y-m-d');
$sql = "INSERT INTO `contactus` (`contactus_id` ,`name` ,`email` ,`telephone` ,`comment` ,`contact_createdon` ,`contact_updatedon` ,`isdeleted` ,`status` ,
`address`)VALUES (NULL , '" . $userName . "', '" . $userEmail . "', '" . $userPhone . "', '" . $userMsg . "', '" . $dates . "', '', '0', '1', '');";
//echo 	$sql;die();
mysqli_query($link, $sql)
?>
<script type="text/javascript" language="javascript">
	alert("Msg is sent");
	window.location.href = 'index.php';
</script>
<?php
?>