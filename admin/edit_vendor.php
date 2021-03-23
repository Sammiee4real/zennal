<?php
	require_once('../../config/functions.php');
	$data = ['name', 'description', 'website_url'];
	$unique_id = $_POST['vendor_id'];
	$edit_vendor = update_db($unique_id, $data);
	$edit_vendor_decode = json_decode($edit_vendor, true);
	if($edit_vendor_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $edit_vendor_decode['msg'];
	}
?>