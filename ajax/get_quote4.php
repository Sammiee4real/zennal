<?php
	require_once('../config/functions.php');
	$vehicle_permit = isset($_POST['vehicle_permit']) ? $_POST['vehicle_permit'] : '';
	$get_service_charge = get_one_row_from_one_table('services', 'unique_id', $vehicle_permit);
	$total = 0;
	if($vehicle_permit != ''){
		$service_charge = $get_service_charge['cost'];
		$total += $service_charge;
	}

	echo $total;

?>