<?php
require_once('config/functions.php');

$payment_id = $_GET['payment_id'];
$reg_id = $_GET['reg_id'];
$table = 'renew_vehicle_particulars';
$param = 'unique_id';


if(save_successful_payment_id($table, $payment_id, $param, $reg_id)){
    header("location: index.php");
}
?>