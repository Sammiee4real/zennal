<?php
	require_once('../config/functions.php');
	$coupon_code = $_POST['coupon_code'];
	$my_total = $_POST['total'];
	header('Content-Type: application/json');
	$response_array = [];
	$get_code = get_one_row_from_one_table('coupon_code', 'coupon_code', $coupon_code);
	$user_id = $_SESSION['user']['unique_id'];
	$get_user_wallet_balance = get_one_row_from_one_table('wallet', 'user_id', $user_id);
 	$wallet_balance = ($get_user_wallet_balance != null) ? $get_user_wallet_balance['balance'] : 0;
	if($get_code == null){
		$response_array = [
			"status" => "Incorrect code, please try again"
		];
	}else{
		$discount = $get_code['discount'];
		$total = $my_total - $discount;
		$remove_from_wallet = $_POST['remove_from_wallet'];
		if($remove_from_wallet == 1){
			if($wallet_balance > $total){
				$total = 0;
			}
			else{
				$total = $total - $wallet_balance;
			}
		}
		$response_array = [
			"status"=>"success",
			"discount" => number_format($discount),
			"discount_without_format" => $discount,
			"total" => number_format($total),
			"total_without_format" => $total
		];
	}
	echo json_encode($response_array);
?>