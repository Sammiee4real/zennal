<?php
session_start();
	include('../config/functions.php');
	//header('content-type: text/json');
	//$response = array();
	$user_id =$_SESSION['user']['unique_id'];
	$loan_amount = isset($_POST['loan_amount']) ? $_POST['loan_amount'] : '';
	$loan_purpose = ($_POST['purpose_of_loan'] == 'others') ? $_POST['other_purpose_of_loan'] : $_POST['purpose_of_loan'];
	$bank_statement = $_POST['bank_statement'];
	$submit_employment_details = submit_loan_purpose($user_id, $loan_amount, $loan_purpose, $bank_statement);
	$decode = json_decode($submit_employment_details, true);
	if($decode['status'] == "1"){
		echo "success";
		unset($_SESSION['loan_amount']);
		unset($_SESSION['purpose_of_loan']);
	}else{
		echo $decode['msg'];
		// $response['msg'] = 'success';
  //       $response['unique_id'] = $decode['data'];
		
	}
	//echo json_encode($response);
	
?>