<?php 
    require_once('../../config/functions.php');

    global $dbc;

    if(isset($_POST['addInsurer'])){
        $data = array(
            'benefit_id', 'plan_id', 'package_id', 'value', 'insurer_id'
        );
        $res = [];

        if(!check_record_by_two_params('insurances','benefit_id',$_POST['benefit_id'],'plan_id',$_POST['plan_id'], 'insurer_id', $_POST['insurer_id'])){
            $insert = insert_into_db('insurances',$data,'id',0);
            $decode = json_decode($insert, true);
            if($decode['status'] == "1"){
                $res = ['success'=>true];
            }else{
                $res = ['success'=>false];
            }
        }else{
            $sql = "SELECT unique_id from insurances where benefit_id = '".$_POST['benefit_id']."' and plan_id = '".$_POST['plan_id']."' and insurer_id = '".$_POST['insurer_id']."'";

            $insurance_id = mysqli_fetch_object(
                mysqli_query($dbc, $sql)
            )->unique_id;

            $data = array(
                'benefit_id', 'plan_id', 'package_id', 'value', 'insurer_id'
            );

            $updateQuery = mysqli_query(
                $dbc, "UPDATE insurances set `value` = '".$_POST['value']."' where unique_id = '$insurance_id'"
            );

            if($updateQuery){
                $res = ['success'=>true];
            }else{
                $res = ['success'=>false];
            }
        }

        echo json_encode($res);
    }

?>
