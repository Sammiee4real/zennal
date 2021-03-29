<?php
session_start();
include('config/functions.php');
$loan_id = $_GET['loan_id'];
$user_id = $_SESSION['user']['unique_id'];
$get_loan_application = get_one_row_from_one_table_by_id('personal_loan_application', 'unique_id', $loan_id, 'approval_status', 1, 'date_created');
$amount = $get_loan_application['user_approved_amount'];
$flutterwave_transfer = flutterwave_transfer($loan_id,$user_id, $amount);
$response_decode = json_decode($flutterwave_transfer, true);
if($response_decode['status'] == "success"){
	//echo "success";
	$insert_transaction = insert_disbursed_loan($user_id, $loan_id, $amount);
	$insert_transaction_decode = json_decode($insert_transaction, true);
	if($insert_transaction_decode['status'] == "1"){
		echo '<meta http-equiv="refresh" content="0; url=okra_debit_confirmation?message=transaction_successful" />';
	}else{
		echo '<meta http-equiv="refresh" content="0; url=okra_debit_confirmation?message=transaction_failed" />';
	}
}else{
	echo '<meta http-equiv="refresh" content="0; url=okra_debit_confirmation?message=transaction_failed" />';
	//echo "failed";
}
?>