<?php 
  include("includes/sidebar.php");
  $unique_id = isset($_GET['unique_id']) ? $_GET['unique_id'] : '';
  $get_payment_details = calculate_change_vehicle_ownership($unique_id);
  $get_payment_details_decode = json_decode($get_payment_details, true);
  $vehicle_registration_fee = $get_payment_details_decode['change_of_ownership_fee'];
  $get_delivery_fee = get_one_row_from_one_table('delivery_fee', 'delivery_for', 'vehicle_registration');
  $delivery_fee = $get_delivery_fee['fee'];
  $get_change_of_ownership_fee = get_one_row_from_one_table('services', 'service', 'Change of ownership');
  $change_of_ownership_fee = $get_change_of_ownership_fee['cost'];
  $subtotal = $change_of_ownership_fee + $vehicle_registration_fee;
  $total = $subtotal + $delivery_fee;
  $get_user_wallet_balance = get_one_row_from_one_table('wallet', 'user_id', $user_id);
  $wallet_balance = ($get_user_wallet_balance != null) ? $get_user_wallet_balance['balance'] : 0;
?>
<div id="main">

<?php include("includes/header.php");?>
<style type="text/css">
#bar, #physical, .remove-coupon {display:none;}
</style>

<div class="main-content container-fluid" id="appWrapper" v-cloak>
  <div class="page-title">
    <h3>Complete your Order</h3>
    <p class="text-subtitle text-muted">Select fill all the details below</p>
  </div>


  <section class="section mt-5" id="multiple-column-form ">
    <div class="row match-height">
      <div class="col-6 mx-auto">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <form class="form" method="post" id="proceed_to_payment_form">
                <input type="hidden" name="service_type" id="service_type" value="change_of_ownership">
              <div class="row">
                <div class="col-md-12 col-12">
                  <h4 class="card-title mt-3 mb-3">Type of Delivery</h4>
                  <div class="form-group">
                    <select  name="thename" class="form-select delivery_type" onChange="show('bar', this.options[this.selectedIndex].firstChild.nodeValue)">
                      <option selected>--- Delivery Type ---</option>
                      <option value="email">Email Delivery</option>
                      <option value="physical">Physical Delivery</option>
                    </select>
                  </div>

                  <div id="bar" class="order-area">
                    <div class="form-group">
                      <input type="email" name="email" class="form-control" placeholder="johndoe@gmail.com">
                    </div>

                    <div class="form-group">
                        <!-- coupon_code -->
                        <input type="text" name="coupon_field" id="" class="form-control" placeholder="Coupon Code" v-model="couponCodeEmail">
                        <p>
                            <i class="coupon_code_help_txt">
                                {{couponErrorMessageEmail}}
                            </i>
                        </p>
                        <button type="button" class="btn btn-primary mt-2"
                        @click="applyCouponCodeEmail('change_ownership')"
                        v-if="showApplyCouponBtnEmail">
                            Apply Code
                        </button>

                        <button type="button" class="btn btn-danger mt-2"
                        @click="removeCouponCodeEmail"
                        v-if="showRemoveCouponBtnEmail">
                            Remove Coupon
                        </button>
                    </div>

                    <h4 class="card-title mt-5">Order Summary</h4>

                    <div class="table-responsive">
                        <table class="table mb-0">
                            <tbody>
                                <tr>
                                    <td class="text-bold-500 text-blue">Change of vehicle ownership</td>
                                    <td>1</td>
                                    <td class="text-bold-500 text-dark">&#8358;<?= number_format($change_of_ownership_fee)?></td>
                                </tr>
                                <tr>
                                    <td class="text-bold-500 text-blue">Vehicle Registration</td>
                                    <td>1</td>
                                    <td class="text-bold-500 text-dark">&#8358;<?= number_format($vehicle_registration_fee)?></td>
                                </tr>
                                <tr>
                                    <td class="text-bold-500 text-blue">Sub Total</td>
                                    <td></td>
                                    <td class="text-bold-500 text-dark">&#8358;<?= number_format($subtotal)?></td>
                                </tr>
                                <tr>
                                    <td class="text-bold-500 text-blue">Coupon Discount</td>
                                    <td></td>
                                    <td class="text-bold-500 text-dark">
                                        <span>
                                            {{couponDiscountEmail | displayedCouponDiscount}}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-bold-500 text-blue"><input type="checkbox" class="form-check-input form-check-secondary"  name="remove_from_wallet" v-model="removeFromWalletEmail"> 
                                    Remove from my Zennal Wallet
                                    </td>
                                    <td></td>
                                    <td class="text-bold-500 text-dark">
                                        <span>
                                            {{remainingWalletBalanceEmail | displayNairaReadableMoney}}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-bold-500 text-blue">Total</td>
                                    <td></td>
                                    <td class="text-bold-500 text-dark">
                                        <span>
                                            {{amountToPayEmail | displayNairaReadableMoney}}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="form-group">
                      <select  name="thename" class="form-select" >
                      <option selected>--- Payment Option ---</option>
                      <option value="one">One time Payment</option>
                      <option value="green">On installment</option>
                      </select>
                    </div>    

                    <div  class="one box">      
                      <div class="col-12 d-flex justify-content-end">
                        <button type="button" id="proceed_to_payment" class="btn btn-primary mr-1 mb-1">Proceed</button>
                      </div>
                    </div>
                    <div  class="green box">      
                      <div class="col-12 mt-3 d-flex justify-content-end">
                        <a href="vehicle_reg_loan?reg_id=<?= $unique_id;?>" class="btn btn-primary mr-1 mb-1">Proceed</a>
                      </div>
                    </div>
                  </div>
                </form>

                  <!--  -->
                  <form class="form" method="post" id="proceed_to_payment_form2">
                    <input type="hidden" name="service_type" id="service_type" value="change_of_ownership">
                  <div id="physical" class="order-area">
                    <div class="form-group">
                     <select class="form-select" id="city" name="city">
                      <option value="">Select your city</option>
                      <option value="Lagos">Lagos</option>
                    </select>
                    </div>
                    <div class="form-group">
                      <select class="form-select" id="delivery_area" name="delivery_area">
                        <option value="">Select delivery area</option>
                        <option value="Somolu">Somolu</option>
                        <option value="Ojo">Ojo</option>
                        <option value="Apapa">Apapa</option>
                        <option value="Ikeja">Ikeja</option>
                        <option value="Surulere">Surulere</option>
                        <option value="Ifako Ijaye">Ifako Ijaye</option>
                        <option value="Lagos Mainland">Lagos Mainland</option>
                        <option value="Oshodi">Oshodi</option>
                        <option value="Kosofe">Kosofe</option>
                        <option value="Ibeju Lekki">Ibeju Lekki</option>
                        <option value="Ajeromi">Ajeromi</option>
                        <option value="Ikorodu">Ikorodu</option>
                        <option value="Alimosho">Alimosho</option>
                        <option value="Agege">Agege</option>
                        <option value="Eti-osa">Eti-osa</option>
                        <option value="Badagry">Badagry</option>
                        <option value="Lagos Island">Lagos Island</option>
                        <option value="Mushin">Mushin</option>
                        <option value="Epe">Epe</option>
                        <option value="Festac">Festac</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Enter delivery address" id="delivery_address" name="delivery_address">
                    </div>

                    <div class="form-group">
                        <input type="text" name="coupon_code" id="coupon_code2" class="form-control" placeholder="Enter Coupon Code" v-model="couponCode">
                            <p>
                                <i class="coupon_code_help_txt">
                                    {{couponErrorMessage}}
                                </i>
                            </p>
                            <button type="button" class="btn btn-primary mt-2"
                            @click="applyCouponCode('change_ownership')"
                            v-if="showApplyCouponBtn">
                                Apply Code
                            </button>

                            <button type="button" class="btn btn-danger mt-2"
                            @click="removeCouponCode"
                            v-if="showRemoveCouponBtn">
                                Remove Coupon
                            </button>
                    </div>

                    <h4 class="card-title mt-5">Order Summary</h4>

                    <div class="table-responsive">
                      <table class="table mb-0">
                        <tbody>
                          <tr>
                            <td class="text-bold-500 text-blue">Change of vehicle ownership</td>
                            <td>1</td>
                            <td class="text-bold-500 text-dark">&#8358;<?= number_format($change_of_ownership_fee)?></td>
                          </tr>
                          <tr>
                            <td class="text-bold-500 text-blue">Vehicle Registration</td>
                            <td>1</td>
                            <td class="text-bold-500 text-dark">&#8358;<?= number_format($vehicle_registration_fee)?></td>
                          </tr>
                          <tr>
                            <td class="text-bold-500 text-blue">Sub Total</td>
                            <td></td>
                            <td class="text-bold-500 text-dark">&#8358;<?= number_format($subtotal)?></td>
                          </tr>
                          <tr>
                            <td class="text-bold-500 text-blue">Coupon Discount</td>
                            <td></td>
                            <td class="text-bold-500 text-dark">
                                <span>
                                    {{couponDiscount | displayedCouponDiscount}}
                                </span>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-bold-500 text-blue">Delivery Fee</td>
                            <td></td>
                            <td class="text-bold-500 text-dark">&#8358;<?= number_format($delivery_fee)?></td>
                          </tr>
                          <tr>
                            <td class="text-bold-500 text-blue">
                                <input type="checkbox" class="form-check-input form-check-secondary"  name="remove_from_wallet" v-model="removeFromWallet"> 
                                Remove from my Zennal Wallet
                            </td>
                            <td></td>
                            <td class="text-bold-500 text-dark">
                                <span>
                                    {{remainingWalletBalance | displayNairaReadableMoney}}
                                </span>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-bold-500 text-blue">Total</td>
                            <td></td>
                            <td class="text-bold-500 text-dark">
                                <span>
                                    {{amountToPay | displayNairaReadableMoney}}
                                </span>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>

                    <div class="form-group">
                      <select  name="thename" class="form-select" >
                        <option selected>--- Payment Option ---</option>
                        <option value="one">One time Payment</option>
                        <option value="green">On installment</option>
                      </select>
                    </div>                                    

                    <div  class="one box">      
                      <div class="col-12 mt-3 d-flex justify-content-end">
                         <button type="button" id="proceed_to_payment2" class="btn btn-primary mr-1 mb-1">Proceed</button>
                      </div>
                    </div>
                    <div  class="green box">      
                      <div class="col-12 mt-3 d-flex justify-content-end">
                        <a href="vehicle_reg_loan?reg_id=<?= $unique_id;?>" class="btn btn-primary mr-1 mb-1">Proceed</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>
</div>
<?php include("includes/footer.php");?>
<?php include("includes/VueInstanceCoupon.php");?>

<script>
function show(el, txt){
  var elem1 = document.getElementById('bar');
  var elem2 = document.getElementById('physical');

  elem1.style.display = (txt == 'Email Delivery') ? 'block' : 'none';
  elem2.style.display = (txt == 'Physical Delivery') ? 'block' : 'none';
}
</script>  
<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
<script>
  function formatNumber(num) {
    num = ""+num;
    return num.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
  }
  $(document).ready(function(){
    $("select").change(function(){
      $(this).find("option:selected").each(function(){
        var optionValue = $(this).attr("value");
        if(optionValue){
          $(".box").not("." + optionValue).hide();
          $("." + optionValue).show();
        } 
        else{
          $(".box").hide();
        }
      });
    }).change();

    // $("#remove_from_wallet2").click(function(){
    //   var wallet_balance = parseInt($("#wallet_balance2").val());
    //   var total = $("#total2").val();
    //   var initial_total = $("#initial_total2").val();
    //   if($('#remove_from_wallet2').is(':checked')){
    //     if(parseInt(wallet_balance) > parseInt(total)){
    //       var new_total = 0;
    //       $("#new_total2").html(formatNumber(0));
    //       $("#total2").val(new_total);
    //     }
    //     else{
    //       // var new_total = parseInt(total - wallet_balance);
    //       new_total = parseInt(total + wallet_balance)
    //       $("#new_total2").html(formatNumber(new_total));
    //       $("#total2").val(new_total);

    //     if( parseInt(wallet_balance) > parseInt(total) ){
    //         var new_total = 0;
    //         $("#new_total2").html(formatNumber(0));
    //       }else{
    //         var new_total = parseInt(total) - parseInt(wallet_balance);
        
    //         $("#new_total2").html(formatNumber(new_total));
    //     }
    //   }
    //   else{
    //     $("#new_total2").html(formatNumber(initial_total));
    //     $("#total2").val(initial_total);
    //     removeFromWallet = 0;
    //     if(couponApplied == 1){
    //       if(parseInt(currentTotal) > 0){
    //         total = parseInt(currentTotal)
    //       }
    //       total = parseInt(total) + parseInt(wallet_balance)
    //     }else{
    //       console.log("Got here", total);
    //       total = parseInt(total) + parseInt(wallet_balance)
    //     }
    //     $("#new_total2").html(formatNumber(parseInt(total)));
    //     currentTotal = parseInt(total);
    //     // $("#total").val(total);
    //   }
    // });

    // $("#apply_coupon_code2").click(function(){
    //     var coupon_code = $("#coupon_code2").val();
    //     var total = $("#total2").val();
    //     if(coupon_code == ''){
    //       alert("Please enter coupon code");
    //     }
    //     else{
    //       $.ajax({
    //         url: "ajax/apply_coupon_code.php",
    //         method: "POST",
    //         data: {coupon_code, total},
    //         beforeSend: function(){
    //           $("#apply_coupon_code2").attr("disabled", true);
    //           $("#apply_coupon_code2").text("Applying...");
    //         },
    //         success: function(data){
    //           if(data['status'] == "success"){


    //             // $("#coupon_discount2").html(data['discount']);
    //             // $("#couponDiscountMinusSign2").hide();
    //             // $("#new_total2").html(data['total']);
    //             // $("#total2").val(data['total_without_format']);
    //             // $("#initial_total2").val(data['total_without_format']);
    //             // $("#apply_coupon_code2").attr("disabled", true);
    //             // $("#apply_coupon_code2").text("Applied");
    //           } 
    //           else{
    //             Swal.fire({
    //             title: "Error!",
    //             text: data['status'],
    //             icon: "error",
    //             });
    //             $("#apply_coupon_code2").attr("disabled", false);
    //             $("#apply_coupon_code2").text("Apply");
    //           }
    //         }
    //       })
    //     }
    // });

    // $("#proceed_to_payment2").click(function(e){
    //   e.preventDefault();
    //   $('#proceed_to_payment2').attr('disabled', true);
    //   $('#proceed_to_payment2').text('Please wait...');
    //   var total = $("#total2").val();
    //   var reg_id = $("#reg_id2").val();
    //   if(total != 0){
    //     $.ajax({
    //       url:"ajax/check_veh_reg_exist.php",
    //       method: "POST",
    //       data: {reg_id},
    //       success: function(data){
    //         // alert(data);
    //         if(data == "false"){
    //           Okra.buildWithOptions({
    //             name: 'Cloudware Technologies',
    //             env: 'production-sandbox',
    //             key: 'a804359f-0d7b-52d8-97ca-1fb902729f1a',
    //             token: '5f5a2e5f140a7a088fdeb0ac', 
    //             source: 'link',
    //             color: '#ffaa00',
    //             limit: '24',
    //             // amount: 5000,
    //             // currency: 'NGN',
    //             garnish: true,
    //             charge: {
    //               type: 'one-time',
    //               amount: parseInt(total*100),
    //               note: '',
    //               currency: 'NGN',
    //               account: '5ecfd65b45006210350becce'
    //             },
    //             corporate: null,
    //             connectMessage: 'Which account do you want to connect with?',
    //             products: ["auth", "transactions", "balance"],
    //             //callback_url: 'http://localhost/new_zennal/online_generation_callback?payment_id='+,
    //             //callback_url: 'http://zennal.staging.cloudware.ng/okra_callback.php',
    //             //redirect_url: 'http://getstarted.naicfund.ng/zennal_redirect.php',
    //             logo: 'https://cloudware.ng/wp-content/uploads/2019/12/CloudWare-Christmas-Logo.png',
    //             filter: {
    //                 banks: [],
    //                 industry_type: 'all',
    //             },
    //             widget_success: 'Your account was successfully linked to Cloudware Technologies',
    //             widget_failed: 'An unknown error occurred, please try again.',
    //             currency: 'NGN',
    //             exp: null,
    //             success_title: 'Cloudware Technologies!',
    //             success_message: 'You are doing well!',
    //             onSuccess: function (data) {
    //               console.log('success', data);
    //               $.ajax({
    //                 url:"ajax/one_time_payment.php",
    //                 method: "POST",
    //                 data: $("#proceed_to_payment_form").serialize(),
    //                 success: function(data){
    //                   //alert(data);
    //                   if(data['status'] == "success"){
    //                     Swal.fire({
    //                       title: "Congratulations!",
    //                       text: "Your payment was successful",
    //                       icon: "success",
    //                     }).then(setTimeout( function(){ window.location.href = "index"}, 3000));
    //                   }
    //                   else{
    //                     Swal.fire({
    //                       title: "Error!",
    //                       text: data['status'],
    //                       icon: "error",
    //                     });
    //                   }
    //                   $('#proceed_to_payment').attr('disabled', false);
    //                   $('#proceed_to_payment').text('Proceed');
    //                 }
    //               })
    //             },
    //           onClose: function () {
    //             console.log('closed');
    //             $('#proceed_to_payment').attr('disabled', false);
    //             $('#proceed_to_payment').text('Proceed');
    //           }
    //         })
    //         }
    //         else{
    //           Swal.fire({
    //             title: "Error!",
    //             text: "Record Exists",
    //             icon: "error",
    //           });
    //         }
    //         $('#proceed_to_payment').attr('disabled', false);
    //         $('#proceed_to_payment').text('Proceed');
    //       }
    //     })
    //   }
    //   else{
    //     $.ajax({
    //       url:"ajax/one_time_payment.php",
    //       method: "POST",
    //       data: $("#proceed_to_payment_form").serialize(),
    //       success: function(data){
    //         //alert(data);
    //         if(data['status'] == "success"){
    //           Swal.fire({
    //                     title: "Congratulations!",
    //                     text: "Your payment was successful",
    //                     icon: "success",
    //                 }).then(setTimeout( function(){ window.location.href = "index"}, 3000));
    //         }
    //         else{
    //           Swal.fire({
    //                         title: "Error!",
    //                         text: data['status'],
    //                         icon: "error",
    //                     });
    //         }
    //         $('#proceed_to_payment').attr('disabled', false);
    //         $('#proceed_to_payment').text('Proceed');
    //       }
    //     })
    //   }
    // })

  });
</script>


