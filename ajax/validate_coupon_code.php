<?php
	session_start();
	include('../config/functions.php');
	$coupon_code = $_GET['couponCode'];
	$particulars_id = $_GET['particularsId'];

    echo validate_coupon_code($coupon_code,$particulars_id);
	// $decode = json_decode($insurance_quote, true);
	// if($decode['status'] == "1"){
	// 	echo $insurance_quote;
	// }else{
	// 	echo $decode[''];
	// }
	// echo json_encode($vehicle_model);
?>