<?php
	require_once('../../config/functions.php');
	$unique_id = $_POST['unique_id'];
	$data  = array();
	$data = ['status'];
	$show_insurance_installment_settings = update_data('insurance_installment_setting', $data, 'unique_id',$unique_id);
	$show_insurance_installment_settings_dec = json_decode($show_insurance_installment_settings, true);
	if($show_insurance_installment_settings_dec['status'] == "1"){
		echo "success";
	}
	else{
		echo $show_insurance_installment_settings_dec['msg'];
	}
?>