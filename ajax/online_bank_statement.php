<?php
	session_start();
	include('../config/functions.php');
	$user_id = $_SESSION['uid'];
	$amount = 2100;
	$generate_bank_statement = generate_bank_statement($user_id, $amount);
	$generate_bank_statement_decode = json_decode($generate_bank_statement, true);
	$_SESSION['loan_amount'] = $_POST['loan_amount'];
	$_SESSION['purpose_of_loan'] = $_POST['purpose_of_loan'];
	echo $generate_bank_statement_decode['msg'];
?>