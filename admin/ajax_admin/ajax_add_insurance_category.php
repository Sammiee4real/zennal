<?php
	require_once('../../config/functions.php');
	$cat_name = $_POST['category_name'];
	$cat_rate = $_POST['category_rate'];
	
	$add_insurance_category = insert_insurance_category($cat_name, $cat_rate);
	$add_insurance_category_decode = json_decode($add_insurance_category, true);
	if($add_insurance_category_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $add_insurance_category_decode['msg'];
	}
?>