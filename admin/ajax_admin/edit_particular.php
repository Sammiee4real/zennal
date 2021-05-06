<?php
	require_once('../../config/functions.php');
	$unique_id = $_POST['unique_id'];
	$data = ['license_amount', 'road_worthiness_amount', 'third_party_amount', 'hackney_permit_amount'];
	$edit_particular = update_data('vehicle_particulars', $data, 'unique_id',$unique_id);
	$edit_particular_decode = json_decode($edit_particular, true);
	if($edit_particular_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $edit_particular_decode['msg'];
	}
?>