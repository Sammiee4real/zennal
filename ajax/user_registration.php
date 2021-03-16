<?php 
  // session_start();
  require_once('../config/functions.php');

  $post = $_POST;

  $register_user = register_user($post);

  $decode = json_decode($register_user, true);
  if($decode['status'] === 1){
    echo "success";
  }else{
    echo $decode['msg'];
  }
?>