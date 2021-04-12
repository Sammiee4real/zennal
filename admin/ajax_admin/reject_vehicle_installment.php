<?php
	require_once('../../config/functions.php');
	$unique_id = $_POST['unique_id'];
	$get_user_id = get_one_row_from_one_table_by_id('vehicle_reg_installment','unique_id', $unique_id, 'date_created');
	$get_user= get_one_row_from_one_table_by_id('users','unique_id', $get_user_id['user_id'], 'registered_on');
	$user_email = $get_user['email']; 
	$subject = "Loan Application - Zennal";
	$content = "Hello, your Vehicle Registration Installment Payment on Zennal has been approved, please login to finish your application<br>Thanks";
	$reject_application = update_by_one_param('vehicle_reg_installment','approval_status', 2, 'unique_id',$unique_id);
	//$reject_application_decode = json_decode($reject_application, true);
	if($reject_application){
		echo "success";
		email_function($user_email, $subject, $content);
	}
	else{
		echo $reject_application_decode['msg'];
	}
?>