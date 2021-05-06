<?php
	require_once('../../config/functions.php');
	$unique_id = $_POST['unique_id'];
	$data = ['cost'];
	$edit_service = update_data('services', $data, 'unique_id',$unique_id);
	$edit_service_decode = json_decode($edit_service, true);
	if($edit_service_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $edit_service_decode['msg'];
	}
?>