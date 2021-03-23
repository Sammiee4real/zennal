<?php
	require_once('../../config/functions.php');
	$data = ['pricing_type', 'plan_description', 'plan_price'];
	//$unique_id = $_POST['product_id'];
	$pricing_type = $_POST['pricing_type'];
	$create_pricing_plan = insert_into_db('insurance_pricing_plans',$data, 'pricing_type','');
	$create_pricing_plan_decode = json_decode($create_pricing_plan, true);
	if($create_pricing_plan_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $create_pricing_plan_decode['msg'];
	}
?>