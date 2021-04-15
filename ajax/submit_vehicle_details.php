<?php
require_once('../config/functions.php');
/* Getting file name */
$files = $_FILES;
$post_data = $_POST;


$res = save_vehicle_details($post_data, $files);
// echo $res;
$decode = json_decode($res, true);
if($decode['status'] == 1){
  echo "success";
}else{
  echo $decode['msg'];
}

?>