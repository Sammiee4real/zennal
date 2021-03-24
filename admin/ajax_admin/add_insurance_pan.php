<?php
	require_once('../../config/functions.php');
	$insurer = $_POST['insurer'];
	$plan_name = $_POST['plan_name'];
	$plan_rate = $_POST['plan_rate'];
	
	$add_insurance_plan = insert_insurance_plan($insurer, $plan_name, $plan_rate);
	$add_insurance_plan_decode = json_decode($add_insurance_plan, true);
	if($add_insurance_plan_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $add_insurance_plan_decode['msg'];
	}
?>