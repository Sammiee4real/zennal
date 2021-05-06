<?php
	require_once('../../config/functions.php');
	$unique_id = $_POST['unique_id'];
	$data = ['coupon_code', 'discount'];
	$edit_coupon_code = update_data('coupon_code', $data, 'unique_id',$unique_id);
	$edit_coupon_code_decode = json_decode($edit_coupon_code, true);
	if($edit_coupon_code_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $edit_coupon_code_decode['msg'];
	}
?>