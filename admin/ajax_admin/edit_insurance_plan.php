<?php
	require_once('../../config/functions.php');
	$plan_name = $_POST['plan_name'];
	$data = ["plan_name", "plan_percentage"];
	$unique_id = $_POST['plan_id'];
	$created_by = $_SESSION['admin_id'];
	// $edit_plan = update_db('insurance_plans', $unique_id,'plan_name', $plan_name, );

	$edit_plan = update_data('insurance_plans', $data, 'unique_id', $unique_id);
	$edit_plan_decode = json_decode($edit_plan, true);
	if($edit_plan_decode['status'] == "1"){
		
		echo "success";
		
	}else{
		echo $edit_plan_decode['msg'];
	}
?>