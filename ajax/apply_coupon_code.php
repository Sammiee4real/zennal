<?php
	require_once('../config/functions.php');
	header('Content-Type: application/json');
	
	$user_id = $_SESSION['user']['unique_id'];
	
	$table = $_POST['query'];
	$unique_id = $_POST['reg_id'];
	$coupon_code = $_POST['coupon_code'];

	// Get the insurance_type from table row
	$table_row = get_one_row_from_one_table($table, 'unique_id', $unique_id);

	if(empty($table_row)){
		exit(json_encode([
			"status" => 0,
			"message" => "There is no record of this activity. Try again"
		]));
	}

	$insurance_type = "third_party_insurance";
	if(isset($table_row['insurance_type'])){
		$insurance_type = $table_row['insurance_type'];
	}

	// Get from coup_code table where coupon_code, insurance_type
	$get_code = get_one_row_from_one_table_by_two_params('coupon_code', 'coupon_code', $coupon_code, 'insurance_type', $insurance_type);

	if(empty($get_code)){
		exit(json_encode([
			"status" => 0,
			"message" => "Coupon code does not exists"
		]));
	}
	$expiry_date = $get_code['expiry_date'];

	if(strtotime($expiry_date) < strtotime(date("Y-m-d"))){
		exit(json_encode([
			"status" => 0,
			"message" => "The coupon has expired"
		]));
	}

	$discount = $get_code['discount'];

	exit(json_encode([
		"status"=> 1,
		"discount" => $discount
	]));

?>