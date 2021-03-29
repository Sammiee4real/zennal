<?php
	session_start();
	include('../config/functions.php');
	$packageId = $_GET['insurerPlanId'];
	$insurance_quote = get_insurance_quote($packageId);
	// $decode = json_decode($insurance_quote, true);
	// if($decode['status'] == "1"){
	// 	echo $insurance_quote;
	// }else{
	// 	echo $decode[''];
	// }
	echo $insurance_quote;
?>