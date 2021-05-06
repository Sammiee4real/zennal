<?php
	require_once('../../config/functions.php');
	$unique_id = $_POST['unique_id'];
	$delete_service = delete_a_row('services','unique_id',$unique_id);
	$delete_service_decode = json_decode($delete_service, true);
	if($delete_service_decode['status'] == 1){
		echo "success";
	}
	else{
		echo $delete_service_decode['msg'];
	}
?>