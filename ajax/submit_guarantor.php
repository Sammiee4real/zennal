<?php
	include('../config/functions.php');
	$user_id =$_SESSION['user']['unique_id'];
	$guarantor_array = $_POST;
	$submit_guarantor = submit_guarantor($user_id, $guarantor_array);
	$decode = json_decode($submit_guarantor, true);
	if($decode['status'] !== "1"){
		echo $decode['msg'];
	}else{
		echo "success";
	}
	
?>