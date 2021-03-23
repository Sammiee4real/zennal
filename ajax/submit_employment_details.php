<?php
	session_start();
	include('../config/functions.php');
	$user_id = $_SESSION['user']['unique_id'];
	$employment_array = $_POST;
	// print_r($_POST);
	$submit_employment_details = save_employment_details($user_id, $employment_array);
	$decode = json_decode($submit_employment_details, true);
	if($decode['status'] !== "1"){
		echo $decode['msg'];
	}else{
		echo "success";
	}
	
?>