<?php 
  // session_start();
  require_once('../../config/database_functions.php');

  $post = $_POST;

  $login_user = admin_login_user($post);
  $decode = json_decode($login_user, true);
  if($decode['status'] !== 1){
    echo $decode['msg'];
  }else{
    echo "success";
  }
?>