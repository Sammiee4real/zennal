<?php
	session_start();
	include('config/functions.php');
	$unique_id = $_GET['unique_id'];
	$user_id = $_SESSION['user']['unique_id'];
	$received_json = $_POST['data'];
	$get_loan_application = get_one_row_from_one_table_by_id('vehicle_reg_installment', 'unique_id', $unique_id, 'approval_status', 1, 'date_created');
	$amount = $get_loan_application['total'] - ((30/100) * $get_loan_application['total']);
	// $flutterwave_transfer = flutterwave_transfer($unique_id,$user_id, $amount);
	// $response_decode = json_decode($flutterwave_transfer, true);
	$insert_transaction = insert_disbursed_loan($user_id, $unique_id, $amount, $received_json);
	$insert_transaction_decode = json_decode($insert_transaction, true);
	if($insert_transaction_decode['status'] == "1"){
		echo '<meta http-equiv="refresh" content="0; url=okra_debit_confirmation?message=transaction_successful" />';
	}else{
		echo '<meta http-equiv="refresh" content="0; url=okra_debit_confirmation?message=transaction_failed" />';
	}
?>