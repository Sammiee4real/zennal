<?php
	require_once('../../config/functions.php');
	$name = $_POST['name'];
	$data = ["name"];
	$unique_id = $_POST['insurer_id'];
	$created_by = $_SESSION['admin_id'];

	$edit_insurer = update_data('insurers', $data, 'unique_id', $unique_id);
	$edit_insurer_decode = json_decode($edit_insurer, true);
	if($edit_insurer_decode['status'] == "1"){
		
		echo "success";
		
	}else{
		echo $edit_insurer_decode['msg'];
	}
?>