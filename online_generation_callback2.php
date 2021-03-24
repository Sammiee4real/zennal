<?php
session_start();
include('config/functions.php');
$transaction_id = $_GET['transaction_id'];
$tx_ref = $_GET['tx_ref'];
$id = $_GET['id'];
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/".$transaction_id."/verify",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "Authorization: Bearer FLWSECK_TEST-0c1450bff1fe587e3164a42ef28e90be-X"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
$response_decode = json_decode($response, true);
$get_user_details = get_one_row_from_one_table_by_id('users', 'email', $response_decode['data']['customer']['email'], 'registered_on');
$user_id = $get_user_details['unique_id'];
if($response_decode['data']['status'] == "successful"){
	//echo "success";
	$insert_transaction = insert_payment_transaction($user_id, $tx_ref, $transaction_id);
	$insert_transaction_decode = json_decode($insert_transaction, true);
	if($insert_transaction_decode['status'] == "1"){
		echo  '<meta http-equiv="refresh" content="0; url=asset_loan_purpose.php?id='.$id.'&message=transaction_successful&transaction_id='.$transaction_id.'" />';
	}else{
		echo '<meta http-equiv="refresh" content="0; url=asset_loan_purpose.php?message=transaction_failed" />';
	}
}else{
	echo '<meta http-equiv="refresh" content="0; url=asset_loan_purpose.php?message=transaction_failed" />';
	//echo "failed";
}
?>