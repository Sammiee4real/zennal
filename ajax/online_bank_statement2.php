<?php
	session_start();
	include('../config/functions.php');
	$user_id = $_SESSION['user']['unique_id'];
	$id = $_POST['id'];
	$amount = 2100;
	$generate_bank_statement = generate_bank_statement2($user_id, $amount, $id);
	$generate_bank_statement_decode = json_decode($generate_bank_statement, true);
	$_SESSION['purpose_of_loan'] = $_POST['purpose_of_loan'];
	echo $generate_bank_statement_decode['msg'];
?>