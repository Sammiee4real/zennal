<?php
session_start();
require_once('../../config/database_functions.php');
    $password = $_POST['new_password'];

    $hash = md5($password);

    $confirm_password = $_POST['confirm_password'];
    $old_password = $_POST['old_password'];
    $hash_old_password = md5($old_password);

    $assigned_by = $_SESSION['admin_id'];
    $get_admin = get_one_row_from_one_table_by_id('admin', 'unique_id', $assigned_by, 'date_created');

    if(empty($password) || empty($confirm_password) || empty($old_password)){
        echo "Empty field(s) found";
    }
    else if($get_admin['password'] != $hash_old_password){
        echo "Your old password is incorrect";
    }
    else if ($password != $confirm_password){
        echo "Passwords do not match";
    }else{
   
    $update_password = update_by_one_param('admin','password',$hash, 'unique_id',$assigned_by);

    //$update_password_decode = json_decode($update_password, true);
    if($update_password){
    echo 200;
    }
    else{
    	echo "Please try again";
    }
}
 ?> 