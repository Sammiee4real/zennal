<?php
session_start();
	include('../config/functions.php');
	//header('content-type: text/json');
	//$response = array();
	$user_id =$_SESSION['user']['unique_id'];
	$reg_id = $_POST['reg_id'];
	$bank_statement = $_POST['bank_statement'];
	$submit_vehicle_reg_installment = submit_vehicle_reg_installment($user_id, $reg_id, $bank_statement);
	$decode = json_decode($submit_vehicle_reg_installment, true);
	if($decode['status'] == "1"){
		echo "success";
	}else{
		echo $decode['msg'];
		// $response['msg'] = 'success';
  //       $response['unique_id'] = $decode['data'];
		
	}
	//echo json_encode($response);
	
?>