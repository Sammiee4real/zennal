<?php 
  // session_start();
  require_once('../config/functions.php');

  $post = $_POST;

  $login_user = login_user($post);
  $decode = json_decode($login_user, true);
  if($decode['status'] === 1){
    echo "success";
  }else{
    echo $decode['msg'];
  }
?>