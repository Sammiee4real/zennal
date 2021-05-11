<?php
@session_start();
$table = "";
$app_name = 'ZENNAL';
require_once("db_connect.php");
require_once("tcpdf/tcpdf.php");
require_once('generic_functions.php');
// require_once("config_settings.php");
global $dbc;


// // Email Function
//   $headers .= 'From: FarmKonnect <admin@farmkonnect.com>' . "\r\n";
//   $headers .= 'Cc: support@loyalty.com' . "\r\n";

function email_function($email, $subject, $content){
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $headers .= "From: Zennal";
    @$mail = mail($email, $subject, $content, $headers);
    return $mail;
  }
  

  // Cloud SMS
function send_sms($sender, $to, $message, $developer_id, $cloud_sms_password){

  // The cloudsms api only accepts numbers in the format 234xxxxxxxxxx (without the + sign.)
  $curl = curl_init();

  curl_setopt_array($curl, array(
      CURLOPT_URL => "http://developers.cloudsms.com.ng/api.php?userid=".$developer_id."&password=".$cloud_sms_password."&type=0&destination=".$to."&sender=".$sender."&message=$message",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_HTTPHEADER => array(
          "Content-Type: application/x-www-form-urlencoded",
          "cache-control: no-cache"
      ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);
  return $response;
}


function get_number_of_rows_two_params($table,$param1,$value1,$param2,$value2){
  global $dbc;
  $table = secure_database($table);
  $param1 = secure_database($param1);
  $value1 = secure_database($value1);
  $param2 = secure_database($param2);
  $value2 = secure_database($value2);
  $sql= "SELECT id FROM `$table` WHERE `$param1`='$value1' AND `$param2`='$value2'";
  $query = mysqli_query($dbc, $sql);
  $count = mysqli_num_rows($query);
  return $count;     
}

function get_number_of_rows_one_param($table,$param1,$value1){
  global $dbc;
  $table = secure_database($table);
  $param1 = secure_database($param1);
  $value1 = secure_database($value1);
  $sql= "SELECT id FROM `$table` WHERE `$param1`='$value1'";
  $query = mysqli_query($dbc, $sql);
  $count = mysqli_num_rows($query);
  return $count;     
}

function get_number_of_rows($table){
  global $dbc;
  $table = secure_database($table);
  $sql= "SELECT id FROM `$table`";
  $query = mysqli_query($dbc, $sql);
  $count = mysqli_num_rows($query);
  return $count;     
}

function get_rows_from_table($table){
  global $dbc;
  $table = secure_database($table);
  $sql= "SELECT * FROM `$table`";
  $query = mysqli_query($dbc, $sql);
  $data = mysqli_fetch_all($query, MYSQLI_ASSOC);
  return $data;     
}

function get_rows_from_table_with_one_params($table, $param, $value){
  global $dbc;
  $table = secure_database($table);
  $sql= "SELECT * FROM `$table` WHERE `$param` = '$value'";
  $query = mysqli_query($dbc, $sql);
  $data = mysqli_fetch_all($query, MYSQLI_ASSOC);
  return $data;     
}

function add_insurance_benefit($data){
    
    global $dbc;
    
    $insurer_id = $data['insurer_id'];

    $sql = "SELECT unique_id FROM insurance_plans WHERE `insurer_id` = '$insurer_id'";
    
    $exe = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
    
    $insurance_plans = mysqli_fetch_all($exe);

    foreach($insurance_plans as $plan_in_arr){
      $actual_plan = $plan_in_arr[0];
      $status = "status_".$actual_plan;
      $narration = "narr_".$actual_plan;
      if(array_key_exists($status, $data) && array_key_exists($narration, $data)){
        // print(1);
        // die();
        $status_val = intval($data[$status]);
        $narr_val = $data[$narration];
        $benefit = $data['benefit_name'];
        $plan_id = $actual_plan;
        $insurer_id = $data['insurer_id'];

        $unique_id = unique_id_generator($narration);

        $sql = "INSERT INTO `insurance_benefits` SET `unique_id` = '$unique_id', `benefit` = '$benefit', `plan_id` = '$plan_id', `status` = '$status_val', `description` = '$narr_val', `insurer_id` = '$insurer_id', `datetime` = now()";

        mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
      }
    }
    return json_encode(array("status"=>1));

    // if(mysqli_num_rows($exe) >= 1){
    //     return json_encode(array("status"=>0, "msg"=>"Benefit exist"));
    // }
    
    // $benefit_unique_id = unique_id_generator($benefit_name);
    
    // $sql = "INSERT INTO insurance_benefits (unique_id, benefit, datetime)
    //         VALUES ('$benefit_unique_id', '$benefit_name', now())";
    
    // $exe = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
    
    // unset($data["benefit_name"]);
    
    // foreach($data as $k => $v){
    //     $unique_id = unique_id_generator($k);
    //     $sql = "INSERT INTO insurance_info (unique_id, benefit_id, category_id, description, datetime)
    //         VALUES ('$unique_id', '$benefit_unique_id', '$k', '$v', now())";
    //     $exe = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
    // }
    // return json_encode(array("status"=>1));
}


///////// Badmus Functions Starts Here //////////////////////

// Verify User Phone & Email
function verify_user($phone, $email){
  global $dbc;
  global $app_name;

  $sql = "SELECT COUNT(*) AS count FROM users WHERE phone = '$phone' AND email = '$email'";
  
  $row = mysqli_fetch_assoc(mysqli_query($dbc, $sql)); 

  if ($row["count"] > 0){
    // http_response_code(400);
    return json_encode(array("status"=>0, "msg"=>"User exist"));
  }

  $otp = rand(000000, 999999);

  $subject = "Zennal Registration";
  $content = "<html><body>";
  $content .= "<p>Use the following OTP for your verification.</p><br/>";
  $content .= "<h1>".$otp."</h1>";
  $content .= "</body></html>";

   $send_email = email_function($email, $subject, $content);
   $send_sms = send_sms($app_name, $phone, $content, $developer_id, $cloud_sms_password);

   if( !$send_email || !$send_sms){
    http_response_code(500);
     return json_encode(array("status"=>0, "msg"=>"OTP not sent"));
   }

  $_SESSION["otp"] = md5($otp);
  $_SESSION['start'] = time();
  $_SESSION['expire'] = $_SESSION['start'] + (60*3);

  // http_response_code(200);
  return json_encode(array("status"=>1, "msg"=>"Success"));
}




// Register User
function register_user_initial($data){
  global $dbc;


  $personal_info = $data["personal"];
  $contact_info = $data["contact"];
  $identity_info = $data["identity"];
  $nextofkin_info = $data["nextofkin"];

  // return  $nextofkin_info;

  //  Check for empty fields
  foreach ($personal_info as $info) {

    if (strlen($info) == 0){
      // http_response_code(400);
      return json_encode(array("status"=>0, "msg"=>"All personal fields are required"));
    }
  }

  foreach ($contact_info as $info) {

    if (strlen($info) == 0){
      // http_response_code(400);
      return json_encode(array("status"=>0, "msg"=>"All contact fields are required"));
    }
  }

  foreach ($identity_info as $info) {

    if (strlen($info) == 0){
      // http_response_code(400);
      return json_encode(array("status"=>0, "msg"=>"All identity fields are required"));
    }
  }

  foreach ($nextofkin_info as $info) {

    if (strlen($info) == 0){
      // http_response_code(400);
      return json_encode(array("status"=>0, "msg"=>"All next of kin fields are required"));
    }
  }
  
  // Personal Info
  $first_name = $personal_info["first_name"];
  $last_name = $personal_info["last_name"];
  $other_names = $personal_info["other_names"];
  $gender = $personal_info["gender"];
  $dob = $personal_info["dob"];
  $marital_status = $personal_info["marital_status"];
  $employment_status = $personal_info["employment_status"];
  $password1 = $personal_info["password1"];

  // Contact_info
  $email = $contact_info["email"];
  $phone_number = $contact_info["phone_number"];
  $address = $contact_info["address"];
  $preferred_contact = $contact_info["preferred_contact"];

  // Identity_info
  $means_of_id = $identity_info["means_of_id"];
  $profile_pic = $identity_info["profile_pic"];

  // Nextofkin_info
  $next_of_kin_first_name = $nextofkin_info["next_of_kin_first_name"];
  $next_of_kin_last_name = $nextofkin_info["next_of_kin_last_name"];
  $next_of_kin_phone = $nextofkin_info["next_of_kin_phone"];

  $sql = "SELECT COUNT(*) AS count FROM users WHERE phone = '$phone_number' AND email = '$email'";

  $user = mysqli_fetch_assoc(mysqli_query($dbc, $sql));

  if ($user["count"] >= 1){
      // http_response_code(400);
      return json_encode(array("status" => 0, "msg" => "User exist"));
  }
  
  $password = md5($password1);
  $unique_id = unique_id_generator($password);

  $sql = "INSERT INTO users (unique_id, first_name, last_name, other_names, address, id_type, dob, email, phone, password, gender, marital_status, employment_status, profile_pic)
            VALUES 
          ('$unique_id', '$first_name', '$last_name', '$other_names', '$address', '$means_of_id', '$dob', '$email', '$phone_number', '$password', '$gender', '$marital_status', '$employment_status', '$profile_pic')";

  if (! mysqli_query($dbc, $sql)){
    // http_response_code(500);
    return json_encode(array("status"=>0, "msg"=>"Cannot register user"));
  }

  $sql = "SELECT * FROM users WHERE unique_id = '$unique_id' AND email = '$email'";

  $user = mysqli_query($dbc, $sql);

  if(mysqli_num_rows($user) === 1){
    $user = mysqli_fetch_assoc($user);
    $userid = $user["id"];
    $nok_unique_id = unique_id_generator($userid);

    $sql = "INSERT INTO next_of_kin (unique_id, user_id, nok_first_name, nok_last_name, nok_phone) 
            VALUES 
          ('$nok_unique_id', '$userid', '$next_of_kin_first_name', '$next_of_kin_last_name', '$next_of_kin_phone')";

    if (! mysqli_query($dbc, $sql)){
      // http_response_code(500);
      return json_encode(array("status"=>0, "msg"=>"Cannot register next of kin"));
    }
  }else{
    // http_response_code(500);
    return json_encode(array("status"=>0, "msg"=>"Cannot resolve user"));
  }
  



  return json_encode(array("status" => 1, "msg" => "Success"));
}

// Badmus
function register_user($post){
  global $dbc;

  if(isset($post["referrerid"])){
    $referrer_code = secure_database($post["referrerid"]);
    
    $sql = "SELECT id FROM `users` WHERE `referral_code` = '$referrer_code'";

    $exe = mysqli_query($dbc, $sql);

    $count = mysqli_num_rows($exe);

    if (intval($count) === 0) {
      return json_encode(array("status"=>0, "msg"=>"Invalid referral link"));
    }
  }
  else {
    $referrer_code = null;
  }

  $email = secure_database($post["email"]);

  if (user_exists($email) === true) {
    return json_encode(array("status"=>0, "msg"=>"User already registered"));
  }

  $password = secure_database($post["password"]);
  $cpassword = secure_database($post["cpassword"]);

  if($password !== $cpassword){
    return json_encode(array("status"=>0, "msg"=>"Password does not match"));
  }

  $title = secure_database($post["title"]);
  $first_name = secure_database($post["first_name"]);
  $last_name = secure_database($post["last_name"]);
  $other_name = secure_database($post["other_name"]);
  $phone_no = secure_database($post["phone_no"]);

  $referral_code = substr(md5(microtime()), 0, 6);
  $unique_id = unique_id_generator($email);

  $hash_password = md5($password);

  $sql = "INSERT INTO `users` SET `unique_id` = '$unique_id', `title` = '$title' `first_name` = '$first_name', `last_name` = '$last_name', `other_names` = '$other_name', `referral_code` = '$referral_code', `referrer_code` = '$referrer_code', `email` = '$email', `phone` = '$phone_no', `password` = '$hash_password', `registered_on` = now()";

  $query = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));

  if($query){
    return json_encode(array("status"=>1, "msg"=>"success"));
  }
}

// Badmus
function get_user_details($email, $password){
  global $dbc;
  $sql = "SELECT * FROM `users` WHERE `email`='$email' AND `password`='$password'";
  $query = mysqli_query($dbc, $sql);
  $re = mysqli_fetch_assoc($query);

  if (empty($re)) {
    return false;
  } else {
    return $re;
  }

}

// Badmus
function login_user($post){
  
  $email = secure_database($post["email"]);
  $password = secure_database($post["password"]);
  $hashpassword = md5($password);
  
  $user = get_user_details($email, $hashpassword);

  if($user === false){
    return json_encode(array("status"=>0, "msg"=>"Invalid login details"));
  }else{

    if (intval($user['email_verified']) === 0) {
      // Email verification
      send_verification_link($user);
    }

    $_SESSION['user'] = $user;
    return json_encode(array("status"=>1, "msg"=>"success"));
  }

}

// Badmus
function verify_user_email($user_id){
  global $dbc;

  $sql = "UPDATE `users` SET `email_verified` = 1 WHERE unique_id ='$user_id'";
  $query = mysqli_query($dbc, $sql);
  return true;

}

// Badmus
function send_verification_link($user){

  $verr_id = md5($user['unique_id']);
  $email = $user['email'];
  // Email verification
  $subject = 'Email verification';
  $content = 'Dear '.$user['first_name'].' '.$user['last_name'].'<br/>';
  $content .= 'Please click on the link below to verify your account <br/>';
  $content .= '<a href="https://'.$_SERVER['HTTP_HOST'].'verify_email.php?id='.$verr_id.'"></a><br/>';
  $content .= 'Thank you';
  
  if(email_function($email, $subject, $content)){
    return true;
  }else{
    return false;
  }
}

// Badmus
function update_user_profile($post){
  global $dbc;

  $address = secure_database($post["address"]);
  $dob = secure_database($post["dob"]);
  $gender = strtolower(secure_database($post["gender"]));
  $marital_status = strtolower(secure_database($post["marital_status"]));
  $employment_status = strtolower(secure_database($post["employment_status"]));
  $occupation = secure_database($post["occupation"]);

  $user_id = $_SESSION['user']['unique_id'];

  $sql = "UPDATE `users` SET `address`='$address', `dob`='$dob', `gender`='$gender', `marital_status`='$marital_status', `employment_status`='$employment_status', `occupation`='$occupation' WHERE `unique_id`='$user_id'";

  $exe = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
  if ($exe) {
    session_referesh();
    return json_encode(array("status"=>1, "msg"=>"success"));
  }
}

// Badmus
function forgot_password($data){

  $email = $data['email'];

  if (user_exists($email) !== true) {
    return json_encode(array("status"=>0, "msg"=>"Unknown email"));
  }
  else{
    $get_user = get_one_row_from_one_table('users', 'email', $email);
    $unique_id = base64_encode($get_user['unique_id']);

    $actual_link = "http://$_SERVER[HTTP_HOST]"."/reset_password?unique_id=$unique_id";

    $email_subject = 'Password Reset Link';

    $content = '<p>Please click the link below to reset your password</p>';
    $content .= '<p>'.$actual_link.'</p>';
    $content .= 'Thank you';
    
    if(email_function($email, $email_subject, $content)){
      return json_encode(array("status"=>1));
    }else{
      return json_encode(array("status"=>0, "msg"=>"Password reset link not sent"));
    }
  }
}

// Badmus
function reset_password($data){
  global $dbc;
  
  $password = secure_database($data['password']);
  $confirm_password = secure_database($data['cpassword']);
  $unique_id = secure_database($data['unique_id']);
  
  if($password == "" || $confirm_password == ""){
    return json_encode(array("status"=>0, "msg"=>"Password fields are required"));
  }
  else if ($password !== $confirm_password){
    return json_encode(array("status"=>0, "msg"=>"Passwords do not match"));
  }
  else if (strlen($password) < 8) {
    return json_encode(array("status"=>0, "msg"=>"Your Password Must Contain At Least 8 Characters!"));
  }
  else if($unique_id == null){
    return json_encode(array("status"=>0, "msg"=>"Failed resetting password"));
  }

  $enc_password = md5($password);
  $sql = "UPDATE `users` SET `status` = 1, `password` = '$enc_password' WHERE `unique_id` = '$unique_id'";
  $query = mysqli_query($dbc, $sql);

  if($query){
    return json_encode(array("status"=>1, "msg"=>"Password has been reset successfully"));
  }
  else{
    return json_encode(array("status"=>0, "msg"=>"Failed resetting password"));
  }

}


// Badmus 
function add_insurer($insurer_name, $file_name){
  global $dbc;

  $unique_id = unique_id_generator($insurer_name);
  $sql = "INSERT INTO insurers SET `unique_id` = '$unique_id', `name` = '$insurer_name', `image` = '$file_name', `datetime` = now()";

  if(mysqli_query($dbc, $sql)){
    return json_encode(array("status"=>1, "msg"=>"Insurer added successfully"));
  }else{
    return json_encode(array("status"=>0, "msg"=>"Insurer data cannot be saved"));
  }
}

// Badmus

function get_insurance_benefits($insurer_id){
  global $dbc;

  $outer_arr = array();
  // $benefits_arr = array(
  //   'single_benefit' => array(
  //     'benefit' => null,
  //     'details' => array()
  //   )
  // );

  $benefit_name = null;

  $sql = "SELECT * FROM `insurance_benefits` WHERE `insurer_id` = '$insurer_id'";

  $exe = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));

  $data = mysqli_fetch_all($exe, MYSQLI_ASSOC);

  $benefit_arr = array(
    'benefit' => null,
    'details' => array()
  );

  foreach ($data as $benefit) {
    // $benefit_name = $benefit['benefit']
    // if ($benefit_arr['benefit'] != $benefit_name) {
    //   $benefit_arr['benefit'] = $benefit_name
    //   $benefit_name = $benefit['benefit'];
    //   $benefit_plan['plan_id'] = $benefit['plan_id'];
    //   $benefit_plan['status'] = $benefit['status'];
    //   $benefit_plan['description'] = $benefit['description'];
    //   array_push($benefit_details, $benefit_plan);
    if ($benefit_arr['benefit'] != $benefit['benefit']) {
      $benefit_arr['benefit'] = $benefit['benefit'];

      foreach ($data as $inner_benefit) {
        if($inner_benefit['benefit'] == $benefit_arr['benefit']){
          $details_arr = array(
            'plan_id' => $inner_benefit['plan_id'],
            'status' => $inner_benefit['status'],
            'description' => $inner_benefit['description'],
          );
          array_push($benefit_arr['details'], $details_arr);
        }
      }
      array_push($outer_arr, $benefit_arr);
    }
    
  }
  // }

  return $outer_arr;
}


// Badmus
function save_quote($vehicle_value, $prefered_insurer, $select_plan){
  global $dbc;

  $user_id = $_SESSION['user']['unique_id'];

  $user_saved_quote = get_rows_from_table_with_one_params('saved_quotes', 'user_id', $user_id);

  if (empty($user_saved_quote)) {

    $unique_id = unique_id_generator($user_id);

    $sql = "INSERT INTO `saved_quotes` SET `unique_id`='$unique_id', `user_id`='$user_id', `vehicle_value`='$vehicle_value', `insurer_id`='$prefered_insurer', `plan_id`='$select_plan', `date_created`=now()";
  }else {
    $sql = "UPDATE `saved_quotes` SET `vehicle_value`='$vehicle_value', `insurer_id`='$prefered_insurer', `plan_id`='$select_plan', `date_created`=now() WHERE `user_id`='$user_id'";
  }

  $exe = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
  return json_encode(array("status"=>1));
}
// Badmus
function get_vehicle_value($plan_id, $vehicle_value){
  global $dbc;

  $sql = "SELECT `plan_percentage` FROM insurance_plans WHERE `unique_id` = '$plan_id'";

  $exe = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));

  $data = mysqli_fetch_assoc($exe);

  $percentage_interest = $data['plan_percentage'];

  $percentage_value = floatval((($percentage_interest / 100) * $vehicle_value));
  $premium_value = $percentage_value + $vehicle_value;
  return $premium_value;
}

// Badmus

function update_user_image($filename){
  global $dbc;

  $user_id = $_SESSION['user']['unique_id'];

  $sql = "UPDATE `users` SET `profile_pic` = '$filename' WHERE `unique_id` = '$user_id'";

  $exe = mysqli_query($dbc, $sql);
  if ($exe) {
    session_referesh();
    return true;
  }else {
    return false;
  }
}
// Badmus
function get_insurance_quote($insurer, $package_plan, $payment_method){

  global $dbc;

  // Validate input

  if($insurer == ""){
    return json_encode(array('status'=>0, 'msg'=>"Please select an insurer"));
  }
  else if($package_plan == ""){
    return json_encode(array('status'=>0, 'msg'=>"Please select a package plan"));
  }
  else if($payment_method == ""){
    return json_encode(array('status'=>0, 'msg'=>"Please select a payment method"));
  }


  $user_id = $_SESSION['user']['unique_id'];

  $insurance_query = "SELECT * FROM `vehicle_insurance` WHERE `user_id` = '$user_id'";
  $insurance_query_exe = mysqli_query($dbc, $insurance_query) or die(mysqli_error($dbc));

  $user_insurance = mysqli_fetch_assoc($insurance_query_exe);

  $first_name = $_SESSION['user']['first_name'];
  $last_name = $_SESSION['user']['last_name'];
  $gender = $_SESSION['user']['gender'];
  $dob = $_SESSION['user']['dob'];
  $title = $_SESSION['user']['title'];
  $email = $_SESSION['user']['email'];

  $usage = $user_insurance['usage'];
  $make_of_vehicle = $user_insurance['make_of_vehicle'];
  $other_make_of_vehicle = $user_insurance['other_make_of_vehicle'];
  $vehicle_type = $user_insurance['vehicle_type'];
  $vehicle_reg_no = $user_insurance['vehicle_reg_no'];
  $vehicle_model = $user_insurance['vehicle_model'];
  $year_of_make = $user_insurance['year_of_make'];
  $chassis_number = $user_insurance['chassis_number'];
  $engine_number = $user_insurance['engine_number'] == ""?$user_insurance['chassis_number']:$user_insurance['engine_number'];
  $risk_location = $user_insurance['risk_location'];
  $insured_name = $user_insurance['insured_name'];
  $sum_insured = $user_insurance['sum_insured'];
  $insured_type = $user_insurance['insured_type'];
  $policy_start_date = $user_insurance['policy_start_date'];
  $policy_end_date = $user_insurance['policy_end_date'];
  $risk_img = $user_insurance['risk_img_base64'];
  $identity_img = $user_insurance['identity_img_base64'];

  // -----------------------------------------------------------------------------
  $curl = curl_init();
    
    $data = array("RiskDetails" => [
     array(
       "ComprehensiveMotorDetails"=> array(
         "Usage"=> $usage,
         "FloodCoverRequired"=> false, 
         "ExcessBuyBackValue"=> 0,
         "VehicleReplacementRequired"=> false,
         "TrackerDiscountEnabled"=> false,
         "TrackerRequired"=> false,
         "TrackerAmount"=> 0,
         "VehicleRegistrationNumber"=> $vehicle_reg_no,
         "MakeOfVehicle"=> $make_of_vehicle,
         "OtherMakeOfVehicle"=> $other_make_of_vehicle,
         "VehicleModel"=> $vehicle_model, 
         "YearOfMake"=> $year_of_make, 
         "LocationOfRisk"=> $risk_location, 
         "OtherLocationOfRisk"=> "", 
         "ChassisNumber"=> $chassis_number, 
         "EngineNumber"=> $engine_number, 
         "VehicleType"=> $vehicle_type, 
        //  "VideoUrl"=> "http://test.video" 
       ),
       "SumInsured"=> $sum_insured, 
       "InsuredType"=> $insured_type,
    //   "AddonAnswers"=> [ 
    //      array( 
    //       "ID"=> 12, 
    //       "Key"=> 1, 
    //       "Value"=> 1500, 
    //       "ValueTypeText"=> "Number" 
    //      ) 
    //   ], 
       "RiskImages"=> [ 
         array( 
           "Filename"=> "RiskImage.jpg", 
           "Image"=> $risk_img
         )
       ], 
       "InsuredName"=> $first_name." ".$last_name
     ) 
   ], 
   "ProductUid"=> "40739515-8e6b-4217-b78d-26e750ca249a", 
   "PolicyStartDate"=> $policy_start_date,
    "PolicyEndDate"=> $policy_end_date,
   "Account"=> array( 
     "FirstName"=> $first_name, 
     "LastName"=> $last_name, 
    //  "AddressLine1"=> "902 Long Street", 
    //  "AddressLine2"=> "Maitama", 
    //  "City"=> "Abuja", 
    //  "StateName"=> "FCT", 
    //  "Lga"=> "Maitama", 
     "IdentityImage"=> $identity_img,
     "Gender"=> $gender, 
    //  "MaritialStatus"=> "Married", 
     "BirthDate"=> $dob,
     "Title"=> $title, 
    //  "Position"=> "Builder", 
    //  "Phone"=> "+234 31 534 512", 
     "Email"=> "Umar.Garba%40Testing.ng",
    //  "IndustrySector"=> "Construction", 
    //  "FullName"=> "Umar Garba", 
    //  "ThirdpartyAccountUid"=> "00000000-0000-0000-0000-000000000000" 
   ), 
   "Payment"=> array(
     "SumInsuredType"=> "Individual", 
     "Currency"=> "Naira" 
   ) 
 );
    
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://sandbox-customerportal.yoadirect.com/api/Integration/GetQuoteComprehensiveMotorInsurance",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS =>json_encode($data),
    CURLOPT_HTTPHEADER => array(
        "UserIdentity: 86b686a4-2747-457e-868b-96f857a3f48a",
        "Content-Type: application/json"
    ),
));

if (curl_exec($curl)) {
  $response = json_decode(curl_exec($curl), true);
  curl_close($curl);

  $returned_amount = $response['Quote']['PaymentDue'];

  if($returned_amount == 0) return json_encode(array("status"=>0, "msg"=>"No amount returned"));

  // Get percentage interest
  $sql = "SELECT * FROM `insurance_plans` WHERE `unique_id` = '$package_plan'";
  $exe = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
  $interest_rate = mysqli_fetch_assoc($exe);

  // $quote_array = array();

  // $installment_interest_sql = "SELECT * FROM `insurance_interest_rate`";

  // $installment_interest_exe = mysqli_query($dbc, $installment_interest_sql) or die(mysqli_error($dbc));

  // $get_insurance_interest = mysqli_fetch_all($installment_interest_exe, MYSQLI_ASSOC);

  // foreach($get_insurance_interest as $item) {
  //   if ($item['type'] == "1") { // If interest type is flat rate
  //     $amount_due = intval($item['interest_rate'] + $returned_amount);
  //     $monthly_due = array('due_amount' => $amount_due, 'month' => $item['month']);
  //     array_push($installment_array, $monthly_due);

  //   }
  //   elseif ($item['type'] == "2") { // If interest type is percentage rate
  
  //     $percentage_amount = floatval((($item['interest_rate'] / 100) * $returned_amount));
  
  //     $amount_due = intval($percentage_amount + $returned_amount);

  //     $monthly_due = array('due_amount' => $amount_due, 'month' => $item['month']);
  //     array_push($installment_array, $monthly_due);
  //   }
  // }

  if ($payment_method === "one_time") {
    
    $percentage_amount = floatval((($interest_rate['plan_percentage'] / 100) * $returned_amount));
    $amount_due = intval($percentage_amount + $returned_amount);

    // Update vehicle insurance
    $update_query = "UPDATE `vehicle_insurance` SET `insurer_id`='$insurer', `package_plan_id`='$package_plan', `payment_method`='$payment_method', `amount_due`='$amount_due', `datetime`=now() WHERE `user_id` = '$user_id'";
    
    // Execute query
    mysqli_query($dbc, $update_query) or die(mysqli_error($dbc));

    $quote_array = array('status' => 1, 'amount_due' => $amount_due);
    return json_encode($quote_array);
  }
  elseif ($payment_method === "installmental") {
    $percentage_amount = floatval((($interest_rate['plan_percentage'] / 100) * $returned_amount));

    $amount_due = intval($percentage_amount + $returned_amount);

    $equity_amount = floatval(((30 / 100) * $amount_due)); //30% equity amount

    $amount_to_balance = floatval(($amount_due - $equity_amount));

    $insurance_id = $user_insurance['unique_id'];

    $unique_id = unique_id_generator($amount_to_balance);

    if(get_number_of_rows_one_param('installmental_payment','insurance_id',$insurance_id) == 0){
      $installment_sql = "INSERT INTO `installmental_payment` SET `unique_id`='$unique_id', `insurance_id`='$insurance_id', `equity_amount`='$equity_amount', `amount_to_balance`='$amount_to_balance', `datetime`=now()";
    }
    elseif (get_number_of_rows_one_param('installmental_payment','insurance_id',$insurance_id) > 0) {
      $installment_sql = "UPDATE `installmental_payment` SET `equity_amount`='$equity_amount', `amount_to_balance`='$amount_to_balance', `datetime`=now() WHERE `insurance_id`='$insurance_id'";
    }
    mysqli_query($dbc, $installment_sql) or die(mysqli_error($dbc));

    $insurance_installment = get_rows_from_table('insurance_interest_rate');

    $quote_array = array('status' => 1, 'insurance_id'=>$insurance_id, 'equity_amount' => $equity_amount, 'amount_to_balance' => $amount_to_balance, 'months' => $insurance_installment);
    return json_encode($quote_array);
  }
  
  
  // $percentage_amount = floatval((($interest_rate['plan_percentage'] / 100) * $returned_amount));  8160

  // $amount_due = intval($percentage_amount + $returned_amount);

  // // echo $response;
  // $res = array(
  //   'data'=> array(
  //     'one_time' => array(
  //       'annual_due' => $amount_due,
  //       'quote_number' => $response['Quote']['QuoteNumber'],
  //       'validation_result' => $response['ValidationResult']
  //     ),
  //     'installment' => array(
  //       'equity_amount' => 3000,
  //       'installmental_due' => $installment_array
  //     )
  //   ),
  //   'status'=>1
  // );
  
}else {
  return json_encode(array("status"=>0, "msg"=>"Unable to get quote"));
}

    // -------------------------------------------------------------------------
}


// Badmus
function save_vehicle_particulars($post_data){
  global $dbc;

  $vehicle_type = $post_data['vehicle_type'];
  $make_of_vehicle = $post_data['make_of_vehicle'];
  $vehicle_model = $post_data['vehicle_model'];
  $year_of_make = $post_data['year_of_make'];
  $plate_no = $post_data['plate_no'];
  $engine_no = $post_data['engine_no'];
  $chassis_no = $post_data['chassis_no'];
  $vehicle_license = $post_data['vehicle_license'];
  $vehicle_color = $post_data['vehicle_color'];
  $road_worthiness = isset($post_data['road_worthiness']) ? '1':'0';
  $hackey_permit = isset($post_data['hackey_permit']) ? '1':'0';
  $vehicle_license = isset($post_data['vehicle_license']) ? '1':'0';
  $permit_type = $post_data['permit_type'];
  $insurance_type = $post_data['insurance_type'];

  $user_id = $_SESSION['user']['unique_id'];
  $unique_id = unique_id_generator($engine_no);
 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	
  $insert_query = "INSERT INTO `renew_vehicle_particulars` SET `unique_id`='$unique_id', `user_id`='$user_id', `vehicle_type`='$vehicle_type', `make_of_vehicle`='$make_of_vehicle', `vehicle_model`='$vehicle_model', `year_of_make`='$year_of_make', `plate_number`='$plate_no', `engine_number`='$engine_no',
   `chassis_number`='$chassis_no', `vehicle_license_name`='$vehicle_license', `vehicle_color`='$vehicle_color', `road_worthiness`='$road_worthiness', `hackney_permit`='$hackey_permit', `vehicle_license`='$vehicle_license', `type_of_permit`='$permit_type', `insurance_type`='$insurance_type', `datetime`=now()";
  mysqli_query($dbc, $insert_query) or die(mysqli_error($dbc));
  return json_encode(array("status"=>1, "row_id" => "$unique_id"));
}

function save_successful_payment_id($table, $payment_id, $param, $value){
  global $dbc;
  $update_query = "UPDATE `$table` SET `payment_id`='$payment_id', `paid`='1' WHERE `$param`='$value'";
  mysqli_query($dbc, $update_query) or die(mysqli_error($dbc));
  return true;
}


function save_installment($post_data){
  global $dbc;

  $insurance_id = $post_data["insuranceId"];
  $installmental_month = $post_data["installmentalMonth"];

  $update_query = "UPDATE `installmental_payment` SET `no_of_months`='$installmental_month' WHERE `insurance_id`='$insurance_id'";
  mysqli_query($dbc, $update_query) or die(mysqli_error($dbc));
  return json_encode(array("status"=>1));
}

function insurance_packages(){
  global $dbc;
  $sql = "SELECT * FROM insurance_packages";
  $fetch_packages = mysqli_query($dbc, $sql);
  if (! $fetch_packages){
    return json_encode(array("status"=>0, "msg"=>"Cannot fetch packages"));
  }
  if (mysqli_num_rows($fetch_packages) == 0){
    return json_encode(array("status"=>0, "msg"=>"No packages available"));
  }
  $packages = mysqli_fetch_all($fetch_packages,  MYSQLI_ASSOC);
  return json_encode(array("status"=>1, "packages"=>$packages));
}

function insurance_pricing_plans(){
  global $dbc;

  $sql = "SELECT * FROM insurance_pricing_plans";
  $fetch_pricing = mysqli_query($dbc, $sql);
  if (! $fetch_pricing){
    return json_encode(array("status"=>0, "msg"=>"Cannot fetch pricing plans"));
  }
  if (mysqli_num_rows($fetch_pricing) == 0){
    return json_encode(array("status"=>0, "msg"=>"No pricing plans"));
  }
  $pricing = mysqli_fetch_all($fetch_pricing,  MYSQLI_ASSOC);
  return json_encode(array("status"=>1, "pricing"=>$pricing));
}

function save_insurance_details($info){
  global $dbc;

  $vehicle_basic_info = $info["vehicleBasicInfo"];
  $vehicle_attached_info = $info["attachedFiles"];

  $package_id = $info["savedInsurance"]["insurancePackageId"];
  $pricing_id = $info["savedInsurancePricing"]["insurancePricingId"];
  // -----------------------
  $vehicle_brand = $vehicle_basic_info["vehicle_brand"];
  $vehicle_type = $vehicle_basic_info["vehicle_type"];
  $vehicle_color = $vehicle_basic_info["vehicle_color"];
  $plate_no = $vehicle_basic_info["plate_no"];
  $vehicle_price = $vehicle_basic_info["vehicle_price"];
  $engine_no = $vehicle_basic_info["engine_no"];
  $chassis_no = $vehicle_basic_info["chassis_no"];
  // --------------------------
  $vehicle_license = $vehicle_attached_info["vehicle_license"];
  $proof_of_ownership = $vehicle_attached_info["proof_of_ownership"];
  $utility_bill = $vehicle_attached_info["utility_bill"];
  $means_of_id = $vehicle_attached_info["means_of_id"];
  $plate_number = $vehicle_attached_info["plate_number"];
  $side_one = $vehicle_attached_info["side_one"];
  $side_two = $vehicle_attached_info["side_two"];
  $side_three = $vehicle_attached_info["side_three"];
  $side_four = $vehicle_attached_info["side_four"];
  // $_SESSION["uid"] = "123456";
  $userid = $_SESSION["uid"];
  $insurance_unique_id = unique_id_generator($userid);
  $basic_info_unique_id = unique_id_generator($vehicle_brand);
  $attached_files_unique_id = unique_id_generator($chassis_no);
  $insurance_type = get_one_row_from_one_table_by_id('loan_category','type', 2, 'date_created');
  
  $insurance_insert_q = "INSERT INTO insurance (unique_id, user_id, insurance_package, insurance_pricing_plan)
                          VALUES ('$insurance_unique_id', '$userid', '$package_id', '$pricing_id')";
  
  if (! mysqli_query($dbc, $insurance_insert_q)){
      return json_encode(["status"=>0, "msg"=>"Cannot save insurance details"]);
  }
  
  $basic_info_insert_q = "INSERT INTO vehicle_insurance_basic_info 
  (unique_id,insurance_id, vehicle_brand, vehicle_type, vehicle_color, plate_number, vehicle_price, engine_number, chassis_number)
  VALUES ('$basic_info_unique_id', '$insurance_unique_id', '$vehicle_brand', '$vehicle_type', '$vehicle_color', '$plate_no', '$vehicle_price', '$engine_no', '$chassis_no')";
  
  if (! mysqli_query($dbc, $basic_info_insert_q)){
      return json_encode(["status"=>0, "msg"=>"Cannot save basic vehicle details"]);
  }

  $attached_files_insert_q = "INSERT INTO vehicle_insurance_ownership_files (unique_id, insurance_id, vehicle_license, proof_of_ownership, utility_bill, means_of_id, vehicle_plate_no, vehicle_picture_side_one, vehicle_picture_side_two, vehicle_picture_side_three, vehicle_picture_side_four)
  VALUES ('$attached_files_unique_id', '$insurance_unique_id', '$vehicle_license', '$proof_of_ownership', '$utility_bill', '$means_of_id', '$plate_number', '$side_one', '$side_two', '$side_three', '$side_four')";

  if (! mysqli_query($dbc, $attached_files_insert_q)){
      return json_encode(["status"=>0, "msg"=>"Cannot save uploaded files"]);
  }
  insert_logs($user_id, $insurance_type['unique_id'], 'Bought Insurance');
  return json_encode(["status"=>1, "msg"=>"Details saved"]);
}

function save_vehicle_details($post_date, $file_arr){

  global $dbc;

  $user_id = $_SESSION['user']['unique_id'];
  /* Valid Extensions */
  $valid_extensions = array("jpg","jpeg","png");

  // Extract submitted data
  $usage = $post_date['usage'];
  $make_of_vehicle = $post_date['make_of_vehicle'];
  $other_make_of_vehicle = $post_date['other_make_of_vehicle'];
  $vehicle_type = $post_date['vehicle_type'];
  $vehicle_reg_no = $post_date['vehicle_reg_no'];
  $vehicle_model = $post_date['vehicle_model'];
  $year_of_make = $post_date['year_of_make'];
  $chassis_number = $post_date['chassis_number'];
  $engine_number = $post_date['engine_number'] == ""?$post_date['chassis_number']:$post_date['engine_number'];
  $risk_location = $post_date['risk_location'];
  $insured_name = $post_date['insured_name'];
  $sum_insured = $post_date['sum_insured'];
  $insured_type = $post_date['insured_type'];
  $policy_start_date = $post_date['policy_start_date'];
  $policy_end_date = $post_date['policy_end_date'];

  $risk_image = $file_arr['risk_image'];
  $identity_image = $file_arr['identity_image'];

  // Get file extension
  $risk_image_type = pathinfo($risk_image["name"],PATHINFO_EXTENSION);
  $identity_image_type = pathinfo($identity_image["name"],PATHINFO_EXTENSION);

  // Validate submitted data

  if(strlen($risk_image["name"]) < 1){
    return json_encode(["status"=>0, "msg"=>"Please upload vehicle image"]);
  }
  if(strlen($identity_image["name"]) < 1){
    return json_encode(["status"=>0, "msg"=>"Please upload your valid ID"]);
  }

  /* Validate file type */
  if( !in_array(strtolower($risk_image_type),$valid_extensions) ) {
    return json_encode(["status"=>0, "msg"=>"Invalid file risk image"]);
  }

  if( !in_array(strtolower($identity_image_type),$valid_extensions) ) {
    return json_encode(["status"=>0, "msg"=>"Invalid file identity image"]);
  }

  // Get base64 image encoded
  $risk_img = file_get_contents($file_arr['risk_image']['tmp_name']);
  $identity_image = file_get_contents($file_arr['identity_image']['tmp_name']);
  
  $risk_img_base64 = base64_encode($risk_img);
  $identity_image_base64 = base64_encode($identity_image);

  // Check if user insurance record exist

  $sql = "SELECT id FROM vehicle_insurance WHERE `user_id` = '$user_id'";

  $exe = mysqli_query($dbc, $sql);

  $row_count = mysqli_num_rows($exe);
  $unique_id = unique_id_generator($chassis_number);

  if($row_count == 0){
    $insert_query = "INSERT INTO vehicle_insurance SET `unique_id`='$unique_id', `user_id`='$user_id', `usage`='$usage', `make_of_vehicle`='$make_of_vehicle', 
    `other_make_of_vehicle`='$other_make_of_vehicle', `vehicle_type`='$vehicle_type', `vehicle_reg_no`='$vehicle_reg_no', `vehicle_model`='$vehicle_model', 
    `year_of_make`='$year_of_make', `risk_location`='$risk_location', `insured_name`='$insured_name', `insured_type`='$insured_type', `sum_insured`='$sum_insured', 
    `engine_number`='$engine_number', `chassis_number`='$chassis_number', `policy_start_date`='$policy_start_date', `policy_end_date`='$policy_end_date', 
    `risk_img_base64`='$risk_img_base64', `identity_img_base64`='$identity_image_base64', `datetime`=now()";

    mysqli_query($dbc, $insert_query) or die(mysqli_error($dbc));

  }else if ($row_count > 0) {
    $update_query = "UPDATE vehicle_insurance SET `usage`='$usage', `make_of_vehicle`='$make_of_vehicle', 
    `other_make_of_vehicle`='$other_make_of_vehicle', `vehicle_type`='$vehicle_type', `vehicle_reg_no`='$vehicle_reg_no', `vehicle_model`='$vehicle_model', 
    `year_of_make`='$year_of_make', `risk_location`='$risk_location', `insured_name`='$insured_name', `insured_type`='$insured_type', `sum_insured`='$sum_insured', 
    `engine_number`='$engine_number', `chassis_number`='$chassis_number', `policy_start_date`='$policy_start_date', `policy_end_date`='$policy_end_date', 
    `risk_img_base64`='$risk_img_base64', `identity_img_base64`='$identity_image_base64', `datetime`=now() WHERE `user_id`='$user_id'";

    mysqli_query($dbc, $update_query) or die(mysqli_error($dbc));

  }

  return json_encode(["status"=>1, "msg"=>"Vehicle details saved successfully"]);
}

function get_banks(){

  global $secret_key;
  $curl = curl_init();

  curl_setopt_array($curl, array(

    CURLOPT_URL => "https://api.paystack.co/bank",

    CURLOPT_RETURNTRANSFER => true,

    CURLOPT_ENCODING => "",

    CURLOPT_MAXREDIRS => 10,

    CURLOPT_TIMEOUT => 30,

    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

    CURLOPT_CUSTOMREQUEST => "GET",

    CURLOPT_HTTPHEADER => array(

      "Authorization: Bearer ".$secret_key,

      "Cache-Control: no-cache",

    ),

  ));

  $response = curl_exec($curl);

  $err = curl_error($curl);

  curl_close($curl);

  

  if ($err) {

    echo "cURL Error #:" . $err;

  } else {

    echo $response;

  }
}

function save_account_details($post){
  global $dbc;
  global $secret_key;

  foreach ($post as $k => $v) {
    if (strlen($v) < 1){
      return json_encode(["status" => 0, "msg"=> "All field are required"]);
    }
  }
  // $_SESSION["uid"] = "123456";
  $userid = $_SESSION["uid"];

  $bank_name = $post["bank_name"];
  $bank_code = $post["bank_code"];
  $account_name = $post["account_name"];
  $account_no = $post["account_no"];

  $unique_id = unique_id_generator($account_no);

  $sql = "SELECT * FROM account_details WHERE account_no = '$account_no'";
  $exe = mysqli_query($dbc, $sql);

  if(mysqli_num_rows($exe) > 0){
    return json_encode(["status" => 0, "msg"=> "Account details exist"]);
  }

  $verify_account_number = validate_acctno($account_no,$bank_code);
  $verify_account_number_decode = json_decode($verify_account_number, true);
  if ($verify_account_number_decode['status'] !== 111){
    return json_encode(["status"=>0, "msg"=>$verify_account_number_decode['msg']]);
  }

  $sql = "INSERT INTO account_details (unique_id, user_id, account_name, account_no, bank_name, bank_code)
          VALUES ('$unique_id', '$userid', '$account_name', '$account_no', '$bank_name', '$bank_code')";
        
  if (! mysqli_query($dbc, $sql)){
    return json_encode(["status" => 0, "msg"=> "Account details not saved"]);
  }
  return json_encode(["status" => 1, "msg"=> "Account details saved"]);

}

function update_existing_row_with_mult_params($table, $unique_id, array $data){
  global $dbc;
  $table = secure_database($table);
  $unique_id = secure_database($unique_id);
  $emptyfound = 0;
  if( is_array($data) && !empty($data) ){
    $sql = "UPDATE `$table` SET ";
    $sql .= "`date_created` = now(), ";
    //$sql .= "`privilege` = '1', ";
      for($i = 0; $i < count($data); $i++){
          $each_data = $data[$i];
          
          if($_POST[$each_data] == ""  ){
            $emptyfound++;
          }

          if($i ==  (count($data) - 1)  ){
                $sql .= " $data[$i] = '$_POST[$each_data]' WHERE `unique_id` = '$unique_id'";
            }else{
              if($data[$i] === "password"){
              $enc_password = md5($_POST[$data[$i]]); 
              $sql .= " $data[$i] = '$enc_password' ,";
              }else{
              $sql .= " $data[$i] = '$_POST[$each_data]' ,";
              } 
          }

      }
    
    if($emptyfound > 0){
        return json_encode(["status"=>"0", "msg"=>"Empty field(s)"]);
    } 
      else{
      //var_dump($sql);
      $query = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
      if($query){
        return json_encode(["status"=>"1", "msg"=>"success"]);
      }else{
        return json_encode(["status"=>"0", "msg"=>"db_error"]);
      }

    }  

  }
  else{
    return json_encode(["status"=>"0", "msg"=>"error"]);
  }
}

function make_full_payment(){
  global $dbc;
  global $secret_key;

  // $_SESSION["uid"] = "123456";

  $userid = $_SESSION["uid"];
  $get_user_email = get_one_row_from_one_table_by_id('users','unique_id',$userid,'registered_on');

  // $sql = "SELECT email FROM users WHERE  unique_id = '$userid'";
  // $email = mysqli_fetch_assoc(mysqli_query($dbc, $sql) or exit(mysqli_error($dbc)));
  
  $user_email = $get_user_email["email"];
  $url = "https://api.paystack.co/transaction/initialize";

  $sql = "SELECT i.insurance_pricing_plan, p.plan_price, i.datetime FROM insurance AS i JOIN insurance_pricing_plans AS p ON i.insurance_pricing_plan = p.unique_id WHERE user_id='$userid' ORDER BY i.id DESC LIMIT 1";
  $exe = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
  
  if (mysqli_num_rows($exe) == 0){
    return json_encode(["status" => 0, "msg"=> "No package price"]);
  }

  $price = mysqli_fetch_assoc($exe);

  $fields = [

    'email' => $user_email,

    'amount' => $price["plan_price"]*100,
    'callback_url' => "test.php"

  ];

  $fields_string = http_build_query($fields);

  //open connection

  $ch = curl_init();

  

  //set the url, number of POST vars, POST data

  curl_setopt($ch,CURLOPT_URL, $url);

  curl_setopt($ch,CURLOPT_POST, true);

  curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

  curl_setopt($ch, CURLOPT_HTTPHEADER, array(

    "Authorization: Bearer ".$secret_key,

    "Cache-Control: no-cache",

  ));

  

  //So that curl_exec returns the contents of the cURL; rather than echoing it

  curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 

  

  //execute post

  $result = curl_exec($ch);

  echo $result;
}

function get_insurance_price(){
  global $dbc;

  // $_SESSION["uid"] = "123456";
  $userid = $_SESSION["uid"];

  $sql = "SELECT i.insurance_pricing_plan, p.plan_price, i.datetime FROM insurance AS i JOIN insurance_pricing_plans AS p ON i.insurance_pricing_plan = p.unique_id WHERE user_id='$userid' ORDER BY i.id DESC LIMIT 1";
  $exe = mysqli_query($dbc, $sql);

  if (mysqli_num_rows($exe) == 0){
    return json_encode(["status" => 0, "msg"=> "No package price"]);
  }

  $price = mysqli_fetch_assoc($exe);
  return json_encode(array("status"=>1, "price"=>number_format($price["plan_price"])));
}


function update_insurance($data){

  global $dbc;

  $payment_duration = $data["paymentPeriod"];
  $userid = $_SESSION["uid"];
  $sql = "SELECT plan_price FROM insurance AS i LEFT JOIN insurance_pricing_plans AS ipp ON i.insurance_pricing_plan = ipp.unique_id WHERE i.user_id='$userid'";
  
  $exe = mysqli_query($dbc, $sql);
  $res = mysqli_fetch_assoc($exe);
  $price = $res["plan_price"];
  $percent_interest = get_rows_from_one_table('insurance_interest_rate','date_created');

  // echo json_encode($percent_interest[0][2]);  
  $insurance_percentage_interest = $percent_interest[0][2];

  $interest_per_month = floatval((($insurance_percentage_interest / 100) * $price));

  $sql = "UPDATE insurance SET insurance_payment_plan = '$payment_duration', monthly_repayment = '$interest_per_month', datetime=now() WHERE user_id = '$userid'";

  if (mysqli_query($dbc, $sql)){
    $res = json_encode(array("status"=>1));
  }else {
    $res = json_encode(array("status"=>0, "msg"=>"Could not update insurance"));
  }
  return $res;
}

function insert_insurance_plan($insurer_id, $plan_name, $plan_rate){
    global $dbc;

    if($insurer_id == null || $plan_id = null || $plan_rate == null){
      return json_encode(array("status"=>0, "msg"=>"All fields are required"));
    }

    $sql = "SELECT * FROM insurance_plans WHERE `plan_name` = '$plan_name' AND `insurer_id` = '$insurer_id'";
    
    $exe = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));

    if (mysqli_num_rows($exe) >= 1){
        return json_encode(array("status"=>0, "msg"=>"Plan already exist"));
    }
    $uniqueid = unique_id_generator($plan_name);

    $sql = "INSERT INTO insurance_plans (`unique_id`, `plan_name`, `insurer_id`, `plan_percentage`, `datetime`)
            VALUES ('$uniqueid', '$plan_name', '$insurer_id', '$plan_rate', now())";
            
    $exe = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
    $res = json_encode(array("status"=>1));
    return $res;
}

// Badmus
function insert_insurance_interest($interest_type, $interest_rate){
  global $dbc;

  if($interest_type == null || $interest_rate == null){
    return json_encode(array("status"=>0, "msg"=>"All fields are required"));
  }

  if (! intval($interest_rate) || ! boolval($interest_rate)){
    return json_encode(array("status"=>0, "msg"=>"Please enter a valid interest rate"));
  }

  $uniqueid = unique_id_generator($interest_rate);

  $sql = "UPDATE insurance_interest_rate SET `unique_id` = '$uniqueid',  `type` = '$interest_type', `interest_rate` = '$interest_rate', `datetime` = now() WHERE `id` = 1";
          
  $exe = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
  $res = json_encode(array("status"=>1));
  return $res;
}
///////// Badmus Functions Here /////////////////////





//////////////COMMONLY USED FUNCTIONS  LIKE get_rows_from_one_table, get_rows_from_one_table_by_id etc should be moved to generic_functions.php

function to_validate_phone_n_email($email,$phone){
  global $dbc;
  //write antoher function that sends an otp to the user phone and email
  //generate an otp: rand(11111,99999)
  //send to user email
  //send to user phone as sms--- intergrating cloudsms---
  //before insert, check if the user email or phone record exist in otp table--if it does, delelte
  //insert that otp into a db table--- otp table-- id, uniqueid, phone, email, otp_no, date_added
  //lead the person to a page where he enters the otp
  //check if what is entered is same with what is in the otp table for that user
  //

}

function delete_a_row($table,$param,$value){
  global $dbc;
  $value = secure_database($value);
  $sql = "DELETE FROM `$table` WHERE `$param` = '$value' ";
  $res = mysqli_query($dbc, $sql);
  if($res){
    return json_encode(["status"=>"1","msg"=>"success"]);
  }else{
    return json_encode(["status"=>"0","msg"=>"error"]);;
  }
} 




///for activation only
function image_upload($file_name, $size, $tmpName,$type){
    global $dbc;
    $upload_path = "uploads/".$file_name;
    $file_extensions = ['jpeg','jpg','png','JPEG','PNG','JPG'];//pdf,PDF
    $file_extension = substr($file_name,strpos($file_name, '.') + 1);
    
    //$file_extension = strtolower(end(explode('.', $file_name)));
    if(!in_array($file_extension, $file_extensions)){
      return json_encode(["status"=>"0","msg"=>"incorrect_format"]);
    }else{
        //2Mb
        if($size > 5000000){
          return json_encode(["status"=>"0","msg"=>"too_big"]);
        }else{
          $upload = move_uploaded_file($tmpName, $upload_path);
          if($upload){
              return json_encode(["status"=>"1","msg"=>$upload_path]);
          }else{
              return json_encode(["status"=>"0","msg"=>"failure"]);  
          }
        }

    }
}



function unique_id_generator($data){
    $data = secure_database($data);
    $newid = md5(uniqid().time().rand(11111,99999).rand(11111,99999).$data);
    return $newid;
}



function get_rows_from_one_table($table,$order_option){
   global $dbc;
 
  $sql = "SELECT * FROM `$table` ORDER BY `$order_option` DESC";
  $query = mysqli_query($dbc, $sql);
  $num = mysqli_num_rows($query);
 if($num > 0){
     while($row = mysqli_fetch_array($query)){
       $row_display[] = $row;
     }
                    
      return $row_display;
    }
    else{
       return null;
    }
}

function get_rows_from_one_table_by_id($table,$param,$value,$order_option){
  global $dbc;
  $table = secure_database($table);
  $sql = "SELECT * FROM `$table` WHERE `$param`='$value' ORDER BY `$order_option` DESC";
  $query = mysqli_query($dbc, $sql);
  $num = mysqli_num_rows($query);
  if($num > 0){
       while($row = mysqli_fetch_array($query)){
          $display[] = $row;
       }              
       return $display;
    }
    else{
       return null;
    }
}

function  get_loan_packages_by_category($table,$param,$value,$order_option){
         global $dbc;
        $table = secure_database($table);
        $sql = "SELECT * FROM `$table` WHERE `$param`='$value' ORDER BY `$order_option` ASC";
        $query = mysqli_query($dbc, $sql);
        $num = mysqli_num_rows($query);
       if($num > 0){
             while($row = mysqli_fetch_array($query)){
                $display[] = $row;
             }              
             return $display;
          }
          else{
             return null;
          }
}

function check_record_by_one_param($table,$param,$value){
  global $dbc;
  $table = secure_database($table);
  $param = secure_database($param);
  $value = secure_database($value);
  $sql = "SELECT * FROM `$table` WHERE `$param` = '$value'" or die(mysqli_error($dbc));
  $query = mysqli_query($dbc, $sql);
  $num = mysqli_num_rows($query);
  if($num > 0 ){
    return true;
  }else{
    return false;
  }
}


function user_signup($fname,$lname,$email,$phone,$password,$cpassword,$refid,$gender){
        global $dbc;
        $table = 'users';
        $refid = secure_database($refid);
        $fname = secure_database($fname);
        $lname = secure_database($lname);
        $email = secure_database($email);
        $phone = secure_database($phone);
        $password = secure_database($password);
        $cpassword = secure_database($cpassword);
        $gender = secure_database($gender);
        $hashpassword = md5($password);
        $img_url = "profiles/default.jpg";
       
        $unique_id = unique_id_generator($fname.$lname);
        $check_exist = check_record_by_one_param($table,'email',$email);


         if($password != $cpassword){
                return json_encode(array( "status"=>103, "msg"=>"Password mismatch" ));
         }

         else if($check_exist){
                return json_encode(array( "status"=>109, "msg"=>"This Email address exists" ));
         }

         else{
                if( $fname == "" || $lname == "" || $email == "" || $phone == "" || $password == "" || $refid == "" || $gender == ""){

                  return json_encode(array( "status"=>101, "msg"=>"Empty field(s) found" ));

                }

                else{


                $sql = "INSERT INTO `users` SET
                `unique_id` = '$unique_id',
                `fname` = '$fname',
                `lname` = '$lname',
                `phone` = '$phone',
                `email` = '$email',
                `password` = '$hashpassword',
                `img_url` = '$img_url',
                `role`= 2,
                `gender`= '$gender',
                `access_status`= 1,
                `referral_id` = '$refid',
                `date_created` = now()
                ";
                $query = mysqli_query($dbc, $sql);
                // or die(mysqli_error($dbc))
                if($query){

                return json_encode(array( "status"=>111, "msg"=>"success"));

                }else{

                return json_encode(array( "status"=>100, "msg"=>"Something went wrong"));

                }


                }

         }


        
}



// function user_login($email,$password){
//    global $dbc;
//    $email = secure_database($email);
//    $password = secure_database($password);
//    $hashpassword = md5($password);

//    $sql = "SELECT * FROM `users` WHERE `email`='$email' AND `password`='$hashpassword' AND `role`=2";
//    $query = mysqli_query($dbc,$sql);
//    $count = mysqli_num_rows($query);
//    if($count === 1){
//       $row = mysqli_fetch_array($query);
//       $fname = $row['fname'];
//       $lname = $row['lname'];
//       $phone = $row['phone'];
//       $email = $row['email'];
//       $unique_id = $row['unique_id'];
//       $access_status = $row['access_status'];

//       if($access_status != 1){
//                 return json_encode(array( "status"=>101, "msg"=>"Sorry, you currently do not have access. Contact Admin!" ));
//       }else{
//                 return json_encode(array( 
//                     "status"=>111, 
//                     "user_id"=>$unique_id, 
//                     "fname"=>$fname, 
//                     "lname"=>$lname, 
//                     "phone"=>$phone, 
//                     "email"=>$email 
//                   )
//                  );

//       }
    
//    }else{
//                 return json_encode(array( "status"=>102, "msg"=>"Wrong username or password!" ));

//    }
 

// }




function admin_login($email,$password){
   global $dbc;
   $email = secure_database($email);
   $password = secure_database($password);
   $hashpassword = md5($password);

   $sql = "SELECT * FROM users WHERE `email`='$email' AND `password`='$hashpassword' AND `role`=1";
   $query = mysqli_query($dbc,$sql);
   $count = mysqli_num_rows($query);
   if($count === 1){
      $row = mysqli_fetch_array($query);
      $fname = $row['fname'];
      $lname = $row['lname'];
      $phone = $row['phone'];
      $email = $row['email'];
      $unique_id = $row['unique_id'];
      $access_status = $row['access_status'];

      if($access_status != 1){
                return json_encode(array( "status"=>101, "msg"=>"Sorry, you currently do not have access. Contact Admin!" ));
      }else{
                return json_encode(array( 
                    "status"=>111, 
                    "user_id"=>$unique_id, 
                    "fname"=>$fname, 
                    "lname"=>$lname, 
                    "phone"=>$phone, 
                    "email"=>$email 
                  )
                 );

      }
    
   }else{
                return json_encode(array( "status"=>102, "msg"=>"Wrong username and password!" ));

   }
 

}


function get_one_row_from_one_table_by_id($table,$param,$value,$order_option){
  global $dbc;
  $table = secure_database($table);
  $sql = "SELECT * FROM `$table` WHERE `$param`='$value' ORDER BY `$order_option` DESC";
  $query = mysqli_query($dbc, $sql);
  $num = mysqli_num_rows($query);
  if($num > 0){
    $row = mysqli_fetch_array($query);              
    return $row;
  }
  else{
    return null;
  }
}

  function get_one_row_from_one_table_by_two_params($table,$param,$value,$param2,$value2,$order_option){
    global $dbc;
    $table = secure_database($table);
    $sql = "SELECT * FROM `$table` WHERE `$param`='$value' AND `$param2`='$value2' ORDER BY `$order_option` DESC";
    $query = mysqli_query($dbc, $sql);
    $num = mysqli_num_rows($query);
   if($num > 0){
         $row = mysqli_fetch_array($query);              
         return $row;
      }
      else{
         return null;
    }
  }


  function get_one_row_from_one_table_by_three_params($table,$param,$value,$param2,$value2,$param3,$value3,$order_option){
         global $dbc;
        $table = secure_database($table);
        $sql = "SELECT * FROM `$table` WHERE `$param`='$value' AND `$param2`='$value2' AND `$param3`='$value3' ORDER BY `$order_option` DESC";
        $query = mysqli_query($dbc, $sql);
        $num = mysqli_num_rows($query);
       if($num > 0){
             $row = mysqli_fetch_array($query);              
             return $row;
          }
          else{
             return null;
        }
    }



function image_upload_other_events($file_name, $size, $tmpName,$type,$event_id,$title){
    global $dbc;
    $title = mysqli_real_escape_string($dbc,$title);
    $event_id = mysqli_real_escape_string($dbc,$event_id);
    $unique_id = unique_id_generator($title.$event_id);
    // $new_file_name = $title."_".$event_id.'_'.$unique_id.'_'.$file_name;
    $new_file_name = $unique_id.'_'.$file_name;
    $upload_path = "events_images/".$new_file_name;
    $file_extensions = ['jpeg','jpg','png','JPEG','PNG','JPG'];//pdf,PDF
    $file_extension = substr($file_name,strpos($file_name, '.') + 1);
    //$file_extension = strtolower(end(explode('.', $file_name)));
    if(!in_array($file_extension, $file_extensions)){
      return json_encode(["status"=>"100","msg"=>"Please upload an image format"]);
    }else{
        //2Mb
        if($size > 2000000){
          return json_encode(["status"=>"103","msg"=>"too_big"]);
        }else{
          $upload = move_uploaded_file($tmpName, $upload_path);
          if($upload){
              return json_encode(["status"=>"111","msg"=>$upload_path]);
          }else{
              return json_encode(["status"=>"109","msg"=>"failure"]);  
          }
        }

    }
}


function get_total_pages($table,$no_per_page){
    global $dbc;
    $no_per_page = secure_database($no_per_page);
    $total_pages_sql = "SELECT COUNT(id) FROM  `$table` ";
    $result = mysqli_query($dbc,$total_pages_sql);
    $total_rows = mysqli_fetch_array($result)[0];
    $total_pages = ceil($total_rows / $no_per_page);
    return $total_pages;
}



function get_rows_from_one_table_with_pagination($table,$offset,$no_per_page){
         global $dbc;
        $table = secure_database($table);
        $offset = secure_database($offset);
        $no_per_page = secure_database($no_per_page);
        $sql = "SELECT * FROM `$table` ORDER BY date_added DESC LIMIT $offset,$no_per_page ";
        $query = mysqli_query($dbc, $sql);
        $num = mysqli_num_rows($query);
       if($num > 0){
            while($row = mysqli_fetch_array($query)){
                $row_display[] = $row;
                }
            return $row_display;
          }
          else{
             return null;
          }
}






function update_by_one_param($table,$param,$value,$condition,$condition_value){
  global $dbc;
  $sql = "UPDATE `$table` SET `$param`='$value' WHERE `$condition`='$condition_value'";
  $qry = mysqli_query($dbc,$sql) or die(mysqli_error($dbc));
  if($qry){
     return true;
  }else{
      return false;
  }
}


/////////MOST IMPORTANT FUNCTIONS START HERE
// function get_record
function count_by_no_param($table){
   global $dbc;

   $sql = "SELECT * FROM `$table`";
   $query = mysqli_query($dbc,$sql);
   $count = mysqli_num_rows($query);
   
   if($count <= 0){
     return "0";      

   }else{
   return $count;      

   }

}


function count_by_one_param($table,$param,$value){
   global $dbc;

   $sql = "SELECT * FROM `$table` WHERE `$param`='$value'";
   $query = mysqli_query($dbc,$sql);
   $count = mysqli_num_rows($query);
   
   if($count <= 0){
     return "0";      

   }else{
   return $count;      

   }

}



////actually means get many rows from one table


function get_rows_from_one_table_group_by($table,$theid){
         global $dbc;
       
        $sql = "SELECT * FROM `$table` GROUP BY `$theid` DESC";
        $query = mysqli_query($dbc, $sql);
        $num = mysqli_num_rows($query);
       if($num > 0){
           while($row = mysqli_fetch_array($query)){
             $row_display[] = $row;
           }
                          
            return $row_display;
          }
          else{
             return null;
          }
}

   


function get_rows_from_one_table_by_two_params($table,$param,$value,$param2,$value2){
         global $dbc;
        $table = secure_database($table);
        $sql = "SELECT * FROM `$table` WHERE `$param`='$value' AND `$param2`='$value2' ORDER BY date_added DESC";
        $query = mysqli_query($dbc, $sql);
        $num = mysqli_num_rows($query);
       if($num > 0){
             while($row = mysqli_fetch_array($query)){
                $display[] = $row;
             }              
             return $display;
          }
          else{
             return null;
          }
}



// function check_user_exists($phone){
//           global $dbc;
          
//           $phone = secure_database($phone);


//           $sql = "SELECT * FROM `user` WHERE `mobile_phone_number`='$phone'";
//           $query = mysqli_query($dbc, $sql);
//           $count = mysqli_num_rows($query);
//           if($count > 0){
            
//             $row = mysqli_fetch_array($query);
//             $first_name = $row['first_name'];
//             $last_name = $row['last_name'];
            
//            return json_encode(
//             array( 

//               "status"=>111, 
//               "mobile_phone_number"=>$phone,
//               "first_name"=>$first_name,
//               "last_name"=>$last_name

//              ));
//           }

//           else{
          
//            return json_encode(array( "status"=>100, "msg"=>"Sorry, your record was not found on our server. Kindly register" ));
          
//           }

// }

// Badmus
function user_exists($email){
    global $dbc;
    
    $sql = "SELECT COUNT(*) AS num FROM `users` WHERE `email`='$email'";
    $query = mysqli_query($dbc, $sql);
    $re = mysqli_fetch_assoc($query);

    if (intval($re['num']) === 1) {
      return true;
    } else {
      return false;
    }
}


// Badmus
function get_coupon_discount($data){
  global $dbc;

  $coupon_code = $data['couponCode'];
	$particulars_id = $data['particularsId'];
	$amount = $data['totalAmount'];

  // $coupon_code, $particulars_id, $amount

  $get_coupon = get_rows_from_table_with_one_params('coupon_code','coupon_code',$coupon_code);
  if (count($get_coupon) == 0) {
    return 0;
  }else {
    if(isset($data['type'])){
      $sql = "UPDATE `renew_vehicle_particulars` SET `coupon_code`='$coupon_code' WHERE `unique_id` = '$particulars_id'";
    }else{
      $sql = "UPDATE `vehicle_permit` SET `coupon_code`='$coupon_code' WHERE `unique_id` = '$particulars_id'";
    }
    $exe_query = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
    $discount = $get_coupon[0]['discount'];
    $total = (intval($amount) - intval($discount));

    return json_encode(array('total'=>$total, 'discount'=>$discount));
  }
}

// Badmus
function calculate_renew_vehicle_particulars($particulars_id){
  global $dbc;
  
  $sql = "SELECT rvp.road_worthiness AS rw, rvp.hackney_permit AS hp, rvp.vehicle_license AS vl, rvp.insurance_type AS insurance_type, vp.license_amount, vp.road_worthiness_amount, vp.third_party_amount, vp.hackney_permit_amount, services.cost FROM `renew_vehicle_particulars` AS `rvp` JOIN `vehicle_particulars` AS `vp` ON rvp.vehicle_type = vp.vehicle_id JOIN `services` ON rvp.type_of_permit = services.unique_id WHERE rvp.unique_id = '$particulars_id'";
  $exe = mysqli_query($dbc, $sql);

  $data = mysqli_fetch_assoc($exe);

  $cost = $data['cost'];

  $road_worthiness = $data['rw'];
  $hackey_permit = $data['hp'];
  $vehicle_license = $data['vl'];

  $road_worthiness_amount = $data['road_worthiness_amount'];
  $hackney_permit_amount = $data['hackney_permit_amount'];
  $third_party_amount = $data['third_party_amount'];
  $vehicle_license_amount = $data['license_amount'];

  $insurance_type = $data['insurance_type'];

  if ($road_worthiness == '1') {
    $cost + $road_worthiness_amount;
  }

  if ($hackey_permit == '1') {
    $cost + $hackney_permit_amount;
  }

  if ($vehicle_license == '1') {
    $cost + $vehicle_license_amount;
  }

  if ($insurance_type == 'third_party_insurance') {
    $insurance_cost = $third_party_amount;
  }
  elseif ($insurance_type == 'no_insurance') {
    $insurance_cost = 0;
  }
  elseif ($insurance_type == 'comprehensive_insurance') {
    $insurance_cost = "";
  }

  $get_delivery_fee = get_one_row_from_one_table('delivery_fee', 'delivery_for', 'renew_vehicle_particulars');
  $delivery_fee = $get_delivery_fee['fee'];

  $total = $cost+$insurance_cost+$delivery_fee;
  $email_delivery_total = $cost+$insurance_cost;

  $arr_data = json_encode(array('cost' => $cost, 'insurance_cost' => $insurance_cost, 'delivery_fee' =>$delivery_fee, 'total' => $total, 'email_delivery_total' => $email_delivery_total));
  return $arr_data;

}

// Badmus
function calculate_vehicle_permit($particulars_record_id){
  
  global $dbc;
  
  $sql = "SELECT services.cost FROM `vehicle_permit` JOIN `services` ON vehicle_permit.permit_type = services.unique_id WHERE vehicle_permit.unique_id = '$particulars_record_id'";
  $exe = mysqli_query($dbc, $sql);

  $data = mysqli_fetch_assoc($exe);

  $cost = $data['cost'];

  $get_delivery_fee = get_one_row_from_one_table('delivery_fee', 'delivery_for', 'renew_vehicle_particulars');
  $delivery_fee = $get_delivery_fee['fee'];

  $total = $cost+$delivery_fee;

  $arr_data = json_encode(array('delivery_fee' => $delivery_fee, 'total' => $total, 'cost' => $cost));

  return $arr_data;
}

// Badmus
function session_referesh(){
  global $dbc;

  $user_id = $_SESSION['user']['unique_id'];

  $sql = "SELECT * FROM `users` WHERE `unique_id` = '$user_id'";

  $exe = mysqli_query($dbc, $sql);

  $user = mysqli_fetch_assoc($exe);

  $_SESSION['user'] = $user;

  return true;
}


function check_record_by_three_params($table,$param,$value,$param2,$value2,$param3,$value3){
    global $dbc;
    $sql = "SELECT id FROM `$table` WHERE `$param`='$value' AND `$param2`='$value2' AND `$param3`='$value3' ";
    $query = mysqli_query($dbc, $sql);
    $count = mysqli_num_rows($query);
    if($count > 0){
      return true; ///exists
    }else{
      return false; //does not exist
    }
    
}  

function check_record_by_four_params($table,$param,$value,$param2,$value2,$param3,$value3,$param4,$value4){
    global $dbc;
    $sql = "SELECT id FROM `$table` WHERE `$param`='$value' AND `$param2`='$value2' AND `$param3`='$value3' AND `$param4`='$value4' ";
    $query = mysqli_query($dbc, $sql);
    $count = mysqli_num_rows($query);
    if($count > 0){
      return true; ///exists
    }else{
      return false; //does not exist
    }
    
}   


 function format_date($date){
        $date = secure_database($date);
        $new_date_format = date('F-d-Y', strtotime($date));

        return $new_date_format;
  }


function secure_database($value){
    global $dbc;
    $new_value = mysqli_real_escape_string($dbc,$value);
    return $new_value;
}

//Tosin's functions

function save_employment_details($user_id, array $employment_array){
  global $dbc;
  $user_id = secure_database($user_id);
  $get_user = get_one_row_from_one_table_by_id('users', 'unique_id', $user_id, 'registered_on');
  $unique_id = unique_id_generator($user_id);
  $employment_status = isset($employment_array['employment_status']) ? $employment_array['employment_status'] : '';
  $name_of_organization = isset($employment_array['name_of_organization'])? $employment_array['name_of_organization'] : '';
  $contact_address_of_organization = isset($employment_array['contact_address_of_organization'])? $employment_array['contact_address_of_organization'] : '';
  $employment_type = isset($employment_array['employment_type'])? $employment_array['employment_type'] : '';
  $job_title = isset($employment_array['job_title'])? $employment_array['job_title'] : '';
  $employment_duration = isset($employment_array['employment_duration'])? $employment_array['employment_duration'] : '';
  $years_of_experience = isset($employment_array['years_of_experience'])? $employment_array['years_of_experience'] : '';
  $industry_type =isset( $employment_array['industry_type'])? $employment_array['industry_type'] : '';
  $monthly_salary = isset($employment_array['monthly_salary'])? $employment_array['monthly_salary'] : '';
  $salary_payday = isset($employment_array['salary_payday'])? $employment_array['salary_payday'] : '';
  $official_email_address = isset($employment_array['official_email_address']) ? $employment_array['official_email_address'] : '';
  $education = isset($employment_array['education'])? $employment_array['education'] : '';
  $home_address = isset($employment_array['home_address'])? $employment_array['home_address'] : '';
  $city = isset($employment_array['city'])? $employment_array['city'] : '';
  $state = isset($employment_array['state'])? $employment_array['state'] : '';
  $residence_type = isset($employment_array['residence_type'])? $employment_array['residence_type'] : '';
  $years_of_stay = isset($employment_array['years_of_stay'])? $employment_array['years_of_stay'] : '';
  $marital_status = isset($employment_array['marital_status'])? $employment_array['marital_status'] : '';
  $name_of_spouse = isset($employment_array['name_of_spouse'])? $employment_array['name_of_spouse'] : '';
  $phone_of_spouse = isset($employment_array['phone_of_spouse'])? $employment_array['phone_of_spouse'] : '';
  $no_of_kids = isset($employment_array['no_of_kids']) ? $employment_array['no_of_kids'] : '';
  $professional_category = isset($employment_array['professional_category'])? $employment_array['professional_category'] : '';
  $professional_subcategory = isset($employment_array['professional_subcategory'])? $employment_array['professional_subcategory'] : '';
  $cac_number = isset($employment_array['cac_number']) ? $employment_array['cac_number'] : '';
  $company_name = isset($employment_array['company_name'])? $employment_array['company_name'] : '';
  $company_address = isset($employment_array['company_address'])? $employment_array['company_address'] : '';
  $monthly_income = isset($employment_array['monthly_income'])? $employment_array['monthly_income'] : '';
  $months_of_stay = isset($employment_array['months_of_stay'])? $employment_array['months_of_stay'] : '';
  $otp = rand(111111, 999999);
  $_SESSION['otp'] = md5($otp);
  $_SESSION['start'] = time();
  $_SESSION['expire'] = $_SESSION['start'] + (60*1);
  $subject = 'Email Verification - Zennal';
  $content = "The token for your transaction is ".$otp."<br> Thanks, Regards";

  if($employment_status == 1 || $employment_status == 4 || $employment_status == 5 || $employment_status == 6){
    if($user_id == '' || $education == '' || $home_address == '' || $city == '' || $state == '' || $residence_type == '' || $years_of_stay == '' || $months_of_stay == '' || $marital_status == '' || $professional_category == '' || $professional_subcategory == '' || $monthly_income == ''){
      return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
    }
  }
  else if ($employment_status == 2 || $employment_status == 3) {
    if($user_id == '' || $unique_id == '' || $employment_status == '' || $name_of_organization == '' || $contact_address_of_organization == '' || $employment_type == '' || $employment_duration == '' || $years_of_experience == '' || $industry_type == '' || $job_title == '' || $monthly_salary == '' || $salary_payday == '' || $official_email_address == ''){
      return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
    }
    else if (!filter_var($official_email_address, FILTER_VALIDATE_EMAIL)) {
      return json_encode(["status"=>"0", "msg"=>"Please provide a valid E-mail Address"]);
    }
  }

  // else{
    $check_row_exist = check_record_by_one_param('user_employment_details', 'user_id', $user_id);
    if($check_row_exist == true){
      $send_mail = email_function($official_email_address, $subject, $content);
      $update_data_sql = "UPDATE `user_employment_details` SET 
      `employment_status`='$employment_status', 
      `name_of_organization`='$name_of_organization', 
      `contact_address_of_organization`='$contact_address_of_organization', 
      `employment_type`='$employment_type', 
      `employment_duration`='$employment_duration', 
      `years_of_experience`='$years_of_experience',
      `industry_type`='$industry_type',
      `job_title`='$job_title',
      `monthly_salary`='$monthly_salary',
      `salary_payday`='$salary_payday', 
      `official_email_address`='$official_email_address',
      `education`='$education',
      `home_address`='$home_address' ,
      `city`='$city' ,
      `state`='$state' ,
      `residence_type`='$residence_type' ,
      `years_of_stay`='$years_of_stay' ,
      `months_of_stay`='$months_of_stay' ,
      `marital_status`='$marital_status' ,
      `name_of_spouse`='$name_of_spouse' ,
      `phone_of_spouse`='$phone_of_spouse' ,
      `no_of_kids`='$no_of_kids' ,
      `professional_category`='$professional_category',
      `professional_subcategory`='$professional_subcategory' ,
      `cac_number`='$cac_number' ,
      `company_name`='$company_name' ,
      `company_address`='$company_address' ,
      `monthly_income`='$monthly_income'    
      WHERE `user_id`='$user_id'";
      $update_data_query = mysqli_query($dbc, $update_data_sql) or die(mysqli_error($dbc));
      if($update_data_query){
        return json_encode(["status"=>"1", "msg"=>"success"]);
      }else{
        return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
      }
    }
    else{
      $send_mail = email_function($official_email_address, $subject, $content);
      $insert_data_sql = "INSERT INTO `user_employment_details` SET 
      `unique_id` = '$unique_id', 
      `user_id` = '$user_id',  
      `employment_status`='$employment_status', 
      `name_of_organization`='$name_of_organization',
      `contact_address_of_organization`='$contact_address_of_organization',
      `employment_type`='$employment_type', 
      `employment_duration`='$employment_duration', 
      `years_of_experience`='$years_of_experience', 
      `industry_type`='$industry_type', 
      `monthly_salary`='$monthly_salary', 
      `salary_payday`='$salary_payday', 
      `official_email_address`='$official_email_address',
      `education`='$education',
      `home_address`='$home_address' ,
      `city`='$city' ,
      `state`='$state' ,
      `residence_type`='$residence_type' ,
      `years_of_stay`='$years_of_stay' ,
      `months_of_stay`='$months_of_stay' ,
      `marital_status`='$marital_status' ,
      `name_of_spouse`='$name_of_spouse' ,
      `phone_of_spouse`='$phone_of_spouse' ,
      `no_of_kids`='$no_of_kids' ,
      `professional_category`='$professional_category',
      `professional_subcategory`='$professional_subcategory' ,
      `cac_number`='$cac_number' ,
      `company_name`='$company_name' ,
      `company_address`='$company_address' ,
      `monthly_income`='$monthly_income', 
      `date_created` = now()";
      $insert_data_query = mysqli_query($dbc, $insert_data_sql) or die(mysqli_error($dbc));
      if($insert_data_query){
        return json_encode(["status"=>"1", "msg"=>"success"]);
      }else{
        return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
      }
    }
  // }
}


// Verify OTP
function verify_otp($otp){
    $now = time();
    if($otp == ''){
      return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
        
    }
    else if($now > $_SESSION['expire']){
        return json_encode(array("status"=>"0", "msg"=>"OTP expired, please request for a new one"));
    }
    else if(! isset($_SESSION["otp"]) || md5($otp) !=  $_SESSION["otp"]){
        return json_encode(array("status"=>"0", "msg"=>"Invalid otp"));
    }
    unset($_SESSION["otp"]);
    return json_encode(array("status"=>"1", "msg"=>"success"));
}



// function verify_otp($user_otp){
//   global $dbc;
//   $user_otp = secure_database($user_otp);
//   $hash_user_otp = md5($user_otp);
//   $stored_otp = $_SESSION['otp'];

//   if($user_otp == ''){
//      return json_encode(["status"=>"1", "msg"=>"Empty field(s) Found"]);
//    }

//   if($hash_user_otp == $stored_otp){
//      return json_encode(["status"=>"1", "msg"=>"success"]);
//      unset($stored_otp);
//    }
//    else{
//      return json_encode(["status"=>"0", "msg"=>"Your otp in incorrect"]);
//    }
// }

function save_financial_record($user_id, array $financial_details_array){
  global $dbc;
  $user_id = secure_database($user_id);
  $unique_id = unique_id_generator($user_id);
  $bank_name = $financial_details_array['bank_name'];
  $account_number = $financial_details_array['account_number'];
  //$account_name = $financial_details_array['account_name'];
  $account_type = $financial_details_array['account_type'];
  $bvn = $financial_details_array['bvn'];
  $existing_loan = $financial_details_array['existing_loan'];
  $monthly_repayment = $financial_details_array['monthly_repayment'];
  $image_path = $financial_details_array['image_path'];
  //$get_user_financial_details = get_one_row_from_one_table_by_id('user_financial_details','user_id', $user_id, 'date_created');
  // $acctno = $financial_details_array['account_number'];
  // $bankcode = $get_user_financial_details['bank_name'];
  //$id_card = $financial_details_array['id_card'];
  //$imgchange = image_upload($file_name, $size, $tmpName, $type);
  //$img_dec = json_decode($imgchange, true);
  if($user_id == '' || $unique_id == '' || $bank_name == '' || $account_number == '' || $account_type == '' || $bvn == '' || $existing_loan == '' || $image_path == ''){
    return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
  }
  else{
    // else{
      // $image_path = $img_dec['msg'];
      $check_row_exist = check_record_by_one_param('user_financial_details', 'user_id', $user_id);
      $verify_account_number = validate_acctno($account_number,$bank_name);
      $verify_account_number_decode = json_decode($verify_account_number, true);
      if ($verify_account_number_decode['status'] !== 111){
        return json_encode(["status"=>"0", "msg"=>$verify_account_number_decode['msg']]);
      }
      else{
        $account_name = $verify_account_number_decode['msg']['account_name'];
      if($check_row_exist == true){
        $update_data_sql = "UPDATE `user_financial_details` SET `bank_name`='$bank_name', `account_number`='$account_number', `account_name`='$account_name', `account_type`='$account_type', `bvn`='$bvn', `existing_loan`='$existing_loan', `monthly_repayment`='$monthly_repayment', `id_card` ='$image_path', `date_created` = now()  WHERE `user_id`='$user_id'";
        $update_data_query = mysqli_query($dbc, $update_data_sql) or die(mysqli_error($dbc));
        if($update_data_query){
          return json_encode(["status"=>"1", "msg"=>"success"]);
        }
        else{
          return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
        }
      }
      else{
        $insert_data_sql = "INSERT INTO `user_financial_details` SET `unique_id` = '$unique_id', `user_id` = '$user_id',  `bank_name`='$bank_name', `account_number`='$account_number', `account_name`='$account_name', `account_type`='$account_type', `bvn`='$bvn', `existing_loan`='$existing_loan', `monthly_repayment`='$monthly_repayment', `id_card` ='$image_path', `date_created` = now()";
        $insert_data_query = mysqli_query($dbc, $insert_data_sql) or die(mysqli_error($dbc));
        if($insert_data_query){
          return json_encode(["status"=>"1", "msg"=>"success"]);
        }
        else{
          return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
        }
      }
    }
    }
  // }
}

function loan_calculations($user_id, $loan_package_id, $loan_id){
  global $dbc;
  $user_id = secure_database($user_id);
  $loan_package_id = secure_database($loan_package_id);
  $loan_id = secure_database($loan_id);
  //$paystack_amount = secure_database($paystack_amount);
  $get_loan_details = get_one_row_from_one_table_by_id('loan_packages','unique_id', $loan_package_id, 'date_created');
  $get_user_loan_details = get_one_row_from_one_table_by_id('user_loan_details','unique_id', $loan_id, 'date_created');
  $get_user_personal_details = get_one_row_from_one_table_by_id('user_employment_details','user_id', $user_id, 'date_created');
  $user_email = $get_user_personal_details['official_email_address'];
  $loan_category_id = $get_loan_details['loan_category'];
  $get_category_details = get_one_row_from_one_table_by_id('loan_category','unique_id', $loan_category_id, 'date_created');
  $no_of_month = $get_loan_details['no_of_month'];
  if($get_category_details['type'] == 1){
    $amount_to_loan = $get_user_loan_details['loan_amount'];
    $paystack_amount = 50;
  }
  else if($get_category_details['type'] == 2){
    $calculate_amount_to_loan = (30 / 100) * $get_user_loan_details['loan_amount'];
    $amount_to_loan = $get_user_loan_details['loan_amount'] - $calculate_amount_to_loan;
    $paystack_amount = $calculate_amount_to_loan;
  }
  $loan_interest_percentage = $get_loan_details['interest_per_month'];
  $interest_per_month = (int) (($loan_interest_percentage /100) * $amount_to_loan);
  $total_interest = $interest_per_month * $no_of_month;
  $total_amount_to_pay = $total_interest + $amount_to_loan;
  $amount_to_pay_per_month = $total_amount_to_pay / $no_of_month;
  //$paystack_amount = $amount_to_pay_per_month * 100;
  $transaction_id = "trans_".uniqid().rand(1000, 9999);
  $callback_url = "http://localhost/zennal/submit_loan_application.php?loan_id=".$loan_package_id."&trans_id=".$transaction_id;
  $curl = curl_init();
  $data = array(
    "email"=> $user_email, 
    "amount" => $paystack_amount * 100,
    "callback_url"=>$callback_url
  );
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS =>json_encode($data),
    CURLOPT_HTTPHEADER => array(
      "Authorization: Bearer sk_test_8d7f0ad794cf2720189772d34c8298d181bacd19",
      "Content-Type: application/json"
    ),
  ));

  $response = curl_exec($curl);

  curl_close($curl);
  $response_decode = json_decode($response, true);
  //$access_code = $response_decode['data']['access_code'];

  if($response_decode['status'] == true){
    $update_data_sql = "UPDATE `user_loan_details` SET `loan_package_id`='$loan_package_id', `loan_category_id`='$loan_category_id', `no_of_repayment_month`='$no_of_month', `interest_per_month`='$interest_per_month', `total_amount_to_repay`='$total_amount_to_pay', `amount_deducted_per_month`='$amount_to_pay_per_month', `transaction_id`='$transaction_id', `date_created` = now()  WHERE `unique_id`='$loan_id'";
    $update_data_query = mysqli_query($dbc, $update_data_sql) or die(mysqli_error($dbc));
    if(mysqli_affected_rows($dbc) ){
      return json_encode(["status"=>"1", "msg"=>"redirect", "data"=>$response_decode['data']['authorization_url']]);
    }else{
      return json_encode(["status"=>"0", "msg"=>"Please try again"]);
    }
  }
  else{
    return json_encode(["status"=>"0", "msg"=>$response_decode['message']]);
  }


}


function verify_transaction($reference){
  $result = array();
    //The parameter after verify/ is the transaction reference to be verified
    $curl = curl_init();
  
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.paystack.co/transaction/verify/".$reference,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "Authorization: Bearer sk_test_8d7f0ad794cf2720189772d34c8298d181bacd19",
      "Cache-Control: no-cache",
    ),
  ));
  
  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);

    if ($response) {
    $result = json_decode($response, true);
    }

    if (array_key_exists('data', $result) && array_key_exists('status', $result['data']) && ($result['data']['status'] === 'success')) {
      return json_encode(["status"=>"1", "msg"=>"transaction_successful", "data"=>$result]);
    //Perform necessary action
    }else{
      return json_encode(["status"=>"0", "msg"=>"transaction_unsuccessful"]);
    }
}


// function submit_loan_application1($user_id, $reference, $transaction_id, $loan_id){
//   global $secret_key;
//    global $dbc;
//   $get_user_financial_details = get_one_row_from_one_table_by_id('user_financial_details','user_id', $user_id, 'date_created');
//   $get_user_loan_details = get_one_row_from_one_table_by_id('user_loan_details','user_id', $user_id, 'date_created');
//   $loan_amount = $get_user_loan_details['loan_amount'];
//   $total_amount_to_repay = $get_user_loan_details['total_amount_to_repay'];
//   $amount_deducted_per_month = $get_user_loan_details['amount_deducted_per_month'];
//   //$loan_amount = $get_user_loan_details['loan_amount'];
//   $purpose_of_loan = $get_user_loan_details['purpose_of_loan'];
//   $acctno = $get_user_financial_details['account_number'];
//   $bankcode = $get_user_financial_details['bank_name'];
//   //print_r( $verify_account_number_decode['msg']['account_name']);
//   //if ($verify_account_number_decode['status'] == "111"){
//     //$account_name = $verify_account_number_decode['msg']['account_name'];
//   $verify_transaction = verify_transaction($reference);
//   $verify_transaction_decode = json_decode($verify_transaction, true);
//   if($verify_transaction_decode['msg'] == "transaction_successful"){
//     $authorization_code =$verify_transaction_decode['data']['data']['authorization']['authorization_code'];
//     $save_authorization_code = update_by_one_param('user_loan_details','authorization_code',$authorization_code,'transaction_id',$transaction_id);
//     $save_transaction_status = update_by_one_param('user_loan_details','transaction_status',1,'transaction_id',$transaction_id);
//     if($save_authorization_code == true){
//       $url = "https://api.paystack.co/transferrecipient";
//       $fields = [
//       'type' => "nuban",
//       'name' => $get_user_financial_details['account_name'],
//       'account_number' => $acctno,
//       'bank_code' => $bankcode,
//       'currency' => "NGN"
//       ];
//       $fields_string = http_build_query($fields);
//       //open connection
//       $ch = curl_init();

//       //set the url, number of POST vars, POST data
//       curl_setopt($ch,CURLOPT_URL, $url);
//       curl_setopt($ch,CURLOPT_POST, true);
//       curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
//       curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//       "Authorization: Bearer $secret_key",
//       "Cache-Control: no-cache",
//       ));

//       //So that curl_exec returns the contents of the cURL; rather than echoing it
//       curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 

//       //execute post
//       $result = curl_exec($ch);
//       $result_decode = json_decode($result, true);
      
//       if($result_decode['status'] == true){
//         $recipient_code = $result_decode['data']['recipient_code'];
//         $url = "https://api.paystack.co/transfer";
//         $fields = [
//           'source' => "balance",
//           'amount' => $loan_amount,
//           'recipient' => $recipient_code,
//           'reason' => $purpose_of_loan
//         ];
//         $fields_string = http_build_query($fields);
//         //open connection
//         $ch = curl_init();
        
//         //set the url, number of POST vars, POST data
//         curl_setopt($ch,CURLOPT_URL, $url);
//         curl_setopt($ch,CURLOPT_POST, true);
//         curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
//         curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//           "Authorization: Bearer $secret_key",
//           "Cache-Control: no-cache",
//         ));
        
//         //So that curl_exec returns the contents of the cURL; rather than echoing it
//         curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
        
//         //execute post
//         $result2 = curl_exec($ch);
//         $result2_decode = json_decode($result2, true);
//         if($result2_decode['status'] == true){
//           $unique_id = unique_id_generator($user_id.$loan_id);
//           $insert_repayment = "INSERT INTO `repayment_tbl` SET `unique_id`='$unique_id', `user_id`='$user_id', `loan_id`='$loan_id', `total_amount_to_pay`='$total_amount_to_repay', `amount_deducted_per_month`='$amount_deducted_per_month', `balance`='$total_amount_to_pay', `date_created` = now()";
//           $insert_repayment_query = mysqli_query($dbc, $insert_repayment);
//           insert_logs($user_id, $get_user_loan_details['loan_category_id'], 'Applied for loan');
//           if($insert_repayment_query){
//             return json_encode(["status"=>"1", "msg"=>$result2_decode['message']]);
//           }
//         }
//         else{
//           return json_encode(["status"=>"0", "msg"=>$result2_decode['message']]);
//         }
//       }
//       else{
//         return json_encode(["status"=>"0", "msg"=>$result_decode['message']]);
//       }
//     }
//     else{
//       return json_encode(["status"=>"0", "msg"=>"Please Try again"]);
//     }
    
//   }
//   else{
//     return json_encode(["status"=>"0", "msg"=>"Your previous payment was unsuccessful, please try again later"]);
//   }
// }


function submit_loan_application($user_approved_amount, $loan_id){
  global $dbc;
  $user_approved_amount = secure_database($user_approved_amount);
  $loan_id = secure_database($loan_id);
  $get_loan_details = get_one_row_from_one_table_by_id('personal_loan_application', 'unique_id', $loan_id, 'date_created');
  $admin_selection_amount_min = $get_loan_details['admin_selection_amount_min'];
  $admin_selection_amount_max = $get_loan_details['admin_selection_amount_max'];
 if($user_approved_amount == '' || $loan_id == ''){
    return json_encode(["status"=>"0", "msg"=>"Empty field(s) found"]);
 }
  else if($user_approved_amount < $admin_selection_amount_min || $user_approved_amount > $admin_selection_amount_max){
    return json_encode(["status"=>"0", "msg"=>"Please enter amount between the specified range"]);
  }
 else{
  $loan_interest = $get_loan_details['loan_interest'];
  $interest_rate = ($loan_interest / 100) * $user_approved_amount;
  $amount_to_repay = $user_approved_amount + $interest_rate;
  $update_data_sql = "UPDATE `personal_loan_application` SET `user_approved_amount`='$user_approved_amount', `amount_to_repay`='$amount_to_repay', `approval_date` = now(), `approval_status` = 3  WHERE `unique_id`='$loan_id'";
  $update_data_query = mysqli_query($dbc, $update_data_sql) or mysqli_error($dbc);
  if($update_data_query){
    // $flutter_transfer = flutterwave_transfer($loan_id, $get_loan_details['user_id'], $user_approved_amount);
    return json_encode(["status"=>"1", "msg"=>"success", "data"=>$amount_to_repay]);
  }else{
    return json_encode(["status"=>"0", "msg"=>"Please try again"]);
  }
}
}


function submit_asset_finance($user_approved_repayment_month, $loan_id){
  global $dbc;
  $user_approved_repayment_month = secure_database($user_approved_repayment_month);
  $loan_id = secure_database($loan_id);
  $get_loan_details = get_one_row_from_one_table_by_id('asset_finance_application', 'unique_id', $loan_id, 'date_created');
  $get_product = get_one_row_from_one_table_by_id('products', 'unique_id', $get_loan_details['product_id'], 'date_created');
  $min_repayment_month = $get_loan_details['minimum_repayment_month'];
  $max_repayment_month = $get_loan_details['maximum_repayment_month'];
  if($user_approved_repayment_month == '' || $loan_id == ''){
    return json_encode(["status"=>"0", "msg"=>"Empty field(s) found"]);
  }
  else if($user_approved_repayment_month < $min_repayment_month || $user_approved_repayment_month > $max_repayment_month){
    return json_encode(["status"=>"0", "msg"=>"Please enter repayment month between the specified range"]);
  }else{
    $loan_interest = $get_loan_details['loan_interest'];
    $user_approved_equity_con = $get_loan_details['user_approved_equity_con'];
    $calculate_amount_to_loan = ($user_approved_equity_con / 100) * $get_product['price'];
    $amount_to_loan = (int) $get_product['price'] - $calculate_amount_to_loan;
    $loan_interest_percentage = $get_loan_details['loan_interest'];
    $interest_per_month = (int) (($loan_interest_percentage /100) * $amount_to_loan);
    $total_interest = (int) $interest_per_month * $user_approved_repayment_month;
    $total_amount_to_pay = $total_interest + $amount_to_loan;
    $amount_to_pay_per_month = $total_amount_to_pay / $user_approved_repayment_month;
    $update_data_sql = "UPDATE `asset_finance_application` SET `user_approved_repayment_month`='$user_approved_repayment_month', `amount_to_repay`='$total_amount_to_pay', `interest_amount_per_month`='$interest_per_month', `amount_deducted_per_month`='$amount_to_pay_per_month'  WHERE `unique_id`='$loan_id'";
    $update_data_query = mysqli_query($dbc, $update_data_sql) or mysqli_error($dbc);
    //var_dump($update_data_query);
    if(mysqli_affected_rows($dbc)){
      return json_encode(["status"=>"1", "msg"=>"success"]);
    }else{
      return json_encode(["status"=>"0", "msg"=>"Please try again"]);
    }
  }
}


//runs as cron everyday
function charge_user(){
  global $dbc;
  global $secret_key;
  $get_loans = get_rows_from_one_table('user_loan_details','date_created');
  foreach ($get_loans as $loan_application) {
    $get_user_details = get_one_row_from_one_table_by_id('user_employment_details','user_id', $loan_application['user_id'], 'date_created');
    $loan_id = $loan_application['unique_id'];
    $get_repayment_details = get_one_row_from_one_table_by_id('repayment_tbl','loan_id', $loan_id, 'date_created');
    $amount_paid_so_far = $get_repayment_details['amount_paid_so_far'] + $loan_application['amount_deducted_per_month'];
    $balance = $get_repayment_details['total_amount_to_pay'] - $amount_paid_so_far;
    if($loan_application['no_of_repayment_month'] <= $loan_application['current_repayment_month']){
      echo "user has finished paying<br>";
      $update_current_repayment_month = update_by_one_param('user_loan_details','loan_status',0,'unique_id', $loan_id);
      continue;
    }
    //else{
      $date_of_disbursal = date_create($loan_application['date_created']);
      $today = date("Y-m-d");
      $next_date = date_add($date_of_disbursal, date_interval_create_from_date_string("30 days"));
      if($today == date_format($next_date,"Y-m-d")){
        $url = "https://api.paystack.co/transaction/charge_authorization";
        $fields = [
          'authorization_code' => $loan_application['authorization_code'],
          'email' => $get_user_details['official_email_address'],
          'amount' => $loan_application['amount_deducted_per_month']*100
        ];
        //print_r($fields);
        $fields_string = http_build_query($fields);
        //open connection
        $ch = curl_init();
        
        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Authorization: Bearer $secret_key",
          "Cache-Control: no-cache",
        ));
        
        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
        
        //execute post
        $result = curl_exec($ch);
        $result_decode = json_decode($result, true);
        if($result_decode['status'] == true){
          $current_repayment_month = $loan_application['current_repayment_month'] + 1;
          $update_current_repayment_month = update_by_one_param('user_loan_details','current_repayment_month',$current_repayment_month,'authorization_code', $loan_application['authorization_code']);
          $update_repayment_tbl = "UPDATE `repayment_tbl` SET `current_repayment_month`='$current_repayment_month', `amount_paid_so_far`='$amount_paid_so_far', `balance`='$balance', `date_created` = now()  WHERE `loan_id`='$loan_id'";
          $update_repayment_tbl_query = mysqli_query($dbc, $update_repayment_tbl) or die(mysqli_error());
          if(mysqli_affected_rows($dbc)){
            echo "success";
          }else{
            echo "error";
          }
          //echo "success";
        }else{
          echo $result_decode['message'];
        }
        //echo $result;
      }
    //}
  }
}


function submit_loan_purpose($user_id, $loan_amount, $loan_purpose, $bank_statement){
  global $dbc;
  $user_id = secure_database($user_id);
  $loan_amount = secure_database($loan_amount);
  $loan_purpose = secure_database($loan_purpose);
  $bank_statement = secure_database($bank_statement);
  $unique_id = unique_id_generator($user_id);
  $get_loan_category = get_one_row_from_one_table_by_id('loan_category','type', 1 ,'date_created');
  $get_loan_package = get_one_row_from_one_table_by_id('loan_packages','loan_category', $get_loan_category['unique_id'], 'date_created');
  $loan_interest = $get_loan_package['interest_per_month'];
  if($user_id == '' || $unique_id == '' || $loan_purpose == '' || $loan_amount == ''){
    return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
  }
  else{
    $insert_data_sql = "INSERT INTO `personal_loan_application` SET `unique_id` = '$unique_id', `user_id` = '$user_id',  `user_selection_amount`='$loan_amount', `loan_purpose`='$loan_purpose', `loan_interest`='$loan_interest', `bank_statement`='$bank_statement', `date_created` = now()";
    $insert_data_query = mysqli_query($dbc, $insert_data_sql) or die(mysqli_error($dbc));
    if($insert_data_query){
      $get_last_id = mysqli_query($dbc, "SELECT MAX(ID) AS last_id FROM okra_test");
      while ($row = mysqli_fetch_array($get_last_id)){
          $last_id = $row['last_id'];
      }
      $update_data = mysqli_query($dbc, "UPDATE `okra_test` SET `loan_id` = '$unique_id', `status` = 1 WHERE `id` = '$last_id' AND `status` = 0") or die(mysqli_error($dbc));
      return json_encode(["status"=>"1", "msg"=>"success"]);
    }else{
      return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
    }
  }
}

function submit_asset_loan_purpose($user_id, $loan_purpose, $product_id, $repayment_id, $bank_statement){
  global $dbc;
  $user_id = secure_database($user_id);
  $product_id = secure_database($product_id);
  $loan_purpose = secure_database($loan_purpose);
  $unique_id = unique_id_generator($user_id);
  $get_product = get_one_row_from_one_table_by_id('products','unique_id', $product_id ,'date_created');
  $get_repayment = get_one_row_from_one_table_by_id('loan_packages','unique_id', $repayment_id, 'date_created');
  $vendor_id = $get_product['vendor_id'];
  $loan_interest = $get_repayment['interest_per_month'];
  $user_approved_equity_con = $get_repayment['equity_contribution'];
  $user_approved_repayment_month = $get_repayment['no_of_month'];
  if($user_id == '' || $unique_id == '' || $loan_purpose == '' || $product_id == ''){
    return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
  }
  else{
    $insert_data_sql = "INSERT INTO `asset_finance_application` SET `unique_id` = '$unique_id', `user_id` = '$user_id',  `product_id`='$product_id', `loan_purpose`='$loan_purpose', `vendor_id`='$vendor_id', `repayment_id`='$repayment_id', `loan_interest`='$loan_interest', `user_approved_equity_con`='$user_approved_equity_con', `user_approved_repayment_month`='$user_approved_repayment_month', `bank_statement`='$bank_statement', `date_created` = now()";
    $insert_data_query = mysqli_query($dbc, $insert_data_sql) or die(mysqli_error($dbc));
    if($insert_data_query){
      return json_encode(["status"=>"1", "msg"=>"success"]);
    }else{
      return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
    }
  }
}


function insert_logs($user_id, $type, $description){
  global $dbc;
  $user_id = secure_database($user_id);
  $description = secure_database($description);
  $type = secure_database($type);
  $data = $user_id.$description.$type;
  $unique_id = unique_id_generator($data);

  if($user_id == '' || $description == '' || $type == ''){
    return  json_encode(["status"=>"0", "msg"=>"empty_fields"]);
  }
  else{
    $insert_log_sql = "INSERT INTO `user_logs_tbl` SET `unique_id` = '$unique_id', `type` = '$type', `description` = '$description', `user_id`='$user_id', `date_created` = now()";
         $insert_log_query = mysqli_query($dbc, $insert_log_sql) or die(mysqli_error($dbc));
         if($insert_log_query){
            return  json_encode(["status"=>"1", "msg"=>"success"]);
         }else{
            return  json_encode(["status"=>"0", "msg"=>"insertion_error"]);

         } 
  }

}

function get_user_recent_activities($user_id){
  global $dbc;
  $sql = "SELECT * FROM `user_logs_tbl` WHERE `user_id`='$user_id' ORDER BY `date_created` DESC LIMIT 5";
  $query = mysqli_query($dbc, $sql);
  $num = mysqli_num_rows($query);
  if($num > 0){
   while($row = mysqli_fetch_array($query)){
     $row_display[] = $row;
   }
                  
    return $row_display;
  }
  else{
    return null;
  }
}

function admin_login_user($details){
  global $dbc;
  $email = secure_database($details["email"]);
  $password = secure_database($details["password"]);
  $hashpassword = md5($password);

  $sql = "SELECT * FROM `admin` WHERE `email`='$email' AND `password`='$hashpassword'";
  $query = mysqli_query($dbc,$sql);
  $count = mysqli_num_rows($query);

  if($count === 0){
    return json_encode(array("status"=>0, "msg"=>"Invalid login details"));
  }
  if($count === 1){
  $row = mysqli_fetch_array($query);
    $_SESSION['admin_id'] = $row["unique_id"];
    return json_encode(array("status"=>1, "msg"=>"Success"));
  }
}

function get_total_loan($user_id){
  global $dbc;
  // $loan_type = secure_database($loan_type);
  // $get_loan_category = get_one_row_from_one_table_by_id('loan_category','type', $loan_type, 'date_created');
  // $loan_category =$get_loan_category['unique_id'];
  $get_total_loan = "SELECT SUM(loan_amount) as `amount` FROM `user_loan_details` WHERE `user_id` = '$user_id'";
  // var_dump($get_total_loan);
  $get_total_loan_query = mysqli_query($dbc, $get_total_loan) or die(mysqli_error($dbc));
  $row = mysqli_fetch_array($get_total_loan_query);
  $sum = $row['amount'];
  return $sum;
}

function set_loan_packages($no_of_month, $loan_category, $interest_per_month, $equity_contribution, $created_by){
  global $dbc;
  $no_of_month = secure_database($no_of_month);
  $loan_category = secure_database($loan_category);
  $interest_per_month = secure_database($interest_per_month);
  $equity_contribution = secure_database($equity_contribution);
  $created_by = secure_database($created_by);
  $unique_id = unique_id_generator($loan_category. $created_by);
  if($no_of_month == '' || $loan_category == '' || $interest_per_month == '' || $created_by == ''){
    return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
  }
  else{
    $insert_data_sql = "INSERT INTO `loan_packages` SET `unique_id` = '$unique_id', `no_of_month` = '$no_of_month',  `loan_category`='$loan_category',`equity_contribution` = '$equity_contribution', `interest_per_month`='$interest_per_month', `created_by`='$created_by', `date_created` = now()";
    $insert_data_query = mysqli_query($dbc, $insert_data_sql);
    if($insert_data_query){
      return json_encode(["status"=>"1", "msg"=>"success"]);
    }else{
      return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
    }
  }
}

function add_vendor($name, $description, $website_url, $created_by){
  global $dbc;
  $name = secure_database($name);
  $description = secure_database($description);
  $website_url = secure_database($website_url);
  $created_by = secure_database($created_by);
  $unique_id = unique_id_generator($description. $created_by);
  $check_row_exist = check_record_by_one_param('vendors', 'name', $name);
  if($name == '' || $description == '' || $website_url == '' || $created_by == ''){
    return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
  }
  else if($check_row_exist){
    return json_encode(["status"=>"0", "msg"=>"Vendor already exists"]);
  }
  else if (!preg_match("/\b(?:(?:https?|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website_url)){
    return json_encode(["status"=>"0", "msg"=>"Incorrect website format"]);
  }
  else{
    $insert_data_sql = "INSERT INTO `vendors` SET `unique_id` = '$unique_id', `name` = '$name',  `description`='$description', `website_url`='$website_url', `created_by`='$created_by', `date_created` = now()";
    $insert_data_query = mysqli_query($dbc, $insert_data_sql);
    if($insert_data_query){
      return json_encode(["status"=>"1", "msg"=>"success"]);
    }else{
      return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
    }
  }
}

function add_product($vendor_id, $product_name, $description, $price, $image, $created_by){
  global $dbc;
  $vendor_id = secure_database($vendor_id);
  $product_name = secure_database($product_name);
  $description = secure_database($description);
  $price = secure_database($price);
  $image = secure_database($image);
  $created_by = secure_database($created_by);
  $unique_id = unique_id_generator($vendor_id. $product_name);
  if($vendor_id == '' || $product_name == '' || $description == '' || $price == '' || $image == '' || $created_by == ''){
    return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
  }
  else{
    $insert_data_sql = "INSERT INTO `products` SET `unique_id` = '$unique_id', `vendor_id` = '$vendor_id',  `product_name`='$product_name', `description`='$description', `price`='$price', `image`='$image', `created_by`='$created_by', `date_created` = now()";
    $insert_data_query = mysqli_query($dbc, $insert_data_sql);
    if($insert_data_query){
      return json_encode(["status"=>"1", "msg"=>"success"]);
    }else{
      return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
    }
  }
}

function insert_into_db($table,$data,$param,$validate_value){
  global $dbc;
  $validate_value = secure_database($validate_value);
  $param = secure_database($param);
  $table = secure_database($table);
  $unique_id = unique_id_generator(md5(uniqid()));
  $emptyfound = 0;
  $check = check_record_by_one_param($table,$param,$validate_value);
  if($check === true){
    return  json_encode(["status"=>"0", "msg"=>"Record Exists"]);
  }else{

      if( is_array($data) && !empty($data) ){
     $sql = "INSERT INTO `$table` SET  `unique_id` = '$unique_id',";
     $sql .= "`date_created` = now(), ";
     //$sql .= "`privilege` = '1', ";
        for($i = 0; $i < count($data); $i++){
            $each_data = $data[$i];
            
            if($_POST[$each_data] == ""  ){
              $emptyfound++;
            }


            if($i ==  (count($data) - 1)  ){
                 $sql .= " $data[$i] = '$_POST[$each_data]' ";
              }else{
                if($data[$i] === "password"){
                $enc_password = md5($_POST[$data[$i]]); 
                $sql .= " $data[$i] = '$enc_password' ,";
                }else{
                $sql .= " $data[$i] = '$_POST[$each_data]' ,";
                } 
            }

        }
    
      
      if($emptyfound > 0){
          return json_encode(["status"=>"0", "msg"=>"Empty Fields"]);
      } 
       else{
        $query = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
        if($query){
          return json_encode(["status"=>"1", "msg"=>"success"]);
        }else{
          return json_encode(["status"=>"0", "msg"=>"db_error"]);
        }

      }  


    }
    else{
      return json_encode(["status"=>"0", "msg"=>"error"]);
    }

  } 

}


function update_data($table, $data,$conditional_param,$conditional_value){
  global $dbc;
  $conditional_value = secure_database($conditional_value);

  if( is_array($data) && !empty($data) ){
   $sql = "UPDATE `$table` SET ";
      for($i = 0; $i < count($data); $i++){
          $each_data = $data[$i];
          if($i ==  (count($data) - 1)  ){
            $sql .= " $data[$i] = '$_POST[$each_data]' ";
          }else{
            $sql .= " $data[$i] = '$_POST[$each_data]' ,";
          }

      }

      $sql .= "WHERE `$conditional_param` = '$conditional_value'";
  
    $query = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
    if($query){
       return json_encode(["status"=>"1", "msg"=>"success"]);
    }else{
      return json_encode(["status"=>"0", "msg"=>"db_error"]);
    }
  }
  else{
    return json_encode(["status"=>"0", "msg"=>"error"]);
  }
}

function update_loan_packages($no_of_month, $loan_category, $interest_per_month, $unique_id){
  global $dbc;
  $no_of_month = secure_database($no_of_month);
  $loan_category = secure_database($loan_category);
  $interest_per_month = secure_database($interest_per_month);
  $unique_id = secure_database($unique_id);
  if($no_of_month == '' || $loan_category == '' || $interest_per_month == ''){
    return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
  }
  else{
    $update_data_sql = "UPDATE `loan_packages` SET `no_of_month` = '$no_of_month',  `loan_category`='$loan_category', `interest_per_month`='$interest_per_month', `date_created` = now() WHERE `unique_id` = '$unique_id'";
    $update_data_query = mysqli_query($dbc, $update_data_sql) or die(mysqli_error($dbc));
    if(mysqli_affected_rows($dbc)){
      return json_encode(["status"=>"1", "msg"=>"success"]);
    }else{
      return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
    }
  }
}


function upload_document($document_name, $document_url, $admin_id){
  global $dbc;
  $document_name = secure_database($document_name);
  $document_url = secure_database($document_url);
  $admin_id = secure_database($admin_id);
  $unique_id = unique_id_generator($document_name.$document_url);
  if($document_name == '' || $document_url == '' || $admin_id == ''){
    return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
  }
  else{
    $insert_data_sql = "INSERT INTO `admin_document` SET `document_name` = '$document_name',  `document_url`='$document_url', `admin_id`='$admin_id', `date_created` = now(), `unique_id` = '$unique_id'";
    $insert_data_query = mysqli_query($dbc, $insert_data_sql) or die(mysqli_error($dbc));
    if($insert_data_query){
      return json_encode(["status"=>"1", "msg"=>"success"]);
    }else{
      return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
    }
  }
}


function flutterwave_checkout($user_id, $amount, $redirect_url){
  $get_user_details = get_one_row_from_one_table_by_id('users', 'unique_id', $user_id, 'registered_on');
  $user_email = $get_user_details['email'];
  $phone = $get_user_details['phone'];
  $name = $get_user_details['first_name'].' '.$get_user_details['last_name'].' '.$get_user_details['other_names'];
  $transaction_ref = md5(uniqid().rand(1000, 9999));
  $curl = curl_init();
  
  $data = [
    "tx_ref"=>$transaction_ref,
    "amount"=>$amount,
    "currency"=>"NGN",
    "redirect_url"=> $redirect_url,
    "payment_options"=>"card",
    "customer"=>[
      "email"=>$user_email,
      "phonenumber"=>$phone,
      "name"=>$name
    ]
  ];

  curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.flutterwave.com/v3/payments",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>json_encode($data),
  CURLOPT_HTTPHEADER => array(
  "Authorization: Bearer FLWSECK_TEST-0c1450bff1fe587e3164a42ef28e90be-X",
  "Content-Type: application/json"
  ),
  ));

  $response = curl_exec($curl);

  curl_close($curl);
  //echo $response;
  $response_decode = json_decode($response, true);
  if($response_decode['status'] == 'success'){
    return json_encode(["status"=> "1", "msg"=>$response_decode['data']['link']]);
  }
  else{
    return json_encode(["status"=> "0", "msg"=>"Please try again"]);
  }
}

function generate_bank_statement($user_id, $amount){
  // $get_user_details = get_one_row_from_one_table_by_id('users', 'unique_id', $user_id, 'registered_on');
  // $user_email = $get_user_details['email'];
  // $phone = $get_user_details['phone'];
  // $name = $get_user_details['first_name'].' '.$get_user_details['last_name'].' '.$get_user_details['other_names'];
  // $transaction_ref = md5(uniqid().rand(1000, 9999));
  $get_unused_payment = get_rows_from_one_table_by_id('online_bank_statement', 'user_id',$user_id, 'date_created');
  // $redirect_url = "http://zennal.staging.cloudware.ng/online_generation_callback.php";
  $redirect_url = 'http:localhost/new_zennal/online_generation_callback.php';
  if($get_unused_payment != null){
    foreach ($get_unused_payment as $value) {
      if($value['use_status'] == 1){
        $checkout = flutterwave_checkout($user_id, $amount, $redirect_url);
        $checkout_decode = json_decode($checkout, true);
        $checkout = $checkout_decode['msg'];
      }
      else{
        return json_encode(["status"=> "1", "msg"=>'loan_purpose.php?message=transaction_successful&transaction_id='.$value['transaction_id']]);
        //return '<meta http-equiv="refresh" content="0; url=https://okra.com" />';
      }
    }
    echo $checkout;
  }
  else{
    return json_encode(["status"=> "1", "msg"=>'loan_purpose.php?message=transaction_successful&transaction_id='.$value['transaction_id']]);
  }

}

function generate_bank_statement2($user_id, $amount, $id){
  // $get_user_details = get_one_row_from_one_table_by_id('users', 'unique_id', $user_id, 'registered_on');
  // $user_email = $get_user_details['email'];
  // $phone = $get_user_details['phone'];
  // $name = $get_user_details['first_name'].' '.$get_user_details['last_name'].' '.$get_user_details['other_names'];
  // $transaction_ref = md5(uniqid().rand(1000, 9999));
  $get_unused_payment = get_rows_from_one_table_by_id('online_bank_statement', 'user_id',$user_id, 'date_created');
  $redirect_url = "http://zennal.staging.cloudware.ng/online_generation_callback2.php?id=".$id;
  if($get_unused_payment != null){
    foreach ($get_unused_payment as $value) {
      if($value['use_status'] == 1){
        $checkout = flutterwave_checkout($user_id, $amount, $redirect_url);
        $checkout_decode = json_decode($checkout, true);
        $checkout = $checkout_decode['msg'];
      }
      else{
        return json_encode(["status"=> "1", "msg"=>'asset_loan_purpose.php?id='.$id.'&message=transaction_successful&transaction_id='.$value['transaction_id']]);
        //return '<meta http-equiv="refresh" content="0; url=https://okra.com" />';
      }
    }
    echo $checkout;
  }
  else{
    return json_encode(["status"=> "1", "msg"=>'asset_loan_purpose.php?id='.$id.'&message=transaction_successful&transaction_id='.$value['transaction_id']]);
  }

}

function flutterwave_transfer($loan_id,$user_id, $amount){
  $loan_id = secure_database($loan_id);
  //$table = secure_database($table);
  $user_id = secure_database($user_id);
  $url = 'https://api.flutterwave.com/v3/transfers';
  // Collection object
  $get_bank_details = get_one_row_from_one_table_by_id('user_financial_details', 'user_id', $user_id, 'date_created');
  //$get_loan_details = get_one_row_from_one_table_by_id($table, 'unique_id', $loan_id, 'date_created');
  $bank_code = $get_bank_details['bank_name'];
  $account_no = $get_bank_details['account_number'];
  //$amount = $get_loan_details['user_approved_amount'];
  $currency = 'NGN';
  $fullname = $get_bank_details['account_name'];
  $reference = md5(uniqid(rand(0000, 9999)));
  $data = [
    'account_bank' => $bank_code,
    'account_number' => $account_no,
    'amount' => $amount,
    'narration' => 'Zennal loan disbursement',
    'currency' => $currency,
    'debit_currency' => $currency,
    'reference'=> $reference
  ];
  
  // Initializes a new cURL session
  $curl = curl_init($url);
  
  // Set the CURLOPT_RETURNTRANSFER option to true
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  
  // Set the CURLOPT_POST option to true for POST request
  curl_setopt($curl, CURLOPT_POST, true);
  
  // Set the request data as JSON using json_encode function
  curl_setopt($curl, CURLOPT_POSTFIELDS,  json_encode($data));
  
  // Set custom headers for RapidAPI Auth and Content-Type header
  curl_setopt($curl, CURLOPT_HTTPHEADER, [
  'Authorization: Bearer FLWSECK_TEST-0c1450bff1fe587e3164a42ef28e90be-X',
  'Content-Type: application/json'
  ]);
  
  // Execute cURL request with all previous settings
 $response = curl_exec($curl);
  
  // Close cURL session
  curl_close($curl);
  return $response;

 $response_dec = json_decode($response,true);
 $response_status = $response_dec['status'];
 $response_message = $response_dec['message'];
 $transfer_id = $response_dec['data']['id'];
}

function flutterwave_transfer2($request_id, $user_id, $amount){
  $user_id = secure_database($user_id);
  $url = 'https://api.flutterwave.com/v3/transfers';
  $get_bank_details = get_one_row_from_one_table_by_id('user_financial_details', 'user_id', $user_id, 'date_created');
  $bank_code = $get_bank_details['bank_name'];
  $account_no = $get_bank_details['account_number'];
  $currency = 'NGN';
  $fullname = $get_bank_details['account_name'];
  $reference = md5(uniqid(rand(0000, 9999)));
  $data = [
    'account_bank' => $bank_code,
    'account_number' => $account_no,
    'amount' => $amount,
    'narration' => 'Zennal Wallet Withdrawal',
    'currency' => $currency,
    'debit_currency' => $currency,
    'reference'=> $reference,
    'callback_url' => "http://localhost/zennal/admin/ajax_admin/withdrawal_callback.php?request_id=".$request_id
  ];
  
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS,  json_encode($data));
  curl_setopt($curl, CURLOPT_HTTPHEADER, [
  'Authorization: Bearer FLWSECK_TEST-0c1450bff1fe587e3164a42ef28e90be-X',
  'Content-Type: application/json'
  ]);
  return $response = curl_exec($curl);
  curl_close($curl);
  // $response_dec = json_decode($response,true);
  // $response_status = $response_dec['status'];
  // $response_message = $response_dec['message'];
  // $transfer_id = $response_dec['data']['id'];
}


function insert_payment_transaction($user_id, $payment_id){
  global $dbc;
  $user_id = secure_database($user_id);
  $payment_id = secure_database($payment_id);
  // $tx_ref = secure_database($tx_ref);
  $unique_id = unique_id_generator($payment_id.$user_id);
  if($user_id == '' || $payment_id == ''){
    return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
  }
  else{
    $insert_data_sql = "INSERT INTO `online_bank_statement` SET `unique_id` = '$unique_id', `user_id` = '$user_id', `transaction_id` = '$payment_id', `use_status` = 0, `date_created` = now()";
    $insert_data_query = mysqli_query($dbc, $insert_data_sql) or die(mysqli_error($dbc));
    if($insert_data_query){
      return json_encode(["status"=>"1", "msg"=>"success"]);
    }else{
      return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
    }
  }
}

function insert_disbursed_loan($user_id, $loan_id, $amount, $received_json){
  global $dbc;
  $user_id = secure_database($user_id);
  // $loan_id = secure_database($loan_id);
  // $loan_id = secure_database($received_json);
  // $tx_ref = secure_database($tx_ref);
  $unique_id = unique_id_generator($loan_id.$user_id);
  if($user_id == '' || $loan_id == '' || $amount == ''){
    return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
  }
  else{
    $insert_data_sql = "INSERT INTO `disbured_loan` SET `unique_id` = '$unique_id', `user_id` = '$user_id', `loan_id` = '$loan_id', `amount` = '$amount', `received_json` = '$received_json', `date_created` = now()";
    $insert_data_query = mysqli_query($dbc, $insert_data_sql) or die(mysqli_error($dbc));
    if($insert_data_query){
      return json_encode(["status"=>"1", "msg"=>"success"]);
    }else{
      return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
    }
  }
}


function submit_guarantor($user_id, array $guarantor_array){
  global $dbc;
  $user_id = secure_database($user_id);
  $unique_id = unique_id_generator($user_id);
  $guarantor_name = $guarantor_array['guarantor_name'];
  $relationship = $guarantor_array['relationship'];
  $phone = $guarantor_array['phone'];
  $loan_details = $guarantor_array['loan_details'];
  // $loan_id = $guarantor_array['loan_id'];

  if($user_id == ''  || $guarantor_name == '' || $phone == '' || $relationship == '' || $loan_details == ''){
    return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
  }
  else{
    $insert_data_sql = "INSERT INTO `user_guarantor` SET `unique_id` = '$unique_id', `user_id` = '$user_id',  `guarantor_name`='$guarantor_name', `phone_number`='$phone', `relationship`='$relationship', `loan_details`='$loan_details', `date_created` = now()";
    $insert_data_query = mysqli_query($dbc, $insert_data_sql);
    if($insert_data_query){
      return json_encode(["status"=>"1", "msg"=>"success"]);
    }
    else{
      return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
    }
  }
}

function get_user_bank_statement($loan_id){
  $get_bank_statement = get_one_row_from_one_table_by_id('okra_test','loan_id', $loan_id, 'date_received');
  $received_json = $get_bank_statement['received_json'];
  $decode_received_json = json_decode($received_json, true);
  //$callback_url = $decode_received_json['callback_url'];
  $record_id = $decode_received_json['record_id'];
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.okra.ng/v2/callback?record='.$record_id.'&method=PERIODIC_TRANSACTIONS',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
      'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI1ZjVhMmU1ZjE0MGE3YTA4OGZkZWIwYWMiLCJpYXQiOjE1OTk3NDU2MzF9.ptc3Vf6KklgPiDCQXIi3SqpQ7nIlaFcxhhdw0GEtEjU'
    ),
  ));

  return $response = curl_exec($curl);

  curl_close($curl);
    //echo $response;
//   $responseData = json_decode($response, true);
//   $pdfData = base64_decode($responseData);
//     $filename = '../bank_statement/'.$loan_id.'.pdf';
//   $myfile = fopen($filename, "w") or die("Unable to open file!");
//   fwrite($myfile, $response);
}

function beautify_statement($loan_id){
  $get_user_bank_statement = get_user_bank_statement($loan_id);
  $decode_statement = json_decode($get_user_bank_statement, true);
  //print_r($decode_statement['data']);
  //print_r( $decode_statement['data']['transactions']['id'] );
  $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    // set default font subsetting mode
    $pdf->setFontSubsetting(true);
    $pdf->SetFont('helvetica', '', 10, '', true);
    // Add a page
    $pdf->AddPage("L");
    $response = '';
  $response .= '<h1>TRANSACTION DETAILS</h1>
    <div class="table-responsive">
    <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
      <thead class="thead-light">
      <tr>
        
        <th scope="col">Description</th>
        <th scope="col">Beneficiary</th>
        <th scope="col">Account Number</th>
        <th scope="col">Address</th>
        <th scope="col">Raw</th>
        <th>Branch</th>
        <th>Credit</th>
        <th>Debit</th>
        <th>Transaction Date</th>
      </tr>
    </thead>
    <tbody>';
  foreach($decode_statement['data']['transactions'] as $data){
    $desc = $data['notes']['desc'];
    $beneficiary = $data['ner']['beneficiaries'];
    $account = $data['ner']['account'][0];
    $address = $data['location']['address'];
    $raw = $data['location']['raw'];
    $branch = $data['branch'];
    $credit = $data['credit'];
    $debit = $data['debit'];
    $trans_date = $data['trans_date']; 
    // $response= '';
    $response1= '';
    $response1.= '<tr>';
    $response1.='<td>'.$desc.'</td>';
    $response1.='<td>'.$beneficiary.'</td>';
    $response1.='<td>'.$account.'</td>';
    $response1.='<td>'.$address.'</td>';
    $response1.='<td>'.$raw.'</td>';
    $response1.='<td>'.$branch.'</td>';
    $response1.='<td>'.number_format($credit).'</td>';
    $response1.='<td>'.number_format($debit).'</td>';
    $response1.='<td>'.$trans_date.'</td>';
    $response1.='</tr>';
    $pdf->writeHTML($response . $response1, true, false, false, false, '');
  }
   $response1.='<tbody></table></div>';
    $pdf->writeHTML($response . $response1, true, false, false, false, '');
    //$filename = '../bank_statement/'.$loan_id.'.pdf';
  //ob_end_flush();
  $pdf->Output($_SERVER['DOCUMENT_ROOT']. '/bank_statement/'.$loan_id.'.pdf', 'F');

   //$myfile = fopen($filename, "w") or die("Unable to open file!");
  //fwrite($myfile, $response);
}

///Tosin's functions end here

function get_active_insurance_products(){
    // $url = 'https://sandbox-customerportal.yoadirect.com/api/Integration/GetActiveProducts';
    // // $collection_name = 'RapidAPI';
    // $request_url = $url . '/';// . $collection_name;
    
    // $curl = curl_init($request_url);
    
    // curl_setopt($curl, CURLOPT_HTTPGET, true);
    // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($curl, CURLOPT_HTTPHEADER, [
    //   'UserIdentity: 86b686a4-2747-457e-868b-96f857a3f48a',
    //   'Content-Type: application/json'
    // ]);
    
    // $response = curl_exec($curl);
    // curl_getinfo($response);
    // curl_close($curl);
    
    
    // echo $response;
    // $array = json_decode(trim($response), TRUE);
    // print_r($array);
    
    // echo $array[0]["Name"];
    // -------------------------------------------------------
    
    $curl = curl_init();
  
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://sandbox-customerportal.yoadirect.com/api/Integration/GetActiveProducts",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "UserIdentity: 86b686a4-2747-457e-868b-96f857a3f48a",
      "Cache-Control: no-cache",
    ),
  ));
  
  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);
  
//   echo $response;
  if ($response) {
      $result =  json_decode(trim($response), TRUE);
      return $result;
  }
}


// function get_insurance_quote($post_data){
    
//     // Prepare json structure
    
//     $curl = curl_init();
    
//     $data = array(
//         $form_data=>null
//       );
    
//     curl_setopt_array($curl, array(
//         CURLOPT_URL => "https://sandbox-customerportal.yoadirect.com/api/Integration/GetQuoteComprehensiveMotorInsurance",
//         CURLOPT_RETURNTRANSFER => true,
//         CURLOPT_ENCODING => "",
//         CURLOPT_MAXREDIRS => 10,
//         CURLOPT_TIMEOUT => 0,
//         CURLOPT_FOLLOWLOCATION => true,
//         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//         CURLOPT_CUSTOMREQUEST => "POST",
//         CURLOPT_POSTFIELDS =>json_encode($data),
//         CURLOPT_HTTPHEADER => array(
//             "UserIdentity: 86b686a4-2747-457e-868b-96f857a3f48a",
//             "Content-Type: application/json"
//         ),
//     ));
    
//     $response = curl_exec($curl);
//     curl_close($curl);
// }


function pay_insurance_quote($quote_number){
    // Prepare json structure
    
    $curl = curl_init();
    
    $data = array(
      "ThirdpartyAccountUid"=> "00000000-0000-0000-0000-000000000000",
      "QuoteNumber"=> $quote_number,
      "Payment"=> array(
        "PaymentFrequency" => "Full",
        "PaymentMode" => "CreditCard",
        "ChequeNumber"=> "",
        "Amount"=> 25000,
        "PaymentReceivedDate"=> "2020-07-28",
        "SumInsuredType"=> "Individual",
        "Currency"=> "Naira"
      )
    );
    
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://sandbox-customerportal.yoadirect.com/api/Integration/PayQuote",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>json_encode($data),
        CURLOPT_HTTPHEADER => array(
            "UserIdentity: 86b686a4-2747-457e-868b-96f857a3f48a",
            "Content-Type: application/json"
        ),
    ));
    
    $response = curl_exec($curl);
    curl_close($curl);
}

function insert_into_wallet($user_id, $balance){
  global $dbc;
  $user_id = secure_database($user_id);
  $balance = secure_database($balance);
  $unique_id = unique_id_generator($user_id.$balance);
  $check_wallet_exist = check_record_by_one_param('wallet', 'user_id', $user_id);
  if($user_id == '' || $balance == ''){
    return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
  }
  else{
    if($check_wallet_exist){
      $update_wallet = update_by_one_param('wallet','balance', $balance, 'user_id',$user_id);
      if($update_wallet){
        return json_encode(["status"=>"1", "msg"=>"success"]);
      }else{
        return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
      }
    }else{
      $sql = "INSERT INTO `wallet` SET `unique_id` = '$unique_id', `user_id` = '$user_id', `balance` = '$balance', `date_created`= now()";
      $query = mysqli_query($dbc, $sql);
      if($query){
        return json_encode(["status"=>"1", "msg"=>"success"]);
      }
      else{
        return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
      }
    }
  }
}

function add_referral_bonus($referral_for, $referral_bonus, $admin_id){
  global $dbc;
  $referral_for = secure_database($referral_for);
  $referral_bonus = secure_database($referral_bonus);
  $admin_id = secure_database($admin_id);
  $unique_id = unique_id_generator($referral_bonus.$admin_id);
  $check_referral_exist = check_record_by_one_param('referral_tbl', 'referral_for', $referral_for);
  if($referral_for == '' || $referral_bonus == '' || $admin_id == ''){
    return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
  }
  else if($check_referral_exist){
    return json_encode(["status"=>"0", "msg"=>"Referral Bonus already exists, Please update instead"]);
  }
  else{
    $sql = "INSERT INTO `referral_tbl` SET `unique_id` = '$unique_id', `referral_for` = '$referral_for', `referral_bonus` = '$referral_bonus', `added_by` = '$admin_id', `date_created` = now()";
    $query = mysqli_query($dbc, $sql);
    if($query){
      return json_encode(["status"=>"1", "msg"=>"success"]);
    }
    else{
      return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
    }
  }
}

function add_referral($referrer_id, $referred_id, $referral_for, $amount_paid, $description){
  global $dbc;
  $referrer_id = secure_database($referrer_id);
  $referred_id = secure_database($referred_id);
  $referral_for = secure_database($referral_for);
  $amount_paid = secure_database($amount_paid);
  $description = secure_database($description);
  $unique_id = unique_id_generator($referrer_id.$referred_id);

  if($referrer_id == '' || $referred_id == '' || $referral_for == '' || $amount_paid == '' || $description == ''){
    return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
  }
  else{
    $get_referral_bonus = get_one_row_from_one_table_by_id('referral_tbl', 'referral_for', $referral_for, 'date_created');
    $get_user_balance = get_one_row_from_one_table_by_id('wallet', 'user_id', $referrer_id, 'date_created');
    $referral_bonus = $get_referral_bonus['referral_bonus'];
    $amount_to_add_to_wallet = ($referral_bonus / 100) * $amount_paid;
    if($get_user_balance == null){
      $wallet_balance = $amount_to_add_to_wallet;
    }
    else{
      $wallet_balance = $get_user_balance['balance'] + $amount_to_add_to_wallet;
    }
    $add_money_to_wallet = insert_into_wallet($referrer_id, $wallet_balance);
    $add_money_to_wallet_decode = json_decode($add_money_to_wallet, true);
    if($add_money_to_wallet_decode['status'] == "1"){
      $insert_referral_log = "INSERT INTO `referral_log` SET `unique_id` = '$unique_id', `referrer_id` = '$referrer_id', `referred_id` = '$referred_id', `referral_for` = '$referral_for', `amount` = '$amount_to_add_to_wallet', `description` = '$description', `date_added` = now()";
      $insert_referral_log_query = mysqli_query($dbc, $insert_referral_log) or die(mysqli_error($dbc));
      if($insert_referral_log_query){
        return json_encode(["status"=>"1", "msg"=>"success"]);
      }
      else{
        return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
      }
    }
    else{
      echo json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
    }
  }
}

function get_one_row_from_one_table($table,$param,$value){
  global $dbc;

  $table = secure_database($table);
  $param = secure_database($param);
  $value = secure_database($value);
  $sql = "SELECT * FROM `$table` WHERE `$param` = '$value'";
  $query = mysqli_query($dbc, $sql);
  $num = mysqli_num_rows($query);
 if($num > 0){
      $row = mysqli_fetch_array($query);
      return $row;
    }
    else{
       return null;
    }
}

function submit_withdrawal_request($user_id, $amount){
  global $dbc;
  $user_id = secure_database($user_id);
  $amount = secure_database($amount);
  $get_user_balance = get_one_row_from_one_table_by_id('wallet', 'user_id', $user_id, 'date_created');
  $wallet_balance = $get_user_balance['balance'];
  $naira = '&#8358;';
  $unique_id = unique_id_generator($user_id.$amount);
  if($user_id == '' || $amount == ''){
    return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
  }
  else if($amount < 100){
    return json_encode(["status"=>"0", "msg"=>"You cannot withdraw less than 100naira"]);
  }
  else if($wallet_balance < 5000){
    return json_encode(["status"=>"0", "msg"=>"You can only withdraw when your bonus is up to 5000naira"]);
  }
  else if($wallet_balance < $amount){
    return json_encode(["status"=>"0", "msg"=>"Your balance is insufficient"]);
  }
  else{
    $sql = "INSERT INTO `withdrawal_request` SET `unique_id` = '$unique_id', `user_id` = '$user_id', `amount` = '$amount', `date_created` = now()";
    $query = mysqli_query($dbc, $sql);
    if($query){
      return json_encode(["status"=>"1", "msg"=>"success"]);
    }
    else{
      return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
    }
  }
}

function approve_withdrawal($request_id, $amount){
  $request_id = secure_database($request_id);
  if($request_id == ''){
    return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
  }
  else{
    $get_withdrawal_request = get_one_row_from_one_table_by_id('withdrawal_request', 'unique_id', $request_id, 'date_created');
    $get_user_balance = get_one_row_from_one_table_by_id('wallet', 'user_id', $get_withdrawal_request['user_id'], 'date_created');
    if($get_user_balance['balance'] < $amount){
      return json_encode(["status"=>"0", "msg"=>"Wallet Balance is insufficient"]);
    }
    else{
      $flutter_transfer = flutterwave_transfer2($request_id, $get_withdrawal_request['user_id'], $get_withdrawal_request['amount']);
      $response_decode = json_decode($flutter_transfer, true);
      if($response_decode['status'] == "error"){
        $new_balance = $get_user_balance['balance'] - $get_withdrawal_request['amount'];
        $update_wallet = update_by_one_param('wallet','balance', $new_balance, 'user_id', $get_withdrawal_request['user_id']);
        $update_request_status = update_by_one_param('withdrawal_request','status', 1, 'unique_id', $request_id);
        if($update_wallet AND $update_request_status){
          return json_encode(["status"=>"1", "msg"=>"error"]);
        }else{
          return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
        }
      }
      else{
        return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
      }
    }
  }
}

function add_new_vehicle($user_id, array $vehicle_details_array){
  global $dbc;
  //$user_id = $vehicle_details_array['user_id'];
  $vehicle_type = $vehicle_details_array['vehicle_type'];
  $vehicle_make = $vehicle_details_array['vehicle_make'] == 'others' ? $vehicle_details_array['other_vehicle_make'] : $vehicle_details_array['vehicle_make'];
  $vehicle_model = $vehicle_details_array['vehicle_model'] == 'others' ? $vehicle_details_array['other_vehicle_model'] : $vehicle_details_array['vehicle_model'];
  $year_of_make = $vehicle_details_array['year_of_make'];
  // $plate_number = $vehicle_details_array['plate_number'];
  $chasis_number = $vehicle_details_array['chasis_number'];
  $engine_number = $vehicle_details_array['engine_number'];
  $vehicle_color = $vehicle_details_array['vehicle_color'] == 'others' ? $vehicle_details_array['other_vehicle_color'] : $vehicle_details_array['vehicle_color'];
  $occupation = $vehicle_details_array['occupation'];
  $date_of_birth = $vehicle_details_array['date_of_birth'];
  $contact_address = $vehicle_details_array['contact_address'];
  $vehicle_particulars = json_encode($vehicle_details_array['vehicle_particulars']);
  //$vehicle_license_name = $vehicle_details_array['vehicle_license_name'];
  $name_on_vehicle = $vehicle_details_array['name_on_vehicle'];
  $insurance_type = $vehicle_details_array['insurance_type'];
  $insurer = $vehicle_details_array['insurer'];
  $plate_number_type = $vehicle_details_array['plate_number_type'];
  $number_plate = $vehicle_details_array['number_plate'];
  $state = $vehicle_details_array['state'];
  $first_lg = $vehicle_details_array['first_lg'];
  $second_lg = $vehicle_details_array['second_lg'];
  $third_lg = $vehicle_details_array['third_lg'];
  $tinted_permit = $vehicle_details_array['tinted_permit'];
  $plan_type = $vehicle_details_array['plan_type'];
  $vehicle_value = $vehicle_details_array['vehicle_value'];
  $phone = $vehicle_details_array['phone'];
  $unique_id = unique_id_generator($user_id. $chasis_number);
  $check_vehicle_exist = check_record_by_one_param('vehicle_registration', 'chasis_number',$chasis_number);
  if($user_id == '' || $vehicle_type == '' || $vehicle_make == '' || $vehicle_model == '' || $year_of_make == '' || $engine_number == '' || $chasis_number == '' || $vehicle_color == '' || $occupation == '' || $date_of_birth == '' || $contact_address == '' || $vehicle_particulars == '' || $name_on_vehicle == '' || $insurance_type == '' || $plate_number_type == '' || $state == '' || $first_lg == '' || $second_lg == '' || $third_lg == '' || $tinted_permit == '' || $phone == ''){
    return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
  }
  else if($check_vehicle_exist == true){
     return  json_encode(["status"=>"0", "msg"=>"Vehicle already exists"]);
  }
  else{
    $sql = "INSERT INTO `vehicle_registration` SET
    `unique_id` = '$unique_id',
    `user_id` = '$user_id',
    `vehicle_type` = '$vehicle_type',
    `vehicle_make` = '$vehicle_make',
    `vehicle_model` = '$vehicle_model',
    `year_of_make` = '$year_of_make',
    `engine_number` = '$engine_number',
    `chasis_number` = '$chasis_number',
    `vehicle_color` = '$vehicle_color',
    `occupation` = '$occupation',
    `date_of_birth` = '$date_of_birth',
    `contact_address` = '$contact_address',
    `vehicle_particulars` = '$vehicle_particulars',
    `name_on_vehicle` = '$name_on_vehicle',
    `insurance_type` = '$insurance_type',
    `plate_number_type` = '$plate_number_type',
    `state` = '$state',
    `insurer` = '$insurer',
    `plan_type` = '$plan_type',
    `vehicle_value` = '$vehicle_value',
    `number_plate` = '$number_plate',
    `first_lg` = '$first_lg',
    `second_lg` = '$second_lg',
    `third_lg` = '$third_lg',
    `phone` = '$phone',
    `tinted_permit` = '$tinted_permit',
    `date_created` = now()
    ";
    $query = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
    if($query){
      return json_encode(["status"=>"1", "msg"=>"success", "data" => $unique_id]);
    }else{
      return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
    }
  }
}

function okra_recurrent($amount, $account_to_debit, $account_to_credit){
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.okra.ng/v2/pay/initiate',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'
  {
      "account_to_debit": $account_to_debit,
      "account_to_credit": $account_to_credit,
          "amount": $amount,
          "currency": "NGN"
  }',
    CURLOPT_HTTPHEADER => array(
      'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI1ZjVhMmU1ZjE0MGE3YTA4OGZkZWIwYWMiLCJpYXQiOjE1OTk3NDU2MzF9.ptc3Vf6KklgPiDCQXIi3SqpQ7nIlaFcxhhdw0GEtEjU'
    ),
  ));

  $response = curl_exec($curl);

  curl_close($curl);
  echo $response;
}

function repayment_cron(){
  $get_due_repayments = get_rows_from_table_with_one_params('personal_loan_application', 'approval_status', 3);
  foreach ($get_due_repayments as $repayment) {
    $get_customer_id = get_one_row_from_one_table('disbured_loan', 'loan_id', $repayment['unique_id']);
    $get_employment_details = get_one_row_from_one_table('user_employment_details', 'user_id', $repayment['user_id']);
    $customer_id = $get_customer_id['received_json'];
    $decode = json_decode($customer_id, true);
    $account_to_debit = $decode['customer_id'];
    $account_to_credit = '';
    $salary_payday = $get_employment_details['salary_payday'];
    $approval_date = $repayment['approval_date'];
    $explode_date = explode('-', $approval_date);
    $approval_day = $explode_date[2];
    $today = date("Y-m-d");
    $new_approval_date = date_create($repayment['approval_date']);
    $get_user = get_one_row_from_one_table('users', 'unique_id', $repayment['user_id']);
    $referrer_code = $get_user['referrer_code'];
    $get_referrer = get_one_row_from_one_table('users', 'referral_code', $referrer_code);
    $referrer_id = $get_referrer['unique_id'];
    if($salary_payday != ''){
      if (abs($salary_payday - $approval_day) >= 5){
        $repayment_date = date_create($explode_date[0].'-'.$explode_date[1].'-'.$salary_payday);
      }else{
        $date_to_add = '30 days';
        $repayment_date = date_add($new_approval_date, date_interval_create_from_date_string($date_to_add));
      }
    }
    else{
      $date_to_add = '28 days';
      $repayment_date = date_add($new_approval_date, date_interval_create_from_date_string($date_to_add));
    }
    
    if($today == date_format($repayment_date,"Y-m-d")){
      $deduct_money = okra_recurrent($repayment['amount_to_repay'], $account_to_debit, $account_to_credit);
      $deduct_money_decode = json_decode($deduct_money);
      if($deduct_money_decode['status'] == "success"){
        $update_loan_status = update_by_one_param('personal_loan_application','approval_status', 4, 'unique_id', $repayment['unique_id']);
        $add_referral = add_referral($referrer_id, $repayment['user_id'], 'loan', $repayment['amount_to_repay'], "Referral Bonus for Loan repayment");
        $add_referral_decode = json_decode($add_referral, true);
        if($add_referral_decode['status'] == 1){
          echo "success";
        }else{
          echo "error";
        }
      }
    }
    
  }
}

function vechicle_installment_repayment_cron(){
  $get_loans = get_rows_from_one_table('vehicle_reg_installment','date_created');
  foreach ($get_loans as $loan_application) {
    $get_employment_details = get_one_row_from_one_table('user_employment_details', 'user_id', $loan_application['user_id']);
    $loan_id = $loan_application['unique_id'];
    $get_customer_id = get_one_row_from_one_table('disbured_loan', 'loan_id', $loan_application['unique_id']);
    $customer_id = $get_customer_id['received_json'];
    $get_repayment_details = get_one_row_from_one_table_by_id('repayment_tbl','loan_id', $loan_id, 'date_created');
    $amount_paid_so_far = $get_repayment_details['amount_paid_so_far'] + $loan_application['amount_deducted_per_month'];
    $balance = $get_repayment_details['total_amount_to_pay'] - $amount_paid_so_far;
    if($loan_application['no_of_repayment_month'] <= $loan_application['current_repayment_month']){
      echo "user has finished paying<br>";
      $update_current_repayment_month = update_by_one_param('vehicle_reg_installment','approval_status',4,'unique_id', $loan_id);
      continue;
    }
    //else{
      $decode = json_decode($customer_id, true);
      $account_to_debit = $decode['customer_id'];
      $account_to_credit = '';
      $salary_payday = $get_employment_details['salary_payday'];
      $approval_date = $loan_application['approval_date'];
      $explode_date = explode('-', $approval_date);
      $approval_day = $explode_date[2];
      $today = date("Y-m-d");
      $new_approval_date = date_create($loan_application['approval_date']);
      $get_user = get_one_row_from_one_table('users', 'unique_id', $loan_application['user_id']);
      $referrer_code = $get_user['referrer_code'];
      $get_referrer = get_one_row_from_one_table('users', 'referral_code', $referrer_code);
      $referrer_id = $get_referrer['unique_id'];
      if($salary_payday != ''){
        if (abs($salary_payday - $approval_day) >= 5){
          $repayment_date = date_create($explode_date[0].'-'.$explode_date[1].'-'.$salary_payday);
        }else{
          $date_to_add = '30 days';
          $repayment_date = date_add($new_approval_date, date_interval_create_from_date_string($date_to_add));
        }
      }
      else{
        $date_to_add = '28 days';
        $repayment_date = date_add($new_approval_date, date_interval_create_from_date_string($date_to_add));
      }
      
      if($today == date_format($repayment_date,"Y-m-d")){
        $deduct_money = okra_recurrent($loan_application['amount_to_repay'], $account_to_debit, $account_to_credit);
        $deduct_money_decode = json_decode($deduct_money);
        if($deduct_money_decode['status'] == "success"){
          $update_loan_status = update_by_one_param('vehicle_reg_installment','approval_status', 4, 'unique_id', $loan_application['unique_id']);
          $current_repayment_month = $loan_application['current_repayment_month'] + 1;
          $update_current_repayment_month = update_by_one_param('vehicle_reg_installment','current_repayment_month', $current_repayment_month,'unique_id', $loan_application['unique_id']);
          $update_repayment_tbl = "UPDATE `repayment_tbl` SET `current_repayment_month`='$current_repayment_month', `amount_paid_so_far`='$amount_paid_so_far', `balance`='$balance', `date_created` = now()  WHERE `loan_id`='$loan_id'";
          $add_referral = add_referral($referrer_id, $repayment['user_id'], 'loan', $loan_application['amount_to_repay'], "Referral Bonus for Loan repayment");
          $add_referral_decode = json_decode($add_referral, true);
          if($add_referral_decode['status'] == 1){
            echo "success";
          }else{
            echo "error";
          }
        }
      }
        //echo $result;
      }
    //}
}

function add_time_frame($admin_id, $time_frame){
  global $dbc;
  $admin_id = secure_database($admin_id);
  $unique_id = unique_id_generator($admin_id);
  $time_frame = secure_database($time_frame);
  // $loan_id = $guarantor_array['loan_id'];

  if($admin_id == ''  || $time_frame == ''){
    return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
  }
  else{
    $update_data_sql = "UPDATE `loan_time_frame` SET `unique_id` = '$unique_id', `added_by` = '$admin_id',  `time_frame`='$time_frame' WHERE `type` = 'loan'";
    $update_data_query = mysqli_query($dbc, $update_data_sql) or die(mysqli_error($dbc));
    if($update_data_query){
      return json_encode(["status"=>"1", "msg"=>"success"]);
    }
    else{
      return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
    }
  }
}

function add_services($service, $cost){
  global $dbc;
  $service = secure_database($service);
  $unique_id = unique_id_generator($service);
  $cost = secure_database($cost);
  // $loan_id = $guarantor_array['loan_id'];

  if($service == ''  || $cost == ''){
    return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
  }
  else{
    $insert_data_sql = "INSERT INTO `services` SET `unique_id` = '$unique_id', `service` = '$service',  `cost`='$cost', `date_created` = now()";
    $insert_data_query = mysqli_query($dbc, $insert_data_sql) or die(mysqli_error($dbc));
    if($insert_data_query){
      return json_encode(["status"=>"1", "msg"=>"success"]);
    }
    else{
      return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
    }
  }
}

function add_vehicle_particulars($vehicle_id, $license_amount, $road_worthiness_amount, $third_party_amount, $hackney_permit_amount){
  global $dbc;
  $vehicle_id = secure_database($vehicle_id);
  $unique_id = unique_id_generator($vehicle_id);
  $license_amount = secure_database($license_amount);
  $road_worthiness_amount = secure_database($road_worthiness_amount);
  $third_party_amount = secure_database($third_party_amount);
  $hackney_permit_amount = secure_database($hackney_permit_amount);
  // $loan_id = $guarantor_array['loan_id'];

  if($vehicle_id == ''  || $license_amount == '' || $road_worthiness_amount == '' || $third_party_amount == '' || $hackney_permit_amount == ''){
    return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
  }
  else{
    $insert_data_sql = "INSERT INTO `vehicle_particulars` SET `unique_id` = '$unique_id', `vehicle_id`= '$vehicle_id', `license_amount` = '$license_amount',  `road_worthiness_amount`='$road_worthiness_amount', `third_party_amount`='$third_party_amount', `hackney_permit_amount`='$hackney_permit_amount', `date_created` = now()";
    $insert_data_query = mysqli_query($dbc, $insert_data_sql) or die(mysqli_error($dbc));
    if($insert_data_query){
      return json_encode(["status"=>"1", "msg"=>"success"]);
    }
    else{
      return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
    }
  }
}

function add_plate_number($vehicle_id, $type, $no_third_party_amount, $third_party_amount, $personalized_number){
  global $dbc;
  $vehicle_id = secure_database($vehicle_id);
  $type = secure_database($type);
  $unique_id = unique_id_generator($vehicle_id);
  $no_third_party_amount = secure_database($no_third_party_amount);
  $third_party_amount = secure_database($third_party_amount);
  $personalized_number = secure_database($personalized_number);

  if($vehicle_id == '' || $type == '' || $no_third_party_amount == '' || $third_party_amount == ''){
    return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
  }
  else{
    $insert_data_sql = "INSERT INTO `number_plate` SET `unique_id` = '$unique_id', `vehicle_id`= '$vehicle_id', `no_third_party_amount` = '$no_third_party_amount',  `third_party_amount`='$third_party_amount', `type`='$type', `personalized_number` = '$personalized_number', `date_created` = now()";
    $insert_data_query = mysqli_query($dbc, $insert_data_sql) or die(mysqli_error($dbc));
    if($insert_data_query){
      return json_encode(["status"=>"1", "msg"=>"success"]);
    }
    else{
      return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
    }
  }
}

function add_vehicle_brand($brand_name){
  global $dbc;
  $brand_name = secure_database($brand_name);
  $unique_id = unique_id_generator($brand_name);
  // $loan_id = $guarantor_array['loan_id'];
  $check = check_record_by_one_param('vehicle_brands', 'brand_name', $brand_name);

  if($brand_name == ''){
    return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
  }
  else if($check == true){
    return json_encode(["status"=>"0", "msg"=>"Record already Exists"]);
  }
  else{
    $insert_data_sql = "INSERT INTO `vehicle_brands` SET `unique_id` = '$unique_id', `brand_name` = '$brand_name', `datetime` = now()";
    $insert_data_query = mysqli_query($dbc, $insert_data_sql) or die(mysqli_error($dbc));
    if($insert_data_query){
      return json_encode(["status"=>"1", "msg"=>"success"]);
    }
    else{
      return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
    }
  }
}

function add_vehicle_model($brand_id, $model_name){
  global $dbc;
  $brand_id = secure_database($brand_id);
  $model_name = secure_database($model_name);
  $unique_id = unique_id_generator($brand_id);
  $check = check_record_by_one_param('vehicle_models', 'model_name', $model_name);
  // $loan_id = $guarantor_array['loan_id'];

  if($brand_id == '' || $model_name == ''){
    return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
  }
  else if($check == true){
    return json_encode(["status"=>"0", "msg"=>"Record already Exists"]);
  }
  else{
    $insert_data_sql = "INSERT INTO `vehicle_models` SET `unique_id` = '$unique_id', `brand_id` = '$brand_id', `model_name` = '$model_name', `datetime` = now()";
    $insert_data_query = mysqli_query($dbc, $insert_data_sql) or die(mysqli_error($dbc));
    if($insert_data_query){
      return json_encode(["status"=>"1", "msg"=>"success"]);
    }
    else{
      return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
    }
  }
}

function calculate_vehicle_registration($reg_id){
  $reg_id = secure_database($reg_id);
  $get_registration_details = get_one_row_from_one_table('vehicle_registration', 'unique_id', $reg_id);
  $vehicle_type = $get_registration_details['vehicle_type'];
  $get_vehicle_particulars = get_one_row_from_one_table('vehicle_particulars', 'vehicle_id', $vehicle_type);
  $get_insurance_rate = get_one_row_from_one_table('insurance_plans', 'unique_id', $get_registration_details['plan_type']);
  // $get_number_plate
  if($get_registration_details['tinted_permit'] == 'yes'){
    $service = "Tinted Glass Permit";
    $get_service = get_one_row_from_one_table('services', 'service', $service);
    $service_charge = $get_service['cost'];
  }
  else{
    $service_charge = 0;
  }

  if($get_registration_details['insurance_type'] == 'third_party_insurance'){
    $insurance_charge = $get_vehicle_particulars['third_party_amount'];
  }
  else if($get_registration_details['insurance_type'] == 'no_third_party_insurance'){
    $insurance_charge = 0;
  }
  else if($get_registration_details['insurance_type'] == 'comprehensive'){
    $insurance_charge = ($get_insurance_rate['plan_percentage'] / 100) * $get_registration_details['vehicle_value'];
  }

  if($get_registration_details['plate_number_type'] == "private"){
    $get_number_plate = get_one_row_from_one_table_by_two_params('number_plate', 'type','private','vehicle_id',$vehicle_type, 'date_created');
    if($get_registration_details['insurance_type'] == 'third_party_insurance'){
      $number_plate_charge = $get_number_plate['third_party_amount'];
    }
    else if($get_registration_details['insurance_type'] == 'no_third_party_insurance' || $get_registration_details['insurance_type'] == 'comprehensive'){
      $number_plate_charge = $get_number_plate['no_third_party_amount'];
    }
  }
  else if($get_registration_details['plate_number_type'] == "commercial"){
    $get_number_plate = get_one_row_from_one_table_by_two_params('number_plate', 'type','commercial','vehicle_id',$vehicle_type, 'date_created');
    if($get_registration_details['insurance_type'] == 'third_party_insurance'){
      $number_plate_charge = $get_number_plate['third_party_amount'];
    }
    else if($get_registration_details['insurance_type'] == 'no_third_party_insurance' || $get_registration_details['insurance_type'] == 'comprehensive'){
      $number_plate_charge = $get_number_plate['no_third_party_amount'];
    }
  }
  else if($get_registration_details['plate_number_type'] == "personalized_number"){
    $get_number_plate = get_one_row_from_one_table_by_two_params('number_plate', 'type','new','vehicle_id',$vehicle_type, 'date_created');
    if($get_number_plate != null){
      $number_plate_charge = $get_number_plate['personalized_number'];
    } 
    else{
      $number_plate_charge = 0;
    }
  }

  return json_encode([
    "status" => 1,
    "service_charge" => $service_charge, 
    "insurance_charge" => $insurance_charge, 
    "number_plate_charge" => $number_plate_charge
  ]);
}

function insert_payment($email = null, $table, $user_id, $reg_id, $city, $delivery_area, $delivery_address, $total, $installment_id, $service_type, $remove_from_wallet){
  global $dbc;
  $user_id = secure_database($user_id);
  $city = secure_database($city);
  $delivery_area = secure_database($delivery_area);
  $delivery_address = secure_database($delivery_address);
  $remove_from_wallet = secure_database($remove_from_wallet);
  $total = secure_database($total);
  $reg_id = secure_database($reg_id);
  $unique_id = unique_id_generator($reg_id.$user_id);
  $installment_id = secure_database($installment_id);
  $check = check_record_by_one_param($table, 'reg_id', $reg_id);
  $get_user = get_one_row_from_one_table('users', 'unique_id', $user_id);
  $referrer_code = $get_user['referrer_code'];
  $get_referrer = get_one_row_from_one_table('users', 'referral_code', $referrer_code);
  $referrer_id = $get_referrer['unique_id'];
  if($user_id == '' || $total == ''){
   return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
  }
  else if($check == true){
    return json_encode(["status"=>"0", "msg"=>"Record already Exists"]);
  }
  else{
    $payment_type = 1;
    $equity_contribution = 0;
    if($remove_from_wallet != ''){
      $balance = 0;
      $update_wallet = update_by_one_param('wallet','balance', $balance, 'user_id',$user_id);
    }
    $insert_data_sql = "INSERT INTO `$table` SET `unique_id` = '$unique_id', `user_id` = '$user_id', `reg_id`= '$reg_id', `city` = '$city',  `delivery_area`='$delivery_area', `delivery_address`='$delivery_address', `total` = '$total', `payment_type` = '$payment_type', `email`='$email', `service_type` = '$service_type', `date_created` = now()";
    $insert_data_query = mysqli_query($dbc, $insert_data_sql) or die(mysqli_error($dbc));
    if($insert_data_query){
      $add_referral = add_referral($referrer_id, $user_id, 'vehicle_registration', $total, "Referral Bonus for Vehicle Registration");
      $add_referral_decode = json_decode($add_referral, true);
      if($add_referral_decode['status'] == 1){
        return json_encode(["status"=>"1", "msg"=>"success", "data" => $equity_contribution]);
      }else{
        return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
      }
    }
    else{
      return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
    }
  }
}

function submit_vehicle_reg_installment($user_id, $reg_id, $bank_statement){
  global $dbc;
  $user_id = secure_database($user_id);
  $reg_id = secure_database($reg_id);
  $bank_statement = secure_database($bank_statement);
  $unique_id = unique_id_generator($user_id);
  $get_registration_details = get_one_row_from_one_table_by_id('vehicle_reg_payment','reg_id', $reg_id ,'date_created');
  $total = $get_registration_details['total'];
  if($user_id == '' || $reg_id == '' || $bank_statement == ''){
    return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
  }
  else{
    $insert_data_sql = "INSERT INTO `vehicle_reg_installment` SET `unique_id` = '$unique_id', `user_id` = '$user_id',  `reg_id`='$reg_id', `total`='$total', `bank_statement`='$bank_statement', `date_created` = now()";
    $insert_data_query = mysqli_query($dbc, $insert_data_sql) or die(mysqli_error($dbc));
    if($insert_data_query){
      $get_last_id = mysqli_query($dbc, "SELECT MAX(ID) AS last_id FROM okra_test");
      while ($row = mysqli_fetch_array($get_last_id)){
        $last_id = $row['last_id'];
      }
      $update_data = mysqli_query($dbc, "UPDATE `okra_test` SET `loan_id` = '$unique_id', `status` = 1 WHERE `id` = '$last_id' AND `status` = 0") or die(mysqli_error($dbc));
      return json_encode(["status"=>"1", "msg"=>"success"]);
    }else{
      return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
    }
  }
}

function installmental_payment($unique_id, $installment_id){
  global $dbc;
  $unique_id = secure_database($unique_id);
  $installment_id = secure_database($installment_id);
  $unique_id2= unique_id_generator($installment_id);
  if($unique_id == '' || $installment_id == ''){
   return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
  }
  else{
    $get_installment_details = get_one_row_from_one_table('installment_payment_interest', 'unique_id', $installment_id);
    $get_details = get_one_row_from_one_table('vehicle_reg_installment', 'unique_id', $unique_id);
    $total = $get_details['total'];
    $equity_contribution = (30/100) * $total;
    $balance = $total - $equity_contribution;
    $interest = $get_installment_details['interest_rate'];
    $interest_per_month = (int) (($interest /100) * $balance);
    $total_interest = (int) $interest_per_month * $get_installment_details['no_of_month'];
    $total_amount_to_pay = $total_interest + $balance;
    $amount_to_pay_per_month = $total_amount_to_pay / $get_installment_details['no_of_month'];
    $user_id = $get_details['user_id'];
    $no_of_repayment_month = $get_installment_details['no_of_month'];
    $update_data_sql = "UPDATE `vehicle_reg_installment` SET `installment_id` = '$installment_id', `amount_to_repay` = '$total_amount_to_pay', `interest_per_month` = '$interest_per_month', `amount_deducted_per_month` = '$amount_to_pay_per_month', `no_of_repayment_month` = '$no_of_repayment_month'  WHERE `unique_id` = '$unique_id'";
    $insert_repayment = "INSERT INTO `repayment_tbl` SET `unique_id`='$unique_id2', `user_id`='$user_id', `loan_id`='$unique_id', `total_amount_to_pay`='$total_amount_to_pay', `amount_deducted_per_month`='$amount_to_pay_per_month', `amount_paid_so_far` = 0, `balance`='$total_amount_to_pay', `date_created` = now()";
    $insert_repayment_query = mysqli_query($dbc, $insert_repayment) or die(mysqli_error($dbc));
    $update_data_query = mysqli_query($dbc, $update_data_sql) or die(mysqli_error($dbc));
    if($update_data_query AND $insert_repayment_query){
      return json_encode(["status"=>"1", "msg"=>"success", "data" => $equity_contribution]);
    }
    else{
      return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
    }
  }
}

function change_vehicle_ownership($user_id, array $vehicle_details_array){
  global $dbc;
  $user_id = secure_database($user_id);
  $vehicle_id = $vehicle_details_array['vehicle_id'];
  $license_expiry = $vehicle_details_array['license_expiry'];
  $dob = $vehicle_details_array['dob'];
  $name = $vehicle_details_array['name'];
  $phone = $vehicle_details_array['phone'];
  $address = $vehicle_details_array['address'];
  $vehicle_documents = json_encode($vehicle_details_array['vehicle_documents']);
  $registration_type = $vehicle_details_array['registration_type'];
  $plate_number_type = $vehicle_details_array['plate_number_type'];
  $unique_id = unique_id_generator($user_id. $vehicle_id);
  if($user_id == '' || $vehicle_id == '' || $license_expiry == '' || $dob == '' || $name == '' || $phone == '' || $address == '' || $vehicle_documents == '' || $registration_type == '' || $plate_number_type == ''){
    return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
  }
  else{
    $sql = "INSERT INTO `change_ownership` SET
    `unique_id` = '$unique_id',
    `user_id` = '$user_id',
    `vehicle_id` = '$vehicle_id',
    `license_expiry` = '$license_expiry',
    `name` = '$name',
    `phone` = '$phone',
    `dob` = '$dob',
    `address` = '$address',
    `vehicle_documents` = '$vehicle_documents',
    `registration_type` = '$registration_type',
    `plate_number_type` = '$plate_number_type',
    `date_created` = now()
    ";
    $query = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
    if($query){
      return json_encode(["status"=>"1", "msg"=>"success", "data" => $unique_id]);
    }else{
      return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
    }
  }
}

function calculate_change_vehicle_ownership($unique_id){
  $unique_id = secure_database($unique_id);
  $get_details = get_one_row_from_one_table('change_ownership', 'unique_id', $unique_id);
  $vehicle_id = $get_details['vehicle_id'];
  $registration_type = $get_details['registration_type'];
  $plate_number_type = $get_details['plate_number_type'];
  $get_vehicle_particulars = get_one_row_from_one_table('vehicle_particulars', 'vehicle_id', $vehicle_id);

  if($registration_type != ''){
    if($registration_type == "private_with_third"){
      $get_number_plate = get_one_row_from_one_table_by_two_params('number_plate', 'type','private','vehicle_id',$vehicle_id, 'date_created');
      $registration_charge = $get_number_plate['third_party_amount'];
    }
    else if($registration_type == "private_without_third"){
      $get_number_plate = get_one_row_from_one_table_by_two_params('number_plate', 'type','private','vehicle_id',$vehicle_id, 'date_created');
      $registration_charge = $get_number_plate['no_third_party_amount'];
    }
    else if($registration_type == "commercial_with_third"){
      $get_number_plate = get_one_row_from_one_table_by_two_params('number_plate', 'type','commercial','vehicle_id',$vehicle_id, 'date_created');
      $registration_charge = $get_number_plate['third_party_amount'];
    }
    else if($registration_type == "commercial_without_third"){
      $get_number_plate = get_one_row_from_one_table_by_two_params('number_plate', 'type','commercial','vehicle_id',$vehicle_id, 'date_created');
      $registration_charge = $get_number_plate['no_third_party_amount'];
    }
  }

  if($plate_number_type != ""){
    if($plate_number_type == "custom"){
      $get_number_plate = get_one_row_from_one_table_by_two_params('number_plate', 'type','new','vehicle_id',$vehicle_id, 'date_created');
      if($get_number_plate != null){
        $number_plate_charge = $get_number_plate['personalized_number'];
      }
      else{
        $number_plate_charge = 0;
      }
    }
    else{
      $number_plate_charge = 0;
    }
  }
  
  return json_encode([
    "status" => 1,
    "change_of_ownership_fee" => $number_plate_charge + $registration_charge
  ]);
}

function save_vehicle_permit($post_data){
  global $dbc;


  $permit_type = secure_database($post_data['permit_type']);
  $vehicle_type = secure_database($post_data['vehicle_type']);
  $make_of_vehicle = secure_database($post_data['make_of_vehicle']);
  $vehicle_model = secure_database($post_data['vehicle_model']);
  $year_of_make = secure_database($post_data['year_of_make']);
  $plate_no = secure_database($post_data['plate_no']);
  $engine_no = secure_database($post_data['engine_no']);
  $chassis_no = secure_database($post_data['chassis_no']);
  $vehicle_license = secure_database($post_data['vehicle_license']);
  $vehicle_color = secure_database($post_data['vehicle_color']);
  $license_expiry = secure_database($post_data['license_expiry']);
  $insurance_expiry = secure_database($post_data['insurance_expiry']);
  $road_worthiness_expiry = secure_database($post_data['road_worthiness_expiry']);
  $hackney_permit_expiry = secure_database($post_data['hackney_permit_expiry']);
  $heavy_duty_permit_expiry = secure_database($post_data['heavy_duty_permit_expiry']);

  $unique_id = unique_id_generator($vehicle_model);
  $user_id = $_SESSION['user']['unique_id'];

  $sql = "INSERT INTO vehicle_permit SET `unique_id`='$unique_id', `user_id`='$user_id', `permit_type`='$permit_type', `vehicle_type`='$vehicle_type',
  `vehicle_make`='$make_of_vehicle', `year_of_make`='$year_of_make', `plate_no`='$plate_no', `engine_no`='$engine_no', `chassis_no`='$chassis_no', 
  `vehicle_license`='$vehicle_license', `vehicle_color`='$vehicle_color', `license_expiry`='$license_expiry', `insurance_expiry`='$insurance_expiry',
  `road_worthiness_expiry`='$road_worthiness_expiry', `hackney_permit_expiry`='$hackney_permit_expiry', `heavy_duty_permit_expiry`='$heavy_duty_permit_expiry',
  `datetime`=now()";

  $exe = mysqli_query($dbc, $sql);

  if($exe){
    return json_encode(array('status'=>1, 'record_id'=>$unique_id));
  }else{
    return json_encode(array('msg'=>'Error saving application.'));
  }
}

function calculate_repayment_details($amount_to_borrow, $installment_id){
  $get_installment_details = get_one_row_from_one_table('installment_payment_interest', 'unique_id', $installment_id);
  $balance = $amount_to_borrow;
  $interest = $get_installment_details['interest_rate'];
  $interest_per_month = (int) (($interest /100) * $balance);
  $total_interest = (int) $interest_per_month * $get_installment_details['no_of_month'];
  $total_amount_to_pay = $total_interest + $balance;
  $amount_to_pay_per_month = $total_amount_to_pay / $get_installment_details['no_of_month'];
  $no_of_repayment_month = $get_installment_details['no_of_month'];
  return json_encode([
    'msg' => "success", 
    "status" => 1,
    "interest_per_month" => $interest_per_month,
    "total_amount_to_pay" => $total_amount_to_pay,
    "amount_to_pay_per_month" => $amount_to_pay_per_month
  ]);
}
/////// MOST IMPORTANT FUNCTIONS END HERE



//////////////////////////////not needed for now
