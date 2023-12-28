<?php
namespace APITestCode;
require_once('PayU.php');
include("system_config.php");


$orderdate = date('Y-m-d H:i:s');
	$sql="SELECT * FROM `wallet_history` WHERE `username` = '".$_SESSION['userid']."' and `status` = '1'  order by id DESC limit 0,1"; 
	$rows = mysqli_query($link,$sql);
if(mysqli_num_rows($rows) == 1)
{
	$row = mysqli_fetch_row($rows);
	$amount = $row['3']+$_REQUEST['amount'];
	
}
else
{
	$amount =$_REQUEST['amount'];	
}

	$sql="INSERT INTO `wallet_history` (`id`, `username`, `amount`, `remaining_amount`, `ref_ID`, `type`, `wallet`, `date_time`, `status`) VALUES (NULL, '".$_SESSION['userid']."', '".$_REQUEST['amount']."', '".$amount."', '', 'Cr', 'fund_add', '".$orderdate."','0');";
    $rows = mysqli_query($link,$sql);
	
	$id= mysqli_insert_id($link);
	$k="0";

	

$payu_obj = new PayU();
$payu_obj->env_prod = 0;
$payu_obj->key = 'gMBh5o';
$payu_obj->salt = 'dBUXALRJ0BEhgQM1xIYEwcqVzgrwBbnv';
/*
$payu_obj->env_prod = 1;
$payu_obj->key = 'F1X3A5fF';
$payu_obj->salt = 'Fo3MyDEbV9';*/

$res = $payu_obj->initGateway();

//$param['txnid'] = 'Txn_58108912';
//$param['payuid'] = '403993715527315062';
//$res = $payu_obj->verifyPayment($param);

//$param['type'] = 'date';
//$param['type'] = 'time';
//$param['from'] = '2022-09-01';
//$param['to'] = '2022-09-07';
//$param['from'] = '2022-12-22 00:00:00';
//$param['to'] = '2022-12-22 19:00:00';
//$res = $payu_obj->getTransaction($param);

$sql = "SELECT * FROM customer WHERE user_id='".$_SESSION['userid']."' and user_status='0' LIMIT 1";
$rows = mysqli_query($link,$sql);
if(mysqli_num_rows($rows) == 1)
			{ 
$row = mysqli_fetch_row($rows);
	$res = getState_byID($row['14']);
	
$param['txnid'] = $id;
$param['firstname'] = $row['1'];
$param['lastname'] = '';
$param['amount'] = $_REQUEST['amount'];
$param['email'] = $row['5'];
$param['productinfo'] = $id;
$param['phone'] = $row['12'];
$param['address1'] = $row['17'];
$param['city'] = $row['13'];
$param['state'] = $res['name'];
$param['country'] = $config['country'][$row['11']];
$param['zipcode'] = $row['21'];
//$param['api_version'] = '1';
$param['udf1'] = '';


$res = $payu_obj->showPaymentForm($param);

/*$sql="UPDATE `ordertable` SET `mihpayid` = '".$res['mihpayid']."', `bank_ref_num` = '".$res['bank_ref_num']."' WHERE `ordertable`.`order_id` = ".$res['txnid'];
	    mysqli_query($link,$sql);*/
		

/*$param['firstname'] = 'Geeta';
$param['amount'] = 500;
$param['email'] = 'geeta_test@gmail.com';
$param['productinfo'] = 'Pant';
$param['key'] = 'gMBh5o';
$param['txnid'] = 'Txn_581087';
$param['udf5'] = '';
$param['status'] = 'success';
$param['hash'] = '9428278f4e92f4cfbe22c8d21b960ee4bf26c8c0eb78926cd0455da6dd50f60ca8c966ea8b8b220c471d71834eb818c0949500fc351faeb388c7ebd9810faba0';
$res = $payu_obj->verifyHash($param);*/

//$param['cardnum'] = '512345';
//$res = $payu_obj->getCardBin($param);

/*$param['type'] = '1';
$param['card_info'] = '512345';
$param['index'] = '0';
$param['offset'] = '100';
$param['zero_redirection_si_check'] = '1';
$res = $payu_obj->getBinDetails($param);*/

/*$param['payuid'] = 403993715527315062;
$param['txnid'] = 'Txn_581087';
$param['amount'] = 500;
$res = $payu_obj->cancelRefundTransaction($param);*/

//$param['request_id'] = 134482239;
//$res = $payu_obj->checkRefundStatus($param);

//$param['payuid'] = 403993715527315062;
//$res = $payu_obj->checkRefundStatusByPayuId($param);

//$param['txnid'] = 'Txn_581087';
//$res = $payu_obj->checkAllRefundOfTransactionId($param);


//$param['netbanking_code'] = 'AXIB';
//$res = $payu_obj->getNetbankingStatus($param);

//$param['cardnum'] = '512345';
//$res = $payu_obj->getIssuingBankStatus($param);

//$param['vpa'] = '9999999999@upi';
//$param['vpa'] = '9044841388@paytm';
//$param['auto_pay_vpa'] = '';
//$param['auto_pay_vpa'] = '{"validateAutoPayVPA":"1"}';

//$res = $payu_obj->validateUpi($param);


//$details = ["amount"=>"100", "txnid"=>"test11390", "productinfo"=>"shirt", "firstname"=>"Priyanka", "email"=>"test@gmail.com", "phone"=>"9988776655", "address1"=>"testaddress", "city"=>"test", "state"=>"test", "country"=>"test", "zipcode"=>"122002", "template_id"=>"1200", "sms_template_id"=>"1010", "validation_period"=>"6", "send_email_now"=>"1", "send_sms"=>"1"];
/*$details = ["amount"=>"100", "txnid"=>"test11390", "productinfo"=>"shirt", "firstname"=>"Priyanka", "email"=>"test@gmail.com", "phone"=>"9988776655", "address1"=>"testaddress", "city"=>"test", "state"=>"test", "country"=>"test", "zipcode"=>"122002", "validation_period"=>"6", "send_email_now"=>"1", "send_sms"=>"1"];
$param['details'] = json_encode($details);
$res = $payu_obj->createPaymentInvoice($param);*/

//$param['txnid'] = 'test11390';
//$res = $payu_obj->expirePaymentInvoice($param);

//$param['amount'] = 20000;
//$res = $payu_obj->getEmiAmount($param);

//$param['bin'] = "bin";
//$param['card_num'] = "512345";
//$param['bank_name'] = "AXIS";
//$param['bank_name'] = "";
//$res = $payu_obj->checkEligibleEMIBins($param);

//$param['data'] = '2020-10-26';
//$res = $payu_obj->getSettlementDetails($param);

//$param['data'] = '';
//$res = $payu_obj->getCheckoutDetails($param);

			}
			else
			{
				header('Location: index.php');	
			}

?>