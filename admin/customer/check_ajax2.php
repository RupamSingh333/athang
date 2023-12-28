<?php
include("../../system_config.php");
$prefix = "";

?>
<?php
$prefix = "";
if (!empty($_POST['cust_phone'])) {
	$cust_phone = $_POST['cust_phone'];
	$sql_check = mysqli_query($link, "SELECT cust_phone FROM customer WHERE cust_phone='$cust_phone'");
	$row1 = mysqli_fetch_row($sql_check);
	if (!empty($row1)) {
		echo '<div style="color:#c40000;"><STRONG>' . $cust_phone . '</STRONG> is already in use.</div>';
	} else {
		echo 'OK';
	}
}
?>