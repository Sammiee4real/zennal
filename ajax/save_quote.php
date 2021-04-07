<?php
	require_once('../config/functions.php');

	$vehicle_value = $_POST['vehicle_value'];
	$prefered_insurer = $_POST['prefered_insurer'];
	$select_plan = $_POST['select_plan'];

	$save_quote = save_quote($vehicle_value, $prefered_insurer, $select_plan);

	$save_quote_decode = json_decode($save_quote, true);
	if($save_quote_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo "error";
	}

    // echo json_encode($_POST);
?>