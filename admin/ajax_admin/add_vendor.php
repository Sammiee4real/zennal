<?php
	require_once('../../config/functions.php');
	$name = $_POST['name'];
	$description = $_POST['description'];
	$website_url = $_POST['website_url'];
	$created_by = $_SESSION['admin_id'];
	$add_vendor = add_vendor($name, $description, $website_url, $created_by);
	$add_vendor_decode = json_decode($add_vendor, true);
	if($add_vendor_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $add_vendor_decode['msg'];
	}
?>