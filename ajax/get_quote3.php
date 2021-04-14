<?php
	require_once('../config/functions.php');
	$vehicle_type = $_POST['vehicle_type'];
	$vehicle_license_expiry = isset($_POST['vehicle_license_expiry']) ? $_POST['vehicle_license_expiry'] : '';
	$registration_type = isset($_POST['registration_type']) ? $_POST['registration_type'] : '';
	$plate_number_type = isset($_POST['plate_number_type']) ? $_POST['plate_number_type'] : '';
	$get_vehicle_type = get_one_row_from_one_table('vehicle_particulars', 'vehicle_id', $vehicle_type);
	$total = 0;

	if($registration_type != ''){
		if($registration_type == "private_with_third"){
		    $get_number_plate = get_one_row_from_one_table_by_two_params('number_plate', 'type','private','vehicle_id',$vehicle_type, 'date_created');
		    $registration_charge = $get_number_plate['third_party_amount'];
		    $total += $registration_charge;
		}
		else if($registration_type == "private_without_third"){
		    $get_number_plate = get_one_row_from_one_table_by_two_params('number_plate', 'type','private','vehicle_id',$vehicle_type, 'date_created');
		    $registration_charge = $get_number_plate['no_third_party_amount'];
		    $total += $registration_charge;
		}
		else if($plate_number_type == "commercial_with_third"){
		    $get_number_plate = get_one_row_from_one_table_by_two_params('number_plate', 'type','commercial','vehicle_id',$vehicle_type, 'date_created');
		    $registration_charge = $get_number_plate['third_party_amount'];
		    $total += $registration_charge;
		}
		else if($plate_number_type == "commercial_without_third"){
		    $get_number_plate = get_one_row_from_one_table_by_two_params('number_plate', 'type','commercial','vehicle_id',$vehicle_type, 'date_created');
		    $registration_charge = $get_number_plate['no_third_party_amount'];
		    $total += $registration_charge;
		}
	}

	if($plate_number_type != ""){
		if($plate_number_type == "custom"){
			$get_number_plate = get_one_row_from_one_table_by_two_params('number_plate', 'type','new','vehicle_id',$vehicle_type, 'date_created');
			$number_plate_charge = $get_number_plate['personalized_number'];
	      	$total += $number_plate_charge;
		}
		else{
			$number_plate_charge = 0;
	      	$total += $number_plate_charge;
		}
	}

	echo $total;

?>