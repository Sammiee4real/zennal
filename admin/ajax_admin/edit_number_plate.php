<?php
	require_once('../../config/functions.php');
	$unique_id = $_POST['unique_id'];
	$data = ['no_third_party_amount', 'third_party_amount', 'personalized_number'];
	$edit_number_plate = update_data('number_plate', $data, 'unique_id',$unique_id);
	$edit_number_plate_decode = json_decode($edit_number_plate, true);
	if($edit_number_plate_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $edit_number_plate_decode['msg'];
	}
?>