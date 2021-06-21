<?php
	require_once('../../config/functions.php');
	$unique_id = $_POST['unique_id'];
	$data  = array();
	$data = ['status'];
	$hide_employment_status = update_data('employment_status', $data, 'unique_id',$unique_id);
	$hide_employment_status_dec = json_decode($hide_employment_status, true);
	if($hide_employment_status_dec['status'] == "1"){
		echo "success";
	}
	else{
		echo $hide_employment_status_dec['msg'];
	}
?>