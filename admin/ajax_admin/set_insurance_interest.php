<?php
	require_once('../../config/functions.php');
	// $data = ['package_name'];
	//$unique_id = $_POST['product_id'];
	$interest_type = $_POST['interest_type'];
	$interest_rate = $_POST['interest_rate'];

	$set_insurance_interest = insert_insurance_interest($interest_type, $interest_rate);

	$set_insurance_interest_decode = json_decode($set_insurance_interest, true);
	if($set_insurance_interest_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $set_insurance_interest_decode['msg'];
	}
?>