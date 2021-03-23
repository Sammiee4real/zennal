<?php
	require_once('../../config/functions.php');
	$plan_name = $_POST['pricing_type'];
	$plan_price = $_POST['plan_price'];
	$data = ["pricing_type", "plan_price", "plan_description"];
	$unique_id = $_POST['plan_id'];
	$created_by = $_SESSION['admin_id'];
    $edit_plan = update_existing_row_with_mult_params('insurance_pricing_plans', $unique_id, $data);
	$edit_plan_decode = json_decode($edit_plan, true);
	if($edit_plan_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $edit_plan_decode['msg'];
	}
?>