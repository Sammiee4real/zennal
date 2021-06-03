<?php
	require_once('../../config/functions.php');
	$data = ["approval_status"];
	$unique_id = $_POST['unique_id'];
	$get_user_id = get_one_row_from_one_table_by_id('personal_loan_application','unique_id', $unique_id, 'date_created');
	$get_user= get_one_row_from_one_table_by_id('users','unique_id', $get_user_id['user_id'], 'registered_on');
	$user_email = $get_user['email']; 
	$subject = "Loan Application - Zennal";
	$content = "Hello, your loan application on Zennal has been rejected, we are sorry about this. <br>Please check back later. Thanks";
	$reject_loan_application = update_data('personal_loan_application', $data, 'unique_id', $unique_id);
	$reject_loan_application_decode = json_decode($reject_loan_application, true);
	if($reject_loan_application_decode['status'] == "1"){
		echo "success";
		email_function($user_email, $subject, $content);
	}
	else{
		echo $reject_loan_application_decode['msg'];
	}
?>