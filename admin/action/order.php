<?php
include("../../system_config.php");
$action = get_safe_get('action');
$url_return = "../order/index.php";

switch ($action) {
    case "save":
         $field = array();
		 $field['customer_id'] = get_safe_post('customer_id');
         $field['orderdate'] = get_safe_post('datepicker1');
		 $field['user_id'] = $_SESSION['AdminLogin'];
		
		 $field['paymentstatus'] = get_safe_post('paymentstatus');
		 $field['paymentyype'] = get_safe_post('paymentyype');
		 $field['orderstatus'] = get_safe_post('orderstatus');
		 $field['bank_ref_num'] = get_safe_post('bank_ref_num');
		 $primary_value = get_safe_post('data_id');
         $output =  save_command(tbl_order,$field,"order_id",$primary_value);
         $_SESSION['msg'] = $output;
		
        break;
		
case "del":
		$field = array();
        $primary_value = urlencode(decryptIt(get_safe_get('id')));
		$output =  del_command(tbl_order, "order_id", $primary_value,false);
		$output =  del_command(tbl_order, "order_id", $primary_value,false);
        $_SESSION['msg'] = $output;
        break;
		
		
case "status":
			if(isset($_GET['id']))
			{
				
			  $id=urlencode(decryptIt($_GET['id']));
			  $row = getorders_byID($id);
			  $st=$row['orderstatus'];
			}
			if($st=="0")
			{
				$status="1";
			}
			else
			{
				$status="0";
			}
		 $field['orderstatus'] = $status;
		 $primary_value =$id;
         $output =  save_command(tbl_order,$field,"order_id",$primary_value);
         $_SESSION['msg'] = $output;
		 
        break;
		
case "order_status":
			if(isset($_REQUEST['id']))
			{
				
			  $id=urlencode(decryptIt($_REQUEST['id']));
			  $row = getorders_byID($id);
			  $st=$row['order_status'];
			}
			if($st=="0")
			{
				$status="1";
			}
			else
			{
				$status="0";
			}
		 $field['order_status'] = $status;
		 $primary_value =$id;
         $output =  save_command(tbl_order,$field,"id",$primary_value);
         $_SESSION['msg'] = $output;
		 
        break;		
		
		
}
header("Location:".$url_return);
?>