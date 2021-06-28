<?php
	require_once('../config/functions.php');

	$total = 0;
	if(isset($_POST['vehicle_permit'])){
		if(!empty($_POST['vehicle_permit'])){
			foreach($_POST['vehicle_permit'] as $vehicle_permit){
				$get_service_charge = get_one_row_from_one_table('services', 'unique_id', $vehicle_permit);
				$service_charge = $get_service_charge['cost'];
				$total += $service_charge;
			}
		}
	}
	

	echo $total;

?>