<?php
	session_start();
	require_once('../config/functions.php');
	$amount = $_POST['amount'];
	$user_id = $_SESSION['user']['unique_id'];
	$submit_withdrawal_request = submit_withdrawal_request($user_id, $amount);
	$submit_withdrawal_request_decode = json_decode($submit_withdrawal_request, true);
	if($submit_withdrawal_request_decode['status'] == 1){
		echo "success";
	}else{
		echo $submit_withdrawal_request_decode['msg'];
	}
?>