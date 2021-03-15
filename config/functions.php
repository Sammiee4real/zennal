<?php
@session_start();
$table = "";
$app_name = 'ZENNAL';
require_once("db_connect.php");
require_once("tcpdf/tcpdf.php");
// require_once('generic_functions.php');
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

function get_rows_form_table($table){
  global $dbc;
  $table = secure_database($table);
  $sql= "SELECT * FROM `$table`";
  $query = mysqli_query($dbc, $sql);
  $data = mysqli_fetch_all($query, MYSQLI_ASSOC);
  return $data;     
}

function add_insurance_benefit($benefit_name, $data){
    
    global $dbc;
    
    
    $sql = "SELECT * FROM insurance_benefits WHERE benefit = '$benefit_name'";
    
    $exe = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
    
    if(mysqli_num_rows($exe) >= 1){
        return json_encode(array("status"=>0, "msg"=>"Benefit exist"));
    }
    
    $benefit_unique_id = unique_id_generator($benefit_name);
    
    $sql = "INSERT INTO insurance_benefits (unique_id, benefit, datetime)
            VALUES ('$benefit_unique_id', '$benefit_name', now())";
    
    $exe = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
    
    unset($data["benefit_name"]);
    
    foreach($data as $k => $v){
        $unique_id = unique_id_generator($k);
        $sql = "INSERT INTO insurance_info (unique_id, benefit_id, category_id, description, datetime)
            VALUES ('$unique_id', '$benefit_unique_id', '$k', '$v', now())";
        $exe = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
    }
    return json_encode(array("status"=>1));
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
function register_user($data){
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
    $_SESSION['user'] = $user;
    return json_encode(array("status"=>1, "msg"=>"success"));
  }

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

function upload_vehicle_attached_file($fileArr){

  $filename1 = $fileArr['vehicle_license'];
  $filename2 = $fileArr['proof_of_ownership'];
  $filename3 = $fileArr['utility_bill'];
  $filename4 = $fileArr['means_of_id'];
  $filename5 = $fileArr['plate_number'];
  $filename6 = $fileArr['side_one'];
  $filename7 = $fileArr['side_two'];
  $filename8 = $fileArr['side_three'];
  $filename9 = $fileArr['side_four'];

  $uploaded_file = array(
     'vehicle_license'=>$filename1["name"],
     'proof_of_ownership'=>$filename2["name"],
     'utility_bill'=>$filename3["name"],
     'means_of_id'=>$filename4["name"],
     'plate_number'=>$filename5["name"],
     'side_one'=>$filename6["name"],
     'side_two'=>$filename7["name"],
     'side_three'=>$filename8["name"],
     'side_four'=>$filename9["name"],
  );

  $files = [$filename1, $filename2, $filename3, $filename4, $filename5, $filename6, $filename7, $filename8, $filename9];

  /* Location */

  foreach ($files as $file) {
     $location = "../uploads/".$file['name'];
     $uploadOk = 1;
     $imageFileType = pathinfo($location,PATHINFO_EXTENSION);

     if(strlen($file["name"]) < 1){
        return json_encode(["status"=>0, "msg"=>"Please upload all documents".$file]);
     }
     /* Valid Extensions */
     $valid_extensions = array("jpg","jpeg","png");

     /* Check file extension */
     if( !in_array(strtolower($imageFileType),$valid_extensions) ) {
        return json_encode(["status"=>0, "msg"=>"invalid file type".$file]);
     }

        /* Upload file */
     if(!move_uploaded_file($file['tmp_name'],$location)){
        return json_encode(["status"=>0, "msg"=>"can't upload image:".$file]);
     }
  }
  return json_encode(["status"=>1, "file"=>$uploaded_file]);
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

function insert_insurance_category($category_name, $category_rate){
    global $dbc;
    $sql = "SELECT * FROM insurance_categories WHERE category_name ='$category_name'";
    
    $exe = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
    if (mysqli_num_rows($exe) >= 1){
        return json_encode(array("status"=>0, "msg"=>"Category exist"));
    }
    $uniqueid = unique_id_generator($category_name);
    $sql = "INSERT INTO insurance_categories (unique_id, category_name, category_percentage, datetime)
            VALUES ('$uniqueid', '$category_name', '$category_rate', now())";
            
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
function user_exists($email, $password){
    global $dbc;
    
    $sql = "SELECT COUNT(*) AS num FROM `users` WHERE `email`='$email' AND `password`='$password'";
    $query = mysqli_query($dbc, $sql);
    $re = mysqli_fetch_assoc($query);

    if (intval($re['num']) === 1) {
      return true;
    } else {
      return false;
    }
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
  $unique_id = unique_id_generator($user_id);
  $employment_status = $employment_array['employment_status'];
  $name_of_organization = $employment_array['name_of_organization'];
  $contact_address_of_organization = $employment_array['contact_address_of_organization'];
  $employment_type = $employment_array['employment_type'];
  $job_title = $employment_array['job_title'];
  $employment_duration = $employment_array['employment_duration'];
  $years_of_experience = $employment_array['years_of_experience'];
  $industry_type = $employment_array['industry_type'];
  $monthly_salary = $employment_array['monthly_salary'];
  $salary_payday = $employment_array['salary_payday'];
  $official_email_address = $employment_array['official_email_address'];
  $otp = rand(111111, 999999);
  $_SESSION['otp'] = md5($otp);
  $_SESSION['start'] = time();
  $_SESSION['expire'] = $_SESSION['start'] + (60*1);
  $subject = 'Email Verification - Zennal';
  $content = "The token for your transaction is ".$otp."<br> Thanks, Regards";

  if($user_id == '' || $unique_id == '' || $employment_status == '' || $name_of_organization == '' || $contact_address_of_organization == '' || $employment_type == '' || $employment_duration == '' || $years_of_experience == '' || $industry_type == '' || $job_title == '' || $monthly_salary == '' || $salary_payday == '' || $official_email_address == ''){
    return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
  }
  else if (!filter_var($official_email_address, FILTER_VALIDATE_EMAIL)) {
    return json_encode(["status"=>"0", "msg"=>"Please provide a valid E-mail Address"]);
  }
  else{
    $check_row_exist = check_record_by_one_param('user_employment_details', 'user_id', $user_id);
    if($check_row_exist == true){
      $send_mail = email_function($official_email_address, $subject, $content);
      $update_data_sql = "UPDATE `user_employment_details` SET `employment_status`='$employment_status', `name_of_organization`='$name_of_organization', `contact_address_of_organization`='$contact_address_of_organization', `employment_type`='$employment_type', `employment_duration`='$employment_duration', `years_of_experience`='$years_of_experience', `industry_type`='$industry_type', `job_title`='$job_title', `monthly_salary`='$monthly_salary', `salary_payday`='$salary_payday', `official_email_address`='$official_email_address' WHERE `user_id`='$user_id'";
      $update_data_query = mysqli_query($dbc, $update_data_sql);
      if($update_data_query){
        return json_encode(["status"=>"1", "msg"=>"success"]);
      }else{
        return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
      }
    }
    else{
      $send_mail = email_function($official_email_address, $subject, $content);
      $insert_data_sql = "INSERT INTO `user_employment_details` SET `unique_id` = '$unique_id', `user_id` = '$user_id',  `employment_status`='$employment_status', `name_of_organization`='$name_of_organization', `contact_address_of_organization`='$contact_address_of_organization', `employment_type`='$employment_type', `employment_duration`='$employment_duration', `years_of_experience`='$years_of_experience', `industry_type`='$industry_type', `monthly_salary`='$monthly_salary', `salary_payday`='$salary_payday', `official_email_address`='$official_email_address', `date_created` = now()";
      $insert_data_query = mysqli_query($dbc, $insert_data_sql);
      if($insert_data_query){
        return json_encode(["status"=>"1", "msg"=>"success"]);
      }else{
        return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
      }
    }
  }
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

function save_financial_record($user_id, array $financial_details_array, $file_name, $size, $tmpName,$type){
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
  //$get_user_financial_details = get_one_row_from_one_table_by_id('user_financial_details','user_id', $user_id, 'date_created');
  // $acctno = $financial_details_array['account_number'];
  // $bankcode = $get_user_financial_details['bank_name'];
  //$id_card = $financial_details_array['id_card'];
  $imgchange = image_upload($file_name, $size, $tmpName, $type);
  $img_dec = json_decode($imgchange, true);
  if($user_id == '' || $unique_id == '' || $bank_name == '' || $account_number == '' || $account_type == '' || $bvn == '' || $existing_loan == ''){
    return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
  }
  else{
    if($img_dec['status'] == 0){
      return json_encode(["status"=>"0", "msg"=>$img_dec['status']]);
    }
    else{
      $image_path = $img_dec['msg'];
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
  }
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
  $update_data_sql = "UPDATE `personal_loan_application` SET `user_approved_amount`='$user_approved_amount', `amount_to_repay`='$amount_to_repay', `approval_status` = 3  WHERE `unique_id`='$loan_id'";
  $update_data_query = mysqli_query($dbc, $update_data_sql) or mysqli_error($dbc);
  if($update_data_query){
    $flutter_transfer = flutterwave_transfer($loan_id, $get_loan_details['user_id'], $user_approved_amount);
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

function get_total_loan($loan_type){
  global $dbc;
  $loan_type = secure_database($loan_type);
  $get_loan_category = get_one_row_from_one_table_by_id('loan_category','type', $loan_type, 'date_created');
  $loan_category =$get_loan_category['unique_id'];
  $get_total_loan = "SELECT SUM(loan_amount) as `amount` FROM `user_loan_details` WHERE `loan_category_id` = '$loan_category'";
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


function update_db($table, $unique_id, $param, $validate_value, array $data){
  global $dbc;
  $table = secure_database($table);
  $unique_id = secure_database($unique_id);
  $emptyfound = 0;
  $check = check_record_by_one_param($table,$param,$validate_value);
  if($check === true){
    return  json_encode(["status"=>"0", "msg"=>"Record already exists"]);
  }
  else{
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
  $redirect_url = "http://zennal.staging.cloudware.ng/online_generation_callback.php";
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
 //echo $response = curl_exec($curl);
  
  // Close cURL session
  curl_close($curl);

 $response_dec = json_decode($response,true);
 $response_status = $response_dec['status'];
 $response_message = $response_dec['message'];
 $transfer_id = $response_dec['data']['id'];
}


function insert_payment_transaction($user_id, $tx_ref, $transaction_id){
  global $dbc;
  $user_id = secure_database($user_id);
  $tx_ref = secure_database($tx_ref);
  $unique_id = unique_id_generator($tx_ref.$user_id);
  if($user_id == '' || $tx_ref == ''){
    return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
  }
  else{
    $insert_data_sql = "INSERT INTO `online_bank_statement` SET `unique_id` = '$unique_id', `user_id` = '$user_id', `transaction_ref` = '$tx_ref', `transaction_id` = '$transaction_id', `use_status` = 0, `date_created` = now()";
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
  $unique_id1 = unique_id_generator($user_id);
  $unique_id2 = unique_id_generator($user_id.rand(0000, 9999));
  $guarantor_name1 = $guarantor_array['guarantor_name1'];
  $home_address1 = $guarantor_array['home_address1'];
  $phone_number1 = $guarantor_array['phone_number1'];
  $name_of_organization1 = $guarantor_array['name_of_organization1'];
  $address_of_organization1 = $guarantor_array['address_of_organization1'];
  $guarantor_name2 = $guarantor_array['guarantor_name2'];
  $home_address2 = $guarantor_array['home_address2'];
  $phone_number2 = $guarantor_array['phone_number2'];
  $name_of_organization2 = $guarantor_array['name_of_organization2'];
  $address_of_organization2 = $guarantor_array['address_of_organization2'];
  $loan_id = $guarantor_array['loan_id'];

  if($user_id == '' || $unique_id1 == '' || $unique_id2 == '' || $guarantor_name1 == '' || $home_address1 == '' || $phone_number1 == '' || $name_of_organization1 == '' || $address_of_organization1 == '' || $guarantor_name2 == '' || $home_address2 == '' || $phone_number2 == '' || $name_of_organization2 == '' || $address_of_organization2 == ''){
    return json_encode(["status"=>"0", "msg"=>"Empty field(s) Found"]);
  }
  else{
    $insert_data_sql1 = "INSERT INTO `user_guarantor` SET `unique_id` = '$unique_id1', `user_id` = '$user_id',  `guarantor_name`='$guarantor_name1', `home_address`='$home_address1', `phone_number`='$phone_number1', `name_of_organization`='$name_of_organization1', `address_of_organization`='$address_of_organization1', `date_created` = now()";
    $insert_data_sql2 = "INSERT INTO `user_guarantor` SET `unique_id` = '$unique_id2', `user_id` = '$user_id',  `guarantor_name`='$guarantor_name2', `home_address`='$home_address2', `phone_number`='$phone_number2', `name_of_organization`='$name_of_organization2', `address_of_organization`='$address_of_organization2', `date_created` = now()";
    $insert_data_query1 = mysqli_query($dbc, $insert_data_sql1);
    $insert_data_query2 = mysqli_query($dbc, $insert_data_sql2);
    if($insert_data_query1 AND $insert_data_query2){
      //return json_encode(["status"=>"1", "msg"=>"success"]);
      $get_loan_details = get_one_row_from_one_table_by_id('asset_finance_application', 'unique_id', $loan_id, 'date_created');
      $get_product = get_one_row_from_one_table_by_id('products', 'unique_id', $get_loan_details['product_id'], 'date_created');
      $user_approved_equity_con = $get_loan_details['user_approved_equity_con'];
      $equity_amount = ($user_approved_equity_con / 100) * $get_product['price'];
      $redirect_url = "http://localhost/zennal/asset_callback.php";
      $checkout = flutterwave_checkout($user_id, $equity_amount, $redirect_url);
      $checkout_decode = json_decode($checkout, true);
      if($checkout_decode['status'] == "1"){
        return json_encode(["status"=>"1", "msg"=>$checkout_decode['msg']]);
      }
      else{
        return json_encode(["status"=>"0", "msg"=>$checkout_decode['msg']]);
      }
    }else{
      return json_encode(["status"=>"0", "msg"=>"Some Error occured"]);
    }
  }
}

function get_user_bank_statement($loan_id){
  $get_bank_statement = get_one_row_from_one_table_by_id('okra_test','loan_id', $loan_id, 'date_received');
  $received_json = $get_bank_statement['received_json'];
  $decode_received_json = json_decode($received_json, true);
  //$callback_url = $decode_received_json['callback_url'];
  $record_id = $decode_received_json['record'];
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
  $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8',       false);
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


function get_insurance_quote($post_data){
    
    // Prepare json structure
    
    $curl = curl_init();
    
    $data = array(
        $form_data=>null
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
    
    $response = curl_exec($curl);
    curl_close($curl);
}


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

/////// MOST IMPORTANT FUNCTIONS END HERE



//////////////////////////////not needed for now
