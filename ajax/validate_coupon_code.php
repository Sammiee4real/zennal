<?php
	session_start();
	include('../config/functions.php');

	$data = $_GET;

    echo get_coupon_discount($data);
	// $decode = json_decode($insurance_quote, true);
	// if($decode['status'] == "1"){
	// 	echo $insurance_quote;
	// }else{
	// 	echo $decode[''];
	// }
	// echo json_encode($vehicle_model);
?>