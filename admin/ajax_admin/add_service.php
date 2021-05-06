<?php
	require_once('../../config/functions.php');
	$service = $_POST['service'];
	$data = ['service', 'cost'];
	$add_service = insert_into_db('services',$data, 'service',$service);
	$add_service_decode = json_decode($add_service, true);
	if($add_service_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $add_service_decode['msg'];
	}
?>