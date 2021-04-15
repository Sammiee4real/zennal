<?php
	session_start();
	include('../config/functions.php');
	header('Content-Type: application/json');
	$user_id = $_SESSION['user']['unique_id'];
	$vehicle_details_array = $_POST;
	$change_vehicle_ownership = change_vehicle_ownership($user_id, $vehicle_details_array);
	$change_vehicle_ownership_decode = json_decode($change_vehicle_ownership, true);
	$response_array = [];
	if($change_vehicle_ownership_decode['status'] == 1){
		$response_array=[
			"status" => "success",
			"data" => $change_vehicle_ownership_decode['data']
		];
	}else{
		$response_array=[
			"status" => $change_vehicle_ownership_decode['msg'],
			"data" => ''
		];
	}
	echo json_encode($response_array);
?>