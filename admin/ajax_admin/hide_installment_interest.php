<?php
	require_once('../../config/functions.php');
	$unique_id = $_POST['unique_id'];
	$data = ['status'];
	$edit_installment_interest = update_data('installment_payment_interest', $data, 'unique_id',$unique_id);
	$edit_installment_interest_decode = json_decode($edit_installment_interest, true);
	if($edit_installment_interest_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $edit_installment_interest_decode['msg'];
	}
?>