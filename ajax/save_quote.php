<?php
	require_once('../config/functions.php');

	$vehicle_value = $_POST['vehicle_value'];
	$prefered_insurer = $_POST['prefered_insurer'];
	$select_plan = $_POST['select_plan'];
	$premium_amount = $_POST['premium_amount'];

	$plan = get_one_row_from_one_table('insurance_plans', 'unique_id', $select_plan);

	$plan_name = $plan['plan_name'];
	$plan_percentage = $plan['plan_percentage'];

	$save_quote = save_quote($vehicle_value, $prefered_insurer, $select_plan, $plan_name, $plan_percentage, $premium_amount);

	$save_quote_decode = json_decode($save_quote, true);
	if($save_quote_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo "error";
	}

    // echo json_encode($_POST);
?>