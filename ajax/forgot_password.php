<?php 
  // session_start();
  require_once('../config/functions.php');

  $data = $_GET;

  $forgot_password = forgot_password($data);

  $decode = json_decode($forgot_password, true);
  if($decode['status'] === 1){
    echo "success";
  }else{
    echo $decode['msg'];
  }
?>