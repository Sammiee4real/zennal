<?php
	require_once('../../config/functions.php');
	$unique_id = $_POST['unique_id'];
	$data = ['status'];
	$hide_one_time_discount = update_data('one_time_discount', $data, 'unique_id',$unique_id);
	$hide_one_time_discount_decode = json_decode($hide_one_time_discount, true);
	if($hide_one_time_discount_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $hide_one_time_discount_decode['msg'];
	}
?>