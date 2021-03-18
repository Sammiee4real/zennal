<?php
	require_once('../../config/database_functions.php');
	$product_name = $_POST['product_name'];
	$vendor_id = $_POST['vendor_id'];
	$description = $_POST['description'];
	$price = $_POST['price'];
	$image = $_POST['image'];
	$created_by = $_SESSION['admin_id'];
	$add_product = add_product($vendor_id, $product_name, $description, $price, $image, $created_by);
	$add_product_decode = json_decode($add_product, true);
	if($add_product_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $add_product_decode['msg'];
	}
?>