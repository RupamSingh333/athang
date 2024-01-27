<?php		
 			include("system_config.php");
			$url_return = SITEPATH.'index.php';
			$dates=date('Y-m-d');
			if(isset($_REQUEST['user_phone']))
			{
					$sql = "SELECT * FROM customer WHERE user_phone='".$_REQUEST['user_phone']."' and user_status='0' LIMIT 1";
					$rows = mysqli_query($link,$sql);
					if(mysqli_num_rows($rows) == 1)
								{ 
									$_SESSION['otp'] = (rand(1000,10000)); 
									$_SESSION['otpnumber'] = $_REQUEST['user_phone'];
									$_SESSION['true']="true";
									header('Location: Login');
								}
								else
								{ 
									header('Location: Login');
									$_SESSION['otperror'] = 'error'; 
								}	
			}
			else
			{
				
				if($_SESSION['otp']==$_REQUEST['user_otp'])
				{
					$sql = "SELECT * FROM customer WHERE user_phone='".$_SESSION['otpnumber']."' and user_status='0' LIMIT 1";
					$rows = mysqli_query($link,$sql);
					if(mysqli_num_rows($rows) == 1)
								{ 
									$row = mysqli_fetch_row($rows);
									$_SESSION['userid'] = $row['0'];
									unset($_SESSION['otperror']);
									unset($_SESSION['otp']);
									unset($_SESSION['otpnumber']); 
									unset($_SESSION['true']); 
									if(isset($_SESSION["shopping_cart"])){
					header('Location: Checkout');
				}
				else
				{
            		header('Location: account-settings');
				}
            	
            						
									
								}
								else
								{ 
								
								header('Location: Login');
								$_SESSION['otperror'] = 'error'; 
								
											
								}		
				}
				else
				{
									if(isset($_REQUEST['user_otp']))
									{
										header('Location: Login');
										$_SESSION['otperrornew'] = 'error'; 
										$_SESSION['true']="true";
									}
									else
									{
										$_SESSION['otperrornew'] = 'error'; 
										$_SESSION['true']="true";	
										$_SESSION['otp'] = (rand(1000,10000)); 
										if(isset($_SESSION["shopping_cart"])){
					header('Location: Checkout');
				}
				else
				{
            		header('Location: account-settings');
				}
									}
									
				}
				
				
				
					
			}?>
