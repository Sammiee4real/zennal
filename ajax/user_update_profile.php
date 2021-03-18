<?php 
  // session_start();
  require_once('../config/functions.php');

  $post = $_POST;

  $update_user = update_user_profile($post);

  $decode = json_decode($update_user, true);
  if($decode['status'] === 1){
    echo "success";
  }else{
    echo $decode['msg'];
  }
?>