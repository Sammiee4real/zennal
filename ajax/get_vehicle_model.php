<?php
	session_start();
	include('../config/functions.php');
	$vehicleBrandId = $_GET['vehicleBrandId'];
    $vehicle_model = get_rows_from_table_with_one_params('vehicle_models', 'brand_id', $vehicleBrandId);
	// $decode = json_decode($insurance_quote, true);
	// if($decode['status'] == "1"){
	// 	echo $insurance_quote;
	// }else{
	// 	echo $decode[''];
	// }
	echo json_encode($vehicle_model);
?>