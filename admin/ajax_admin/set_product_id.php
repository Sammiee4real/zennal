<?php
	require_once('../../config/functions.php');
	// $data = ['package_name'];
	//$unique_id = $_POST['product_id'];
	$package_plan = $_POST['insurance_package'];
	$product_id = $_POST['product_id'];

	$set_product_id = update_by_one_param('insurance_plans','product_id',$product_id,'unique_id',$package_plan);

	// $set_insurance_interest_decode = json_decode($set_insurance_interest, true);
	if($set_product_id){
		echo "success";
	}
	else{
		echo "Product Id cannot be set";
	}
?>