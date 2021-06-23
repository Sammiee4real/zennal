<?php
    require_once('config/functions.php');

    $payment_id = $_GET['payment_id'];
    $reg_id = $_GET['reg_id'];
    $table = 'renew_vehicle_particulars';
    $param = 'unique_id';

    
    $insurances_made = get_rows_from_table("vehicle_insurance");

    foreach($insurances_made as $insurance){

        $policy_end_date = $insurance['policy_end_date'];
        $user_id = $insurance['user_id'];

        $today_date = date("Y-m-d");

        $d1 = new DateTime($policy_end_date);
        $d2 = new DateTime($today_date);
        $interval = $d1->diff($d2);

        $description = "";
        $type = "Insurance Policy";
        

        if($interval->m == 1){
            $description = "Your insurance policy will end on  $policy_end_date";
        }elseif($interval->d == 14){
            $description = "Your insurance policy will end on  $policy_end_date";
        }elseif($interval->d == 1){
            $description = "Your insurance policy will end on  $policy_end_date";
        }

        insert_logs($user_id, $type, $description);
    }
?>