<?php
	session_start();
    include('config/functions.php');
    header('Content-Type: application/json');
    $user_id = $_SESSION['user']['unique_id'];
    $payload = file_get_contents('php://input');	
    $transaction_id = $_GET['transaction_id'];
    $sql = "INSERT INTO `okra_test` SET `received_json`='$payload', `user_id` = '$user_id', `date_received`=now()";
    $qry = mysqli_query($dbc,$sql);
?>