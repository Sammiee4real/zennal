<?php
	require_once('../../config/database_functions.php');
	$package_name = $_POST['package_name'];
	$data = ["package_name"];
	$unique_id = $_POST['package_id'];
	$created_by = $_SESSION['admin_id'];
	$edit_package = update_db('insurance_packages', $unique_id,'package_name', $package_name, $data);
	$edit_package_decode = json_decode($edit_package, true);
	if($edit_package_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $edit_package_decode['msg'];
	}
?>