<?php
	require_once('../../config/functions.php');
	$packageid = $_POST['packageId'];
	$delete_package = delete_a_row('insurance_packages','unique_id',$packageid);
	$delete_package_decode = json_decode($delete_package, true);
	if($delete_package_decode['status'] == 1){
		echo "success";
	}
	else{
		echo $delete_package_decode['msg'];
	}
?>