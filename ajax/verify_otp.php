<?php 
  session_start();
  require_once('../config/functions.php');
  $otp =  $_POST['otp'];
  $user_id = $_SESSION['user']['unique_id'];
  $verify_otp = verify_otp($otp, $user_id);
  $decode = json_decode($verify_otp, true);
  if($decode['status'] !== "1"){
    echo $decode['msg'];
  }else{
    echo "success";
  }
 //echo verify_otp($otp);
  
?>