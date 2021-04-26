<?php
require_once('../config/functions.php');
/* Getting file name */
$post_data = $_POST;

$res = save_vehicle_permit($post_data);

echo $res;
// echo $res;
// $decode = json_decode($res, true);

// if($decode['status'] == 1){
//   echo "success";
// }

?>