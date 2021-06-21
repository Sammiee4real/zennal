<?php
	require_once('../../config/functions.php');
	$data = ['status_name'];
	//$unique_id = $_POST['product_id'];
	$status_name = $_POST['status_name'];
	$create_employment_status = insert_into_db('employment_status',$data, 'status_name',$status_name);
	$create_employment_status_decode = json_decode($create_employment_status, true);
	if($create_employment_status_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $create_employment_status_decode['msg'];
	}
?>