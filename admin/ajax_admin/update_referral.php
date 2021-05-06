<?php
	require_once('../../config/functions.php');
	$referral_for = $_POST['referral_for'];
	$data = ['referral_bonus'];
	$update_referral = update_data('referral_tbl', $data, 'referral_for',$referral_for);
	$update_referral_decode = json_decode($update_referral, true);
	if($update_referral_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $update_referral_decode['msg'];
	}
?>