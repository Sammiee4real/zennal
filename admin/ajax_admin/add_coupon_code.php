<?php
	require_once('../../config/functions.php');
	$coupon_code = $_POST['coupon_code'];
	$data = ['coupon_code', 'discount', 'insurance_type', 'expiry_date'];
	$add_coupon_code = insert_into_db('coupon_code', $data, 'coupon_code',$coupon_code);
	$add_coupon_code_decode = json_decode($add_coupon_code, true);
	if($add_coupon_code_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $add_coupon_code_decode['msg'];
	}
?>