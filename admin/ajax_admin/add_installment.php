<?php
	require_once('../../config/functions.php');
	$data = ['no_of_month', 'interest_rate', 'status'];
	$add_coupon_code = insert_into_db('installment_payment_interest', $data, 'no_of_month',$_POST['no_of_month']);
	$add_coupon_code_decode = json_decode($add_coupon_code, true);
	if($add_coupon_code_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $add_coupon_code_decode['msg'];
	}
?>