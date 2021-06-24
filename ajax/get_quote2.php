<?php
	require_once('../config/functions.php');
	$vehicle_type = isset($_POST['vehicle_type']) ? $_POST['vehicle_type'] : '';
	$insurance_type = isset($_POST['insurance_type']) ? $_POST['insurance_type'] : '';
	$insurer = isset($_POST['insurer']) ? $_POST['insurer'] : '';
	$plan_type = isset($_POST['plan_type']) ? $_POST['plan_type'] : '';
	$vehicle_value = isset($_POST['vehicle_value']) ? $_POST['vehicle_value'] : '';
	$plate_number_type = isset($_POST['plate_number_type']) ? $_POST['plate_number_type'] : '';
	$get_vehicle_type = get_one_row_from_one_table('vehicle_particulars', 'vehicle_id', $vehicle_type);
	$get_insurance_rate = get_one_row_from_one_table('insurance_plans', 'unique_id', $plan_type);
	$total = 0;
	$insurance_charge = 0;
	$number_plate_charge = 0;

	if(empty($vehicle_value)){
		$vehicle_value = 0;
	}
	
	if($insurance_type != ''){
		if($insurance_type == 'third_party_insurance'){
			if(!empty($get_vehicle_type)){
				$total += $get_vehicle_type['third_party_amount'];
			}
		}
		else if($insurance_type == 'no_insurance' || $insurance_type == ''){
			$total += 0;
		}
		else if($insurance_type == 'comprehensive_insurance' || $insurance_type == 'comprehensive'){
			if($plan_type != "" || $vehicle_value != ""){
				if(!empty($get_insurance_rate)){
					$insurance_charge = ($get_insurance_rate['plan_percentage'] / 100) * $vehicle_value;
					$total += $insurance_charge;
				}
				
			}
		}
	}

	if($plate_number_type != ''){
		if($plate_number_type == "private"){
		    $get_number_plate = get_one_row_from_one_table_by_two_params('number_plate', 'type','private','vehicle_id',$vehicle_type, 'date_created');
		    if($insurance_type == 'third_party_insurance'){
				if(!empty($get_number_plate)){
					$number_plate_charge = $get_number_plate['third_party_amount'];
					$total += $number_plate_charge;
				}
		    }
		    else if($insurance_type == 'no_insurance' || $insurance_type == 'comprehensive' || $insurance_type == 'comprehensive_insurance'){
				if(!empty($get_number_plate)){
					$number_plate_charge = $get_number_plate['no_third_party_amount'];
					$total += $number_plate_charge;
				}
		    }
		}
		else if($plate_number_type == "commercial"){
		    $get_number_plate = get_one_row_from_one_table_by_two_params('number_plate', 'type','commercial','vehicle_id',$vehicle_type, 'date_created');
		    if($insurance_type == 'third_party_insurance'){
				if(!empty($get_number_plate)){
					$number_plate_charge = $get_number_plate['third_party_amount'];
					$total += $number_plate_charge;
				}
		    }
		    else if($insurance_type == 'no_insurance' || $insurance_type == 'comprehensive' || $insurance_type == 'comprehensive_insurance'){

				if(!empty($get_number_plate)){
					$number_plate_charge = $get_number_plate['no_third_party_amount'];
					$total += $number_plate_charge;
				}

		    }
		}
		else if($plate_number_type == "personalized_number"){
		    $get_number_plate = get_one_row_from_one_table_by_two_params('number_plate', 'type','new','vehicle_id',$vehicle_type, 'date_created');
		    if($get_number_plate != null){
		      $number_plate_charge = $get_number_plate['personalized_number'];
		      $total += $number_plate_charge;
		    } 
		    else{
		      $number_plate_charge = 0;
		      $total += $number_plate_charge;
		    }
		}
	}



	echo $total;

?>