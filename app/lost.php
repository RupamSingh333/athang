<?php		
 			include("system_config.php");
			$url_return = SITEPATH.'sign-up';
			if(isset($_REQUEST['username']))
			{
				    $sql = "SELECT * FROM customer WHERE user_email='".$_REQUEST['username']."' or user_phone = '".$_REQUEST["username"]."' LIMIT 1";
					$rows = mysqli_query($link,$sql);
					if(mysqli_num_rows($rows) == 1)
								{ 
									$_SESSION['password'] = $_REQUEST['user_phone'];
									$_SESSION['msg']='success';
									header('Location: lost-password');
								}
								else
								{ 
									$_SESSION['lost'] = 'error'; 
									header('Location: lost-password');
								}	
			
			
			}
			else
			{
				$_SESSION['msg'] = 'lost-password'; 	
			}
			
	
	?>