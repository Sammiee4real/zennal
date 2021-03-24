<?php 
  //session_start();
  require_once('../config/functions.php');
  $otp =  $_POST['otp'];
  $verify_otp = verify_otp($otp);
  $decode = json_decode($verify_otp, true);
  if($decode['status'] !== "1"){
    echo $decode['msg'];
  }else{
    echo "success";
  }
 //echo verify_otp($otp);
  
?>