<?php
	require_once('../config/functions.php');
	$check = check_record_by_one_param('vehicle_reg_payment', 'reg_id', $reg_id);
	if($check){
		echo "true";
	}
	else{
		echo "false";
	}
?>