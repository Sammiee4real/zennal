<?php
	session_start();
	include('../config/functions.php');
	header('Content-Type: application/json');
	$user_id = $_SESSION['user']['unique_id'];
	$vehicle_details_array = $_POST;
	$submit_vehicle_reg = add_new_vehicle($user_id, $vehicle_details_array);
	$submit_vehicle_reg_decode = json_decode($submit_vehicle_reg, true);
	$response_array = [];
	if($submit_vehicle_reg_decode['status'] == 1){
		$response_array=[
			"status" => "success",
			"data" => $submit_vehicle_reg_decode['data']
		];
	}else{
		$response_array=[
			"status" => $submit_vehicle_reg_decode['msg'],
			"data" => ''
		];
	}
	echo json_encode($response_array);
?>