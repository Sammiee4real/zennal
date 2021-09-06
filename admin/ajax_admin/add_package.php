<?php
	require_once('../../config/functions.php');
	$no_of_month = $_POST['no_of_month'];
	$loan_category = $_POST['loan_category'];
	$interest_per_month = $_POST['interest_per_month'];
	$equity_contribution = $_POST['equity_contribution'];
	$created_by = $_SESSION['admin_id'];
	$edit_package = add_loan_packages($no_of_month, $loan_category, $interest_per_month, $equity_contribution);
	$edit_package_decode = json_decode($edit_package, true);
	if($edit_package_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $edit_package_decode['msg'];
	}
?>