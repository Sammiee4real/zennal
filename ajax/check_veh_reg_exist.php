<?php
	require_once('../config/functions.php');
	$reg_id = $_POST['reg_id'];
	$user_id = $_SESSION['user']['unique_id'];
	$coupon_applied = $_POST['coupon_applied'];
	$coupon_code = isset($_POST['coupon_code']) ? $_POST['coupon_code'] : '';
	$remove_from_wallet = $_POST['remove_from_wallet'];
	$delivery_type = $_POST['delivery_type'];
	$service_type = $_POST['service_type'];
	$total = 0;
	$total_after_remove_wallet = 0;
	$get_user_wallet_balance = get_one_row_from_one_table('wallet', 'user_id', $user_id);
 	$wallet_balance = ($get_user_wallet_balance != null) ? $get_user_wallet_balance['balance'] : 0;
 	$get_delivery_fee = get_one_row_from_one_table('delivery_fee', 'delivery_for', 'vehicle_registration');
  	$delivery_fee = $get_delivery_fee['fee'];
  	$get_change_of_ownership_fee = get_one_row_from_one_table('services', 'service', 'Change of ownership');
  	$change_of_ownership_fee = $get_change_of_ownership_fee['cost'];
	switch ($service_type) {
		case 'vehicle_permit':
			$get_payment_details = calculate_vehicle_permit($reg_id);
    		$get_payment_details_decode = json_decode($get_payment_details, true);
    		if($delivery_type == 'physical'){
				$total = $get_payment_details_decode['total'];
				$total_after_remove_wallet = $get_payment_details_decode['total'];
			}else{
				$total = $get_payment_details_decode['email_delivery_total'];
				$total_after_remove_wallet = $get_payment_details_decode['email_delivery_total'];
			}
			break;
		case 'particulars':
			$get_payment_details = calculate_renew_vehicle_particulars($reg_id);
    		$get_payment_details_decode = json_decode($get_payment_details, true);
    		if($delivery_type == 'physical'){
				$total = $get_payment_details_decode['total'];
				$total_after_remove_wallet = $get_payment_details_decode['total'];
			}else{
				$total = $get_payment_details_decode['email_delivery_total'];
				$total_after_remove_wallet = $get_payment_details_decode['email_delivery_total'];
			}
			break;
		case 'vehicle_reg':
			$get_payment_details = calculate_vehicle_registration($reg_id);
  			$get_payment_details_decode = json_decode($get_payment_details, true);
  			$vehicle_registration_charge = $get_payment_details_decode['service_charge'] + $get_payment_details_decode['number_plate_charge'];
  			$insurance_charge = $get_payment_details_decode['insurance_charge'];
  			if($delivery_type == 'physical'){
				$total = $vehicle_registration_charge + $insurance_charge + $delivery_fee;
				$total_after_remove_wallet = $vehicle_registration_charge + $insurance_charge + $delivery_fee;
			}else{
				$total = $vehicle_registration_charge + $insurance_charge;
				$total_after_remove_wallet = $vehicle_registration_charge + $insurance_charge;
			}
			break;
		case 'change_ownership':
			$get_payment_details = calculate_change_vehicle_ownership($reg_id);
  			$get_payment_details_decode = json_decode($get_payment_details, true);
  			$vehicle_registration_fee = $get_payment_details_decode['change_of_ownership_fee'];
  			if($delivery_type == 'physical'){
				$total = $change_of_ownership_fee + $vehicle_registration_fee + $delivery_fee;
				$total_after_remove_wallet = $change_of_ownership_fee + $vehicle_registration_fee + $delivery_fee;
			}else{
				$total = $change_of_ownership_fee + $vehicle_registration_fee ;
				$total_after_remove_wallet = $change_of_ownership_fee + $vehicle_registration_fee ;
			}
			break;
		default:
			# code...
			break;
	}


	if ($coupon_applied == 1) {
		$get_code = get_one_row_from_one_table('coupon_code', 'coupon_code', $coupon_code);
		if($get_code != null){
			$total-=$get_code['discount'];
			$total_after_remove_wallet-=$get_code['discount'];
		}
	}
	if($remove_from_wallet == 1){
		if($wallet_balance > $total){
			$total_after_remove_wallet = 0;
		}
		else{
			$total_after_remove_wallet = $total - $wallet_balance;
		}
	}
	$check = check_record_by_one_param('vehicle_reg_payment', 'reg_id', $reg_id);
	if($check){
		echo json_encode([
			'total' => $total, 
			'total_after_remove_wallet' => $total_after_remove_wallet, 
			'check_status' => "true"
		]);
	}
	else{
		echo json_encode([
			'total' => $total, 
			'total_after_remove_wallet' => $total_after_remove_wallet, 
			'check_status' => "false"
		]);
	}
?>