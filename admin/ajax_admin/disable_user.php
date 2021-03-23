<?php
	require_once('../../config/functions.php');
	$user_id = $_POST['user_id'];
	$disable_user = update_by_one_param('users','status', 0 , 'unique_id', $user_id);
	if($disable_user){
		echo "success";
	}
	else{
		echo "Error in disabling user, please try again";
	}
?>