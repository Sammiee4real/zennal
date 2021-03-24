<?php
session_start();
include('config/functions.php');
$payment_id = $_GET['payment_id'];
// $tx_ref = $_GET['tx_ref'];
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.okra.ng/v2/pay/verify',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('payment_id' => $payment_id),
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI1ZjVhMmU1ZjE0MGE3YTA4OGZkZWIwYWMiLCJpYXQiOjE1OTk3NDU2MzF9.ptc3Vf6KklgPiDCQXIi3SqpQ7nIlaFcxhhdw0GEtEjU'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
// echo $response;
$response_decode = json_decode($response, true);
// $response_decode['data']['payment_status']['status'];
// print_r($response_decode['data']);
$user_id = $_SESSION['user']['unique_id'];
if($response_decode['data']['payment_status']['status'] == "completed"){
	//echo "success";
	$insert_transaction = insert_payment_transaction($user_id, $payment_id);
	$insert_transaction_decode = json_decode($insert_transaction, true);
	if($insert_transaction_decode['status'] == "1"){
		echo '<meta http-equiv="refresh" content="0; url=loan_purpose?message=transaction_successful&transaction_id='.$payment_id.'" />';
	}else{
		echo '<meta http-equiv="refresh" content="0; url=loan_purpose?message=transaction_failed" />';
	}
}else{
	echo '<meta http-equiv="refresh" content="0; url=loan_purpose?message=transaction_failed" />';
	//echo "failed";
}
?>