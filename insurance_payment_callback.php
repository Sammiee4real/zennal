<?php
require_once('config/functions.php');

$payment_id = $_GET['payment_id'];
$insurance_id = $_GET['insurance_id'];

if(save_insurance_payment_id($insurance_id, $payment_id)){
    header("location: index.php");
}
?>