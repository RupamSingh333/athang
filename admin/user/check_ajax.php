<?php
include("../../system_config.php");
$prefix = "";

?>
<?php
$prefix = "";
if (!empty($_POST['user_email']))
{
	$email = $_POST['user_email'];	
	$sql_check = mysqli_query($link,"SELECT user_email FROM reg_user WHERE user_email='$email'");
	$row1 = mysqli_fetch_row($sql_check);
	if (!empty($row1))
	{
		echo '<div style="color:#c40000;"><STRONG>' . $email . '</STRONG> is already in use.</div>';
	}
	else
	{
		echo 'OK';
	}
}
?>