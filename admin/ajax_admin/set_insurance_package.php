<?php
	require_once('../../config/functions.php');
	$data = ['package_name'];
	//$unique_id = $_POST['product_id'];
	$package_name = $_POST['package_name'];
	$create_insurance_package = insert_into_db('insurance_packages',$data, 'package_name',$package_name);
	$create_insurance_package_decode = json_decode($create_insurance_package, true);
	if($create_insurance_package_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $create_insurance_package_decode['msg'];
	}
?>