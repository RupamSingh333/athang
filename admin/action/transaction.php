<?php
include("../../system_config.php");
$action = get_safe_get('action');
$url_return = "../transaction/index.php";

switch ($action) {
    case "save":
        
		$field['status'] = get_safe_post('status');
		$field['ref_ID'] = get_safe_post('ref_ID');
		 $primary_value = get_safe_post('data_id');
         $output =  save_command(tbl_wallet_history,$field,"id",$primary_value);
         $_SESSION['msg'] = $output;
		
        break;
		
case "del":
		$field = array();
        $primary_value = urlencode(decryptIt(get_safe_get('id')));
		$output =  del_command(tbl_ordertable_product, "order_id", $primary_value,false);
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