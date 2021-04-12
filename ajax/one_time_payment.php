<?php
	session_start();
	header('Content-Type: application/json');
	require_once('../config/functions.php');
	$user_id = $_SESSION['user']['unique_id'];
	$reg_id = $_POST['reg_id'];
	$city = $_POST['city'];
	$delivery_area = $_POST['delivery_area'];
	$delivery_address = $_POST['delivery_address'];
	$total = $_POST['total'];
	$installment_id = isset($_POST['installment_id']) ? $_POST['installment_id'] : '';
	$response_array = [];
	$insert_payment = insert_payment($user_id, $reg_id, $city, $delivery_area, $delivery_address, $total, $installment_id);
	$insert_payment_decode = json_decode($insert_payment, true);
	if($insert_payment_decode['status'] == 1){
		$response_array = [
			"status" => "success",
			"data" => $insert_payment_decode['data']
		];
	}else{
		$response_array = [
			"status" => $insert_payment_decode['msg'],
		];
	}
	echo json_encode($response_array);
?>