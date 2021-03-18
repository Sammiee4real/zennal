<?php 
  // session_start();
  require_once('../config/functions.php');

  $data = $_POST;

  $reset_password = reset_password($data);

  $decode = json_decode($reset_password, true);
  if($decode['status'] === 1){
    echo "success";
  }else{
    echo $decode['msg'];
  }
?>