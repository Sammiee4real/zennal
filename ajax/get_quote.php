<?php
	require_once('../config/functions.php');
	$vehicle_type = $_POST['vehicle_type'];
	$insurance_type = isset($_POST['insurance_type']) ? $_POST['insurance_type'] : '';
	$road_worthiness = isset($_POST['road_worthiness']) ? $_POST['road_worthiness'] : '';
	$hackney_permit = isset($_POST['hackney_permit']) ? $_POST['hackney_permit'] : '';
	$license = isset($_POST['license']) ? $_POST['license'] : '';
	$get_vehicle_type = get_one_row_from_one_table('vehicle_particulars', 'vehicle_id', $vehicle_type);
	$total = 0;
	if($insurance_type == 'third_party'){
		$total += $get_vehicle_type['third_party_amount'];
	}
	else if($insurance_type == 'no_insurance' || $insurance_type == '' || $insurance_type == 'comprehensive'){
		$total += 0;
	}

	if($road_worthiness != ''){
		$total += $get_vehicle_type['road_worthiness_amount'];
	}
	if($hackney_permit != ''){
		$total += $get_vehicle_type['hackney_permit_amount'];
	}
	if($license != ''){
		$total += $get_vehicle_type['license_amount'];
	}

	echo $total;

?>