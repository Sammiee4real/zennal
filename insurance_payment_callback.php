<?php
require_once('config/functions.php');

$payment_id = $_GET['payment_id'];
$insurance_id = $_GET['insurance_id'];
$table = 'vehicle_insurance';
$param = 'insurance_id';

if(save_successful_payment_id($table, $payment_id, $param, $insurance_id)){
    header("location: index.php");
}
?>