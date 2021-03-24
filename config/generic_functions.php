<?php
$table = "";
$app_name = 'Whatsapp Lending Platform';
require_once("config_settings.php");
//require_once("db_connect.php");

// function pulling_json(){
//    $array = array(
//     'status'=>true,
//     'message'=> 'BVN resolved',
//     'data'=> array(
//         "first_name": "OLUSOLA",
//         "last_name": "ADEBUNMI",
//         "dob": "03-Sep-58",
//         "formatted_dob": "1950-08-03",
//         "mobile": "08168509044",
//         "bvn": "22225553718"
//     ),
//     'meta'=>array(
//         "calls_this_month": 3,
//         "free_calls_left": 7
//     )
//    );

//    return json_encode($array);
// }
/////LOG API CALLS



function validate_email($email){
          return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) ?  json_encode(array( "status"=>100, "msg"=>"Sorry, kindly enter a valid email address" )) :  json_encode(array( "status"=>111, "msg"=>"valid" )) ;
   
}

function validate_phone($phone) {
    $count = strlen((string) $phone);
    $pattern = '/^234[0-9]{10}/';
    $pattern2 = '/^[0-9]{11}/';
    

    if(is_numeric($phone)){
             if($count == 11){
           
              return !preg_match($pattern2,$phone) ?  json_encode(array( "status"=>100, "msg"=>"Sorry, kindly enter a valid phone number22" )) :  json_encode(array( "status"=>111, "msg"=>"valid" )) ;
             }

             else if($count == 13){
              return !preg_match($pattern,$phone) ?  json_encode(array( "status"=>100, "msg"=>"Sorry, kindly enter a valid phone number999" )) :  json_encode(array( "status"=>111, "msg"=>"valid" )) ;

             }


            else{

              return json_encode(array( "status"=>100, "msg"=>"incorrect phone digits, kindly check and try again." )) ;

            }
      }else{
                 return json_encode(array( "status"=>100, "msg"=>"Sorry, kindly enter a valid phone number" ));

      }

}




///enter bank to get code before account number
function validate_acctno($acctno,$bankcode){
   global $secret_key;

    //$bankcode parameter is the selection on the chat builder

   ///check bankcode selection to get real bankcode
   // $get_real_bank_code = get_bank_name($bankcode);
   // $bankcode_dec = json_decode($get_real_bank_code,true);
   // if($bankcode_dec['status'] != 111){
          
   //      return json_encode(array( "status"=>100, "msg"=>"wrong bank code option entered" ));          

   // }else{
         
   //       $real_bank_code = $bankcode_dec['bankcode'];
   // }
   ///check bankcode selection to get real bankcode




   $count = strlen((string) $acctno);

       if(is_numeric($acctno)){
             if($count == 10){
                 //return json_encode(array( "status"=>111, "msg"=>"valid" ));   
                 ///now check if this account number actually exists
                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.paystack.co/bank/resolve?account_number=".$acctno."&bank_code=".$bankcode."",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer ".$secret_key
                ),
                ));

                $response = curl_exec($curl);

                curl_close($curl); 

                //return $response;
                $decode_response = json_decode($response,true);
          
               if($decode_response['status'] == true){
                    return json_encode(array( "status"=>111, "msg"=>$decode_response['data'] ));

                }else{
                    return json_encode(array( "status"=>100, "msg"=>$decode_response['message'] ));

               }

             }else{
                 
                 return json_encode(array( "status"=>102, "msg"=>"account number should have 10 digits, kindly check and try again" ));          

             }

       

       }else{
                 return json_encode(array( "status"=>100, "msg"=>"Sorry, kindly enter a valid account number" ));
       }

}


function get_bank_name_old($id){
    if($id == 1){
                 return json_encode(array( "status"=>111, "bankcode"=>"044", "bankname"=>"Access Bank Plc"  ));         
    }
    else if($id == 2){
                 return json_encode(array( "status"=>111, "bankcode"=>"070",  "bankname"=>"Fidelity Bank Plc" ));         
    }
    else if($id == 3){
                 return json_encode(array( "status"=>111, "bankcode"=>"214", "bankname"=>"First City Monument Bank Limited" ));         
    }
   else if($id == 4){
                 return json_encode(array( "status"=>111, "bankcode"=>"011", "bankname"=>"First Bank of Nigeria Limited" ));         
    }
   else if($id == 5){
                 return json_encode(array( "status"=>111, "bankcode"=>"058", "bankname"=>"Guaranty Trust Bank Plc" ));         
    }
   else if($id == 6){
                 return json_encode(array( "status"=>111, "bankcode"=>"032", "bankname"=>"Union Bank of Nigeria Plc" ));         
    }
   else if($id == 7){
                 return json_encode(array( "status"=>111, "bankcode"=>"032", "bankname"=>"United Bank for Africa Plc" ));         
    }
  else  if($id == 8){
                 return json_encode(array( "status"=>111,"bankcode"=>"057", "bankname"=>"Zenith Bank Plc" ));         
    }
   else if($id == 9){
                 return json_encode(array( "status"=>111, "bankcode"=>"023", "bankname"=>"Citibank Nigeria Limited" ));         
    }
 
  else if($id == 10){
                 return json_encode(array( "status"=>111, "bankcode"=>"050", "bankname"=>"Ecobank Nigeria Plc" ));         
    }
  else if($id == 11){
                 return json_encode(array( "status"=>111, "bankcode"=>"030", "bankname"=>"Heritage Banking Company Limited" ));         
    }
  else if($id == 12){
                 return json_encode(array( "status"=>111,"bankcode"=>"082", "bankname"=>"Keystone Bank Limited" ));         
    }
   else if($id == 13){
                  return json_encode(array( "status"=>111, "bankcode"=>"068", "bankname"=>"Standard Chartered Bank" ));         
     }
  else if($id == 14){
                 return json_encode(array( "status"=>111, "bankcode"=>"221", "bankname"=>"Stanbic IBTC Bank Plc" ));         
    }
 else if($id == 15){
                 return json_encode(array( "status"=>111, "bankcode"=>"232", "bankname"=>"Sterling Bank Plc" ));         
    }

  // else if($id == 16){
  //                return json_encode(array( "status"=>111, "bankcode"=>"022", "bank"=>"Titan Trust Bank Limited" ));         
  //   }
   else if($id == 16){
                 return json_encode(array( "status"=>111, "bankcode"=>"215", "bankname"=>"Unity Bank Plc" ));         
    }
   else if($id == 17){
                 return json_encode(array( "status"=>111, "bankcode"=>"035","bankname"=>"Wema Bank Plc" ));         
    } 


    else{
                 return json_encode(array( "status"=>100,"bankcode"=>"000000", "bankname"=>"Oops, kindly select a correct option" ));    

    }
 
}


function get_bank_name($id){
    if($id == 44){
                 return json_encode(array( "status"=>111, "bankcode"=>"044", "bankname"=>"Access Bank Plc"  ));         
    }
    else if($id == 70){
                 return json_encode(array( "status"=>111, "bankcode"=>"070",  "bankname"=>"Fidelity Bank Plc" ));         
    }
    else if($id == 214){
                 return json_encode(array( "status"=>111, "bankcode"=>"214", "bankname"=>"First City Monument Bank Limited" ));         
    }
   else if($id == 11){
                 return json_encode(array( "status"=>111, "bankcode"=>"011", "bankname"=>"First Bank of Nigeria Limited" ));         
    }
   else if($id == 58){
                 return json_encode(array( "status"=>111, "bankcode"=>"058", "bankname"=>"Guaranty Trust Bank Plc" ));         
    }
   else if($id == 32){
                 return json_encode(array( "status"=>111, "bankcode"=>"032", "bankname"=>"Union Bank of Nigeria Plc" ));         
    }
   else if($id == 33){
                 return json_encode(array( "status"=>111, "bankcode"=>"032", "bankname"=>"United Bank for Africa Plc" ));         
    }
  else  if($id == 57){
                 return json_encode(array( "status"=>111,"bankcode"=>"057", "bankname"=>"Zenith Bank Plc" ));         
    }
   else if($id == 23){
                 return json_encode(array( "status"=>111, "bankcode"=>"023", "bankname"=>"Citibank Nigeria Limited" ));         
    }
 
  else if($id == 50){
                 return json_encode(array( "status"=>111, "bankcode"=>"050", "bankname"=>"Ecobank Nigeria Plc" ));         
    }
  else if($id == 30){
                 return json_encode(array( "status"=>111, "bankcode"=>"030", "bankname"=>"Heritage Banking Company Limited" ));         
    }
  else if($id == 82){
                 return json_encode(array( "status"=>111,"bankcode"=>"082", "bankname"=>"Keystone Bank Limited" ));         
    }
   else if($id == 68){
                  return json_encode(array( "status"=>111, "bankcode"=>"068", "bankname"=>"Standard Chartered Bank" ));         
     }
  else if($id == 221){
                 return json_encode(array( "status"=>111, "bankcode"=>"221", "bankname"=>"Stanbic IBTC Bank Plc" ));         
    }
 else if($id == 232){
                 return json_encode(array( "status"=>111, "bankcode"=>"232", "bankname"=>"Sterling Bank Plc" ));         
    }

  // else if($id == 16){
  //                return json_encode(array( "status"=>111, "bankcode"=>"022", "bank"=>"Titan Trust Bank Limited" ));         
  //   }
   else if($id == 214){
                 return json_encode(array( "status"=>111, "bankcode"=>"215", "bankname"=>"Unity Bank Plc" ));         
    }
   else if($id == 25){
                 return json_encode(array( "status"=>111, "bankcode"=>"035","bankname"=>"Wema Bank Plc" ));         
    } 


    else{
                 return json_encode(array( "status"=>100,"bankcode"=>"000000", "bankname"=>"Oops, kindly select a correct option" ));    

    }
 
}


function validate_other_info_with_bvn($bvn,$first_name,$last_name,$phone){
   global $secret_key;
   $validate_only_bvn = validate_only_bvn($bvn);
   $decode_only_bvn = json_decode($validate_only_bvn,true);

    if($decode_only_bvn['status'] != 111 ){
        //carry out first time bvn test and display error
        return $validate_only_bvn;

    }else{

          if($bvn == '' ||  $first_name == '' ||  $last_name == '' ||  $phone == ''  ){
          return json_encode(array( "status"=>100, "msg"=>"empty field(s) found" ));          
          } 
          else{

                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.paystack.co/bank/resolve_bvn/".$bvn."",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer ".$secret_key
                ),
                ));

               $response = curl_exec($curl);

               curl_close($curl);

               //return $response;

               $decode_response = json_decode($response,true);
          
              if($decode_response['status']){

                  $first_name_ps =  strtolower($decode_response['data']['first_name']);         
                  $last_name_ps=  strtolower($decode_response['data']['last_name']);
                  $first_name =  strtolower($first_name);
                  $last_name =  strtolower($last_name);
                  $phone_ps =  $decode_response['data']['mobile'];
                  $bvn_ps =  $decode_response['data']['bvn'];

                  if(  $phone_ps != $phone ||  $bvn_ps != $bvn || $last_name_ps != $last_name ) {
                        return json_encode(array( "status"=>100, "msg"=>"Sorry ".$first_name.", we will not be able to continue with your registration because the BVN entered does not match your credentials." ));///this should log into the db to note that this person made a wrong attempt before          

                  }else{

                      return json_encode(array( "status"=>111, "msg"=>"success" ));

                  }
                

     
                }else{
                
                    return json_encode(array( "status"=>100, "msg"=>$decode_response['message'] ));
                
                }

          

          
          }


    }
 
  

}




function validate_only_bvn($bvn){
       $count = strlen((string) $bvn);

       if(is_numeric($bvn)){
             if($count == 11){
                 return json_encode(array( "status"=>111, "msg"=>"valid" ));          

             }else{
                 
                 return json_encode(array( "status"=>102, "msg"=>"BVN should have 11 digits, kindly check and try again." ));          

             }

       

       }else{
                 return json_encode(array( "status"=>100, "msg"=>"Sorry, kindly enter a valid bvn" ));
       }

}

//Tosin's Functions

function list_of_banks(){
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
      "Authorization: Bearer $secret_key",
      "Cache-Control: no-cache",
    ),
  ));
  
  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);
  
  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    return $response;
  }
}

//ends here
//////////////////////////////not needed for now
