<?php
	require_once('../../config/functions.php');
	$unique_id = $_POST['unique_id'];
	$data  = array();
	$data = ['status'];
	$show_employment_status = update_data('employment_status', $data, 'unique_id',$unique_id);
	$show_employment_status_dec = json_decode($show_employment_status, true);
	if($show_employment_status_dec['status'] == "1"){
		echo "success";
	}
	else{
		echo $show_employment_status_dec['msg'];
	}
?>