<?php
	require_once('../../config/functions.php');
	$referral_for = $_POST['referral_for'];
	$referral_bonus = $_POST['referral_bonus'];
	$admin_id = $_SESSION['admin_id'];
	$add_referral = add_referral_bonus($referral_for, $referral_bonus, $admin_id);
	$add_referral_decode = json_decode($add_referral, true);
	if($add_referral_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $add_referral_decode['msg'];
	}
?>