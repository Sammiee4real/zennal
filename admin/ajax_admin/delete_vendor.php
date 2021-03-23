<?php
	require_once('../../config/functions.php');
	$unique_id = $_POST['vendor_id'];
	$created_by = $_SESSION['admin_id'];
	$delete_vendor = delete_a_row('vendors','unique_id', $unique_id);
	$delete_vendor_decode = json_decode($delete_vendor, true);
	if($delete_vendor_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $delete_vendor_decode['msg'];
	}
?>