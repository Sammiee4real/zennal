<?php
	require_once('../../config/functions.php');
	$delivery_fee = $_POST['delivery_fee'];
	if($delivery_fee == ''){
		echo "Empty field(s) found";
	}else{
		$update_fee = update_by_one_param('delivery_fee','fee', $delivery_fee, 'delivery_for', 'vehicle_registration');;
		if($update_fee){
			echo "success";
		}
		else{
			echo $update_fee_decode['msg'];
		}
	}
?>