<?php
	require_once('../../config/functions.php');
	$request_id = $_POST['unique_id'];
	$get_user_id = get_one_row_from_one_table_by_id('withdrawal_request','unique_id', $request_id, 'date_created');
	$get_user= get_one_row_from_one_table_by_id('users','unique_id', $get_user_id['user_id'], 'registered_on');
	$user_email = $get_user['email']; 
	$amount = $get_user_id['amount'];
	$subject = "Withdrawal Request - Zennal";
	$content = "Hello, your withdrawal request of ".$amount." has been rejected please contact Zennal to know more<br>Thanks";
	$reject_withdrawal = update_by_one_param('withdrawal_request','status', 2, 'unique_id', $request_id);
	if($reject_withdrawal){
		echo "success";
		email_function($user_email, $subject, $content);
	}
	else{
		echo "Please try again";
	}
?>