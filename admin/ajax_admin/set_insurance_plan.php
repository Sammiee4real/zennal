<?php
	require_once('../../config/functions.php');
	$data = ['plan_name', 'plan_percentage'];
	//$unique_id = $_POST['product_id'];
	$plan_name = $_POST['plan_name'];
	$create_insurance_plan = insert_into_db('insurance_plans',$data, 'plan_name',$plan_name, false);
	$create_insurance_plan_decode = json_decode($create_insurance_plan, true);
	if($create_insurance_plan_decode['status'] == "1"){
		echo "success";
	}else{
		echo $create_insurance_plan_decode['msg'];
	}
?>