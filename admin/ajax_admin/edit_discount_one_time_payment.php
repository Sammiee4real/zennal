<?php
	require_once('../../config/functions.php');
	$unique_id = $_POST['unique_id'];
	$data = ['discount_rate'];
	//print_r($data);
	$edit_one_time_discount = update_data('one_time_discount', $data, 'unique_id',$unique_id);
	$edit_one_time_discount_decode = json_decode($edit_one_time_discount, true);
	if($edit_one_time_discount_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $edit_one_time_discount_decode['msg'];
	}
?>