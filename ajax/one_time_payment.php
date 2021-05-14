<?php
	session_start();
	// header('Content-Type: application/json');
	require_once('../config/functions.php');
	$user_id = $_SESSION['user']['unique_id'];
	$email = $_SESSION['user']['email'];
	$reg_id = $_POST['reg_id'];
	$city = isset($_POST['city']) ? $_POST['city']  : (isset($_POST['delivery_city']) ? $_POST['delivery_city'] : '');
	$delivery_area = isset($_POST['delivery_area']) ? $_POST['delivery_area'] : '';
	$delivery_address = isset($_POST['delivery_address']) ? $_POST['delivery_address'] : '';
	$total = $_POST['total'];
	$email = isset($_POST['email']) ? $_POST['email'] : '';
	$installment_id = isset($_POST['installment_id']) ? $_POST['installment_id'] : '';
	$service_type = $_POST['service_type'];
	$remove_from_wallet = isset($_POST['remove_from_wallet']) ? $_POST['remove_from_wallet'] : '';;
	$response_array = [];
	$table = "vehicle_reg_payment";
	$content = 'Vehicle Registration, You have successfully ordered for Vehicle Registration, your documents will be delivered to you soon <br> Thanks.';
	$insert_payment = insert_payment($email, $table, $user_id, $reg_id, $city, $delivery_area, $delivery_address, $total, $installment_id, $service_type, $remove_from_wallet);
	$insert_payment_decode = json_decode($insert_payment, true);
	if($insert_payment_decode['status'] == 1){
		email_function($email, $content);
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