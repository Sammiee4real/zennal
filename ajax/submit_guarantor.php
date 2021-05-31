<?php
	include('../config/functions.php');
	$user_id =$_SESSION['user']['unique_id'];
	$data = $_POST['data'];
	$submit_guarantor = submit_guarantor($user_id, $data);
	$decode = json_decode($submit_guarantor, true);
	if($decode['status'] !== "1"){
		echo $decode['msg'];
	}else{
		echo "success";
	}
	
?>