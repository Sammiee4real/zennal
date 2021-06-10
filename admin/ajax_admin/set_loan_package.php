<?php
	require_once('../../config/functions.php');
	$no_of_month = $_POST['no_of_month'];
	$loan_category = $_POST['loan_category'];
	$interest_per_month = $_POST['interest_per_month'];
	$equity_contribution = '';
	$created_by = $_SESSION['admin_id'];
	$create_package = set_loan_packages($no_of_month, $loan_category, $interest_per_month, $equity_contribution, $created_by);
	$create_package_decode = json_decode($create_package, true);
	if($create_package_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $create_package_decode['msg'];
	}
?>