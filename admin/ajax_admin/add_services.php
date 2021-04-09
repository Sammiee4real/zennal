<?php
	require_once('../../config/functions.php');
	$brand_id = $_POST['brand_id'];
	$model_name = $_POST['model_name'];
	// $brand_name = $_POST['brand_name'];
	echo add_vehicle_model($brand_id, $model_name);
	//echo add_vehicle_brand($brand_name)
?>