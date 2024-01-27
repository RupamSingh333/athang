<?php		
 			include("system_config.php");
			$url_return = SITEPATH.'Submit-your-cv';
			$dates=date('Y-m-d h:i:s');
			 if ($_FILES["thumbimg"]["error"] == 0) {
                $img_name = time() . "_" . strtolower(str_replace(" ", "_", $_FILES["thumbimg"]["name"]));
                move_uploaded_file($_FILES["thumbimg"]["tmp_name"], "./" . $config['category_thumb'] . $img_name);
            }
			$sql="INSERT INTO `cv` (`cv_id`, `cv_name`, `cv_email`, `cv_number`, `cv_company`, `cv_desc`, `cv_fun`, `cv_ind`, `cv_loc`, `cv_exp`, `cv_salary`, `cv_file`, `cv_date`, `cv_status`) VALUES (NULL, '".$_REQUEST["cv_name"]."', '".$_REQUEST["cv_email"]."', '".$_REQUEST["cv_number"]."', '".$_REQUEST["cv_company"]."', '".$_REQUEST["cv_desc"]."', '".$_REQUEST["cv_fun"]."', '".$_REQUEST["cv_ind"]."', '".$_REQUEST["cv_loc"]."', '".$_REQUEST["cv_exp"]."', '".$_REQUEST["cv_salary"]."', '".$img_name."', '".$dates."', '0');";
//echo 	$sql;die();
mysql_query($sql);
?>
<script type="text/javascript" language="javascript">
			  alert("your resume has been submitted successfully");
			 window.location.href = 'Submit-your-cv';
		  </script>
<?php 
			//echo $sql;
			/*$subject = "Message from ".$userName; 
			$message = '<html><head><title>'.$subject.'</title></head><body><table><tr><td>Email id :  </td><td> '.$userEmail.'</td></tr>
<tr><td>Phone No : </td><td> '.$userPhone.'</td></tr><tr><td>Name : </td><td> '.$userName.'</td></tr><tr><td>Says : </td><td> '.$userMsg.'</td>
</tr></table></body></html>';
			//$message = "Email id :  ".$userEmail. "\r\nPhone No : ".$userPhone."\r\nName : ".$userName."\r\nSays : ".$userMsg;
			$to=$email_id;
			$headers = "From: " . strip_tags($userEmail) . "\r\n";
			$headers .= "Reply-To: ". strip_tags($userEmail) . "\r\n";
			//$headers .= "CC: susan@example.com\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			if(!mail($to, $subject, $message, $headers))
			{
             	$mail_status='no';?>
			window.location()
<?php 

				exit();
          	}
		  	else
		  	{
           		$mail_status='yes';
         	 		header("Location:".$url_return);

				exit(); 
          	}*/header("Location:".$url_return);
		  ?>