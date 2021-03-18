<?php
	require_once('../../config/database_functions.php');
	$data = ['product_name', 'description', 'price'];
	$unique_id = $_POST['product_id'];
	//$name = $_POST['name'];
	$edit_product = update_db('products', $unique_id,'unique_id', '', $data);
	$edit_product_decode = json_decode($edit_product, true);
	if($edit_product_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $edit_product_decode['msg'];
	}
?>