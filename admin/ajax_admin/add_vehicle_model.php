<?php
	require_once('../../config/functions.php');
	$brand_id = $_POST['brand_id'];
	$model_name = $_POST['model_name'];
	$add_vehicle_model = add_vehicle_model($brand_id, $model_name);
	$add_vehicle_model_decode = json_decode($add_vehicle_model, true);
	if($add_vehicle_model_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $add_vehicle_model_decode['msg'];
	}
?>