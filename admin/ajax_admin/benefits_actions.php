<?php
	require_once('../../config/functions.php');
    
    if(isset($_POST['benefits_actions'])){
        $total = $_POST['id'];

        $res = [];

        for($i = 1; $i<=$total; $i++){
            if(isset($_POST['benefit_id_'.$i])){
                $res = updateBenefit($_POST['benefit_'.$i], $_POST['package_id_'.$i], $_POST['benefit_id_'.$i]);
            }else{
                $res = addBenefit($_POST['benefit_'.$i], $_POST['package_id_'.$i]);
            }
        }

        echo json_encode($res);
    }

    function addBenefit(String $benefit, String $pkg_id)
    {
        global $dbc;

        $uid = uniqid();

        if(!check_record_by_two_params('insurance_benefits','benefit',$benefit,'package_id',$pkg_id)){
            $sql = "INSERT into insurance_benefits set unique_id = '$uid', benefit = '$benefit', package_id = '$pkg_id'";
            if(mysqli_query($dbc, $sql)){
                $res = ['success'=>true, 'Benefit(s) added successfully'];
            }else{
                $res = ['success'=>false, 'message'=>'One or more benefits were not added'];
            }
        }else{
            $res = ['success'=>false, 'message'=>'Unable to one or more benefit(s), data already exist'];
        }

        return $res;
    }


    function updateBenefit(String $benefit, String $pkg_id, String $uid)
    {
        global $dbc;

        if(!check_record_by_two_params('insurance_benefits','benefit',$benefit,'package_id',$pkg_id)){
            $sql = "UPDATE insurance_benefits set benefit = '$benefit', package_id = '$pkg_id' where unique_id = '$uid'";

            if(mysqli_query($dbc, $sql)){
                $res = ['success'=>true, 'Benefit(s) updated successfully'];
            }else{
                $res = ['success'=>false, 'message'=>'One or more benefits were not updated'];
            }

            return $res;
        }else{
            $res = ['success'=>false, 'message'=>'Unable to one or more benefit(s), data already exist'];
        }

        return $res;
    }
?>