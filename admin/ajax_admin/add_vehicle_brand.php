<?php
	require_once('../../config/functions.php');
	$brand_name = $_POST['brand_name'];
	$add_vehicle_brand = add_vehicle_brand($brand_name);
	$add_vehicle_brand_decode = json_decode($add_vehicle_brand, true);
	if($add_vehicle_brand_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $add_vehicle_brand_decode['msg'];
	}
?>