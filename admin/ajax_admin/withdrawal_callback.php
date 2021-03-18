<?php
	require_once('../../config/functions.php');
	$request_id = isset($_GET['request_id']) ? $_GET['request_id'] : '';
	$reference = isset($_GET['reference']) ? $_GET['reference'] : '';
	if($request_id != ''){
		$get_withdrawal_request = get_one_row_from_one_table_by_id('withdrawal_request', 'unique_id', $request_id, 'date_created');
    	$get_user_balance = get_one_row_from_one_table_by_id('wallet', 'user_id', $get_withdrawal_request['user_id'], 'date_created');
    	$wallet_balance = $get_user_balance['balance'];
    	$new_balance = $wallet_balance - $get_withdrawal_request['amount'];
    	$update_request = update_by_one_param('withdrawal_request','status', 1, 'unique_id',$request_id);
    	$update_wallet = update_by_one_param('wallet','balance', $new_balance, 'user_id',$get_withdrawal_request['user_id']);
	}
?>