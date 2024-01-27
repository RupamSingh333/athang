<?php
include("../../system_config.php");
$action = get_safe_get('action');
$url_return = "../contactus/index.php";
switch ($action) {
    case "save":
         $field = array();
         $field['name'] = get_safe_post('name');
		 $field['email'] = get_safe_post('email');
		 $field['telephone'] = get_safe_post('telephone');
         $field['comment'] = get_safe_post('comment');
		 $field['contact_createdon'] = date('Y-m-d');
		 $field['status'] = get_safe_post('status');
		 $primary_value = get_safe_post('data_id');
         $output =  save_command(tbl_contact, $field, "contactus_id", $primary_value);
         $_SESSION['msg'] = $output;
        break;
  
case "del":
		$field = array();
        $primary_value = urlencode(decryptIt(get_safe_get('id')));
		$output =  del_command(tbl_contact, "contactus_id", $primary_value,false);
        $_SESSION['msg'] = $output;
        break;
  
case "status":
			if(isset($_GET['id']))
			{
 			  $id=urlencode(decryptIt($_GET['id']));
			  $row = getcontact_byID($id);
			  $st=$row['status'];
			}
			if($st=="0")
			{
				$status="1";
			}
			else
			{
				$status="0";
			}
		 $field['status'] = $status;
		 $primary_value =$id;
         $output =  save_command(tbl_contact,$field,"contactus_id",$primary_value);
         $_SESSION['msg'] = $output;
		 
     
        break;
}
header("Location:".$url_return);
?>