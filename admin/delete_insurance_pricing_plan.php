<?php
	require_once('../../config/functions.php');
	$planid = $_POST['planId'];
	$delete_plan = delete_a_row('insurance_pricing_plans','unique_id',$planid);
	$delete_plan_decode = json_decode($delete_plan, true);
	if($delete_plan_decode['status'] == 1){
		echo "success";
	}
	else{
		echo $delete_package_decode['msg'];
	}
?>