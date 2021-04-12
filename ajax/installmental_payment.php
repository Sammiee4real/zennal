<?php
	session_start();
	header('Content-Type: application/json');
	require_once('../config/functions.php');
	$user_id = $_SESSION['user']['unique_id'];
	$unique_id = $_POST['unique_id'];
	$installment_id = $_POST['installment_id'];
	$response_array = [];
	$insert_payment = installmental_payment($unique_id, $installment_id);
	$insert_payment_decode = json_decode($insert_payment, true);
	if($insert_payment_decode['status'] == 1){
		$response_array = [
			"status" => 200,
			"data" => $insert_payment_decode['data']
		];
	}else{
		$response_array = [
			"status" => $insert_payment_decode['msg'],
		];
	}
	echo json_encode($response_array);
?>