<?php
	require_once('../../config/functions.php');
	$unique_id = $_POST['unique_id'];
	$data = ['status'];
	$show_one_time_discount = update_data('one_time_discount', $data, 'unique_id',$unique_id);
	$show_one_time_discount_dec = json_decode($show_one_time_discount, true);
	if($show_one_time_discount_dec['status'] == "1"){
		echo "success";
	}
	else{
		echo $show_one_time_discount_dec['msg'];
	}
?>