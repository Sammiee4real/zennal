<?php
	require_once('../../config/functions.php');
	$data = ["minimum_repayment_month", "maximum_repayment_month", "user_approved_equity_con", "loan_interest", "approval_status"];
	$unique_id = $_POST['unique_id'];
	$get_user_id = get_one_row_from_one_table_by_id('asset_finance_application','unique_id', $unique_id, 'date_created');
	$get_user= get_one_row_from_one_table_by_id('users','unique_id', $get_user_id['user_id'], 'registered_on');
	$user_email = $get_user['email']; 
	$subject = "Loan Application - Zennal";
	$content = "Hello, your loan application on Zennal has been approved, please login to finish your application<br>Thanks";
	$approve_loan_application = update_db('asset_finance_application', $unique_id,'unique_id', '', $data);
	$approve_loan_application_decode = json_decode($approve_loan_application, true);
	if($approve_loan_application_decode['status'] == "1"){
		echo "success";
		email_function($user_email, $subject, $content);
	}
	else{
		echo $approve_loan_application_decode['msg'];
	}
?>