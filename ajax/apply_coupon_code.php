<?php
	require_once('../config/functions.php');
	$coupon_code = $_POST['coupon_code'];
	$my_total = $_POST['total'];
	header('Content-Type: application/json');
	$get_code = get_one_row_from_one_table('coupon_code', 'coupon_code', $coupon_code);
	$discount = $get_code['discount'];
	$total = $my_total - (($discount / 100) * $my_total);
	$response_array = [];
	if($get_code == null){
		$response_array = [
			"status" => "Incorrect code, please try again"
		];
	}else{
		$response_array = [
			"status"=>"success",
			"discount" => $discount,
			"total" => number_format($total),
			"total_without_format" => $total
		];
	}
	echo json_encode($response_array);
?>