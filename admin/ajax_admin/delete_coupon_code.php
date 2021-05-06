<?php
	require_once('../../config/functions.php');
	$unique_id = $_POST['unique_id'];
	$delete_coupon_code = delete_a_row('coupon_code','unique_id',$unique_id);
	$delete_coupon_code_decode = json_decode($delete_coupon_code, true);
	if($delete_coupon_code_decode['status'] == 1){
		echo "success";
	}
	else{
		echo $delete_coupon_code_decode['msg'];
	}
?>