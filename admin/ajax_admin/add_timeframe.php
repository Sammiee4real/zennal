<?php
	require_once('../../config/functions.php');
	$time_frame = $_POST['time_frame'];
	$added_by = $_SESSION['admin_id'];
	$add_time_frame = add_time_frame($added_by, $time_frame);
	$add_time_frame_decode = json_decode($add_time_frame, true);
	if($add_time_frame_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $add_time_frame_decode['msg'];
	}
?>