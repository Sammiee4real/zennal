<?php
	require_once('../../config/database_functions.php');
	$user_id = $_POST['user_id'];
	$disable_user = update_by_one_param('users','status', 1 , 'unique_id', $user_id);
	if($disable_user){
		echo "success";
	}
	else{
		echo "Error in disabling user, please try again";
	}
?>