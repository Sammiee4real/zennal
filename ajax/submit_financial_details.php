<?php
	session_start();
	require_once('../config/functions.php');
	$user_id = $_SESSION['user']['unique_id'];
	$financial_details_array = $_POST;
	$save_financial_record = save_financial_record($user_id, $financial_details_array);
	$save_financial_record_decode = json_decode($save_financial_record, true);
	if($save_financial_record_decode['status'] == 1){
		echo "success";
	}else{
		echo $save_financial_record_decode['msg'];
	}
?>