<?php
namespace APITestCode;
require_once('PayU.php');
include("system_config.php");

$sql = "SELECT * FROM customer WHERE user_id='".$_SESSION['userid']."' and user_status='0' LIMIT 1";
$rows = mysqli_query($link,$sql);
			
			if(mysqli_num_rows($rows) == 1)
			{ 
				$row = mysqli_fetch_row($rows);
				if(isset($_SESSION["shopping_cart"]))
				{

						$orderdate = date('d/m/Y');
						$sql="INSERT into ordertable (customer_id,orderdate,status,paymentyype) values ('".$_SESSION['userid']."','".$orderdate."','0','1')"; 
						$rows = mysqli_query($link,$sql);
						$id= mysqli_insert_id($link);
						$k="0";
							foreach ($_SESSION["shopping_cart"] as $cart_itm)
							{
								
								$sql="INSERT INTO `ordertable_product` (`order_product_id`, `order_id`, `product_id`, `name`, `count`, `quantity`, `price`) VALUES (NULL, '".$id."', '".$cart_itm["code"]."', '".$cart_itm["name"]."', '".$cart_itm["count"]."', '".$cart_itm["quantity"]."', '".$cart_itm["price"]."')"; 
								mysqli_query($link,$sql);
								$total_price += ($cart_itm["price"]*$cart_itm["quantity"]);
								$k = $k+1;
							}
						$gst = $total_price*18/100;
						$final_price = $gst+$total_price;
						$sql="UPDATE `ordertable` SET `quantity` = '".$k."', `tprice` = '".$final_price."' WHERE `ordertable`.`order_id` = ".$id; 
						mysqli_query($link,$sql);
						
						if($final_price<=$row['22'])
						{
									$amount = $row['22']-$final_price;
									$sql="INSERT INTO `wallet_history` (`id`, `username`, `amount`, `remaining_amount`, `ref_ID`, `type`, `wallet`, `date_time`, `order_id`, `status`) VALUES (NULL, '".$_SESSION['userid']."', '".$final_price."', '".$amount."', '".$id."', 'Dr', 'order', '".date('Y-m-d H:i:s')."','".$id."','1');";
									$rows = mysqli_query($link,$sql);
									$idnew= mysqli_insert_id($link);
									$sql="UPDATE `ordertable` SET `paymentyype` = '0',`paymentstatus` = '1',`orderstatus` = '1', `bank_ref_num` = '".$idnew."' WHERE `ordertable`.`order_id` = ".$id;
	    mysqli_query($link,$sql);
		
		
		
									$sql="UPDATE `customer` SET `fund_wallet` = '".$amount."' WHERE `customer`.`user_id` = ".$_SESSION['userid'];
	    mysqli_query($link,$sql);
		unset($_SESSION["shopping_cart"]);
		$_SESSION['msg']='success';
		header('Location: downloads');		
						}
						else
						{
							$_SESSION['error']='error';
							header('Location: downloads');			
						}
						
				}
				else
				{
					$_SESSION['error']='error';
					header('Location: downloads');	
				}
			}
			else
			{
				$_SESSION['error']='error';
				header('Location: downloads');		
			}	

?>