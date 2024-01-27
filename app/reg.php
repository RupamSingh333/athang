<?php
include("system_config.php");
$url_return = SITEPATH . 'sign-up';


$queryu = "SELECT * FROM customer where user_email = '" . $_REQUEST["user_email"] . "' or user_phone = '" . $_REQUEST["user_phone"] . "'";
$resultu = mysqli_query($link, $queryu);
$rowcount = mysqli_num_rows($resultu);
if ($rowcount == "0") {
	function generateRandomString($length = 10)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[random_int(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	$pass = generateRandomString();
	$dates = date('Y-m-d h:i:s');

	$sql = "INSERT into customer (user_email,user_phone,user_pass,user_type,first_name,o_name,gst,user_address,user_country,user_state,user_district,user_pincode,user_startfrom,user_desc,user_status) values ('" . $_REQUEST["user_email"] . "','" . $_REQUEST["user_phone"] . "','" . encryptIt($pass) . "','0','" . $_REQUEST["first_name"] . "','" . $_REQUEST["o_name"] . "','" . $_REQUEST["gst"] . "','" . $_REQUEST["user_address"] . "','0','2','" . $_REQUEST["user_district"] . "','" . $_REQUEST["user_pincode"] . "','" . $dates . "','" . $_REQUEST["user_desc"] . "','0')";
	mysqli_query($link, $sql);
	$_SESSION['msg'] = 'success';
	$_SESSION['pass'] = $pass;
?>
	<script type="text/javascript" language="javascript">
		window.location.href = 'Login';
	</script>
<?php
} else {
	$_SESSION['msg'] = 'error';
?>
	<script type="text/javascript" language="javascript">
		alert("Already Registered");
		window.location.href = 'sign-up';
	</script>
<?php
}

?>