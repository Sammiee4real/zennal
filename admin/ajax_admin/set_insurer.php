<?php
	require_once('../../config/functions.php');
	$data = ['name'];
	//$unique_id = $_POST['product_id'];
	$name = $_POST['name'];
	$create_insurer = insert_into_db('insurers',$data, 'name',$name, false);
	$create_insurer_decode = json_decode($create_insurer, true);
	if($create_insurer_decode['status'] == "1"){
		echo "success";
	}else{
		echo $create_insurer_decode['msg'];
	}
?>