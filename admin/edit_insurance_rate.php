<?php
	require_once('../../config/functions.php');
	$rate = $_POST['percent_rate'];
    $unique_id = $_POST['rate_id'];
    $data = ["percent_rate"];
	$created_by = $_SESSION['admin_id'];
	$edit_package = update_data('insurance_interest_rate', $data, 'percent_rate', $rate, );
	$edit_package_decode = json_decode($edit_package, true);
	if($edit_package_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $edit_package_decode['msg'];
	}
?>