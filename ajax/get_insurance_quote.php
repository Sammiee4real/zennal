<?php
	session_start();
	include('../config/functions.php');
	$insurer = $_POST['insurer'];
	$package_plan = $_POST['package_plan'];
	$payment_method = $_POST['payment_method'];
	$insurance_quote = get_insurance_quote($insurer, $package_plan, $payment_method);
	// $decode = json_decode($insurance_quote, true);
	// if(isset($decode['status']) && $decode['status'] == "0"){
	// 	echo $insurance_quote;
	// }else{
	// 	echo $decode[''];
	// }
	echo $insurance_quote;
?>