<?php include("includes/sidebar.php");
  $reg_id = isset($_GET['reg_id']) ? $_GET['reg_id'] : '';
  $get_payment_details = calculate_vehicle_registration($reg_id);
  $get_payment_details_decode = json_decode($get_payment_details, true);
  $vehicle_registration_charge = $get_payment_details_decode['service_charge'] + $get_payment_details_decode['number_plate_charge'];
  $insurance_charge = $get_payment_details_decode['insurance_charge'];
  $get_delivery_fee = get_one_row_from_one_table('delivery_fee', 'delivery_for', 'vehicle_registration');
  $delivery_fee = $get_delivery_fee['fee'];
  $subtotal = $vehicle_registration_charge + $insurance_charge;
  $total = $subtotal + $delivery_fee;
  $get_installment_details = get_rows_from_one_table('installment_payment_interest','date_created');
  // print_r($get_payment_details_decode);
  $get_user_wallet_balance = get_one_row_from_one_table('wallet', 'user_id', $user_id);
  $wallet_balance = ($get_user_wallet_balance != null) ? $get_user_wallet_balance['balance'] : 0;
?>
<div id="main">

<?php include("includes/header.php");?>
<style type="text/css">
#one, #on, .remove-coupon {display:none;}
</style>
     
<div class="main-content container-fluid">
  <div class="page-title">
    <h3>Complete your Order</h3>
    <p class="text-subtitle text-muted">Select fill all the details below</p>
  </div>
  <section class="section mt-5" id="multiple-column-form ">
    <div class="row match-height">
      <div class="col-7 mx-auto">
      <div class="card">
      <!-- <div class="card-header">
      <h4 class="card-title">Delivery Details</h4>
      </div> -->
      <div class="card-content order-area">
        <div class="card-body">
          <form class="form" method="post" id="proceed_to_payment_form">
            <input type="hidden" name="service_type" id="service_type" value="vehicle_registration">
            <div class="row">
              <h4 class="card-title">Delivery Details</h4>
              <div class="col-md-12 col-12">
                <div class="form-group">
                  <select class="form-select" id="city" name="city">
                    <option>Select your city</option>
                    <option value="Lagos">Lagos</option>
                  </select>
                </div>
                <div class="form-group">
                  <select class="form-select" id="delivery_area" name="delivery_area">
                    <option>Select delivery area</option>
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

                  <label>Coupon Code (if any)</label>
                  <input type="text" name="coupon_code" id="coupon_code" class="form-control coupon_field" placeholder="Enter Coupon Code">
                  <button type="button" class="btn btn-primary mt-2 coupon-btn" id="apply_coupon_code" data-total="<?= $total ?>" data-walletbalance="<?= $wallet_balance?>">Apply Code</button>

                  <button type="button" class="btn btn-danger mt-2 remove-coupon">Remove Coupon</button>

                </div>
                <h4 class="card-title mt-5">Order Summary</h4>
                <div class="table-responsive">
                  <table class="table mb-0">
                    <tbody>
                      <tr>
                        <td class="text-bold-500 text-blue">Vehicle Registration</td>
                        <td>1</td>
                      <td class="text-bold-500 text-dark">&#8358;<?= number_format($vehicle_registration_charge)?></td>
                      </tr>
                      <tr>
                        <td class="text-bold-500 text-blue">Insurance Fee</td>
                        <td></td>
                        <td class="text-bold-500 text-dark">&#8358;<?= number_format($insurance_charge)?></td>
                      </tr>
                      <tr>
                        <td class="text-bold-500 text-blue">Sub Total</td>
                        <td></td>
                        <td class="text-bold-500 text-dark">&#8358;<?= number_format($subtotal)?></td>
                      </tr>
                      <tr>
                        <td class="text-bold-500 text-blue">Coupon Discount</td>
                        <td></td>
                        <td class="text-bold-500 text-dark">&#8358;<span id="coupon_discount" class="coupon_discount">0</span></td>
                      </tr>
                      <tr>
                        <td class="text-bold-500 text-blue">Delivery Fee</td>
                        <td></td>
                        <td class="text-bold-500 text-dark">&#8358;<?= number_format($delivery_fee)?></td>
                      </tr>
                      <?php
                        if($wallet_balance != 0){
                          ?>
                          <tr>
                            <td class="text-bold-500 text-blue">
                              <input type="checkbox" class="form-check-input form-check-secondary"  name="remove_from_wallet" id="remove_from_wallet"> 
                              Remove from my Zennal Wallet
                            </td>
                            <td></td>
                            <td class="text-bold-500 text-dark">&#8358;<?= number_format($wallet_balance);?></td>
                            <input type="hidden" name="" id="wallet_balance" value="<?= $wallet_balance;?>">
                          </tr>
                      <?php
                        }
                      ?>
                      <tr>
                        <td class="text-bold-500 text-blue">Total</td>
                        <td></td>
                        <td class="text-bold-500 text-dark">&#8358;<span id="new_total" class="total_cost"><?php echo number_format($total)?></span></td>
                        <input type="hidden" name="total" id="total" value="<?= $total?>">
                        <input type="hidden" name="initial_total" id="initial_total" value="<?= $total?>">
                        <input type="hidden" name="reg_id" id="reg_id" value="<?= $reg_id?>">
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-body">
                      <div class="row">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                          <select name="payment_option" id="payment_option" class="form-select">
                            <option value="">Select Payment Option</option>
                            <option value="one_time">One time Payment</option>
                            <option value="installment">On Installment</option>
                          </select>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">    
                  <div id="show_payment_button" class="d-none">
                    <div class="col-12 d-flex justify-content-end">
                      <button type="button" id="proceed_to_payment" class="btn btn-primary mr-1 mb-1">Proceed</button>
                    </div>
                  </div>
                  <div id="show_installemt_payment" class="d-none">
                    <div class="col-12 d-flex justify-content-end">
                      <a href="vehicle_reg_loan?reg_id=<?= $reg_id;?>" class="btn btn-primary mr-1 mb-1">Proceed</a>
                    </div>
                    <!-- <h5>INSTALLMENT DETAILS</h5>
                    <small class="font-weight-bold">You are to pay 30% equity charge for any installment plan chosen</small>
                    <div class="" style="background-color: #e8f3ff; padding: 15px;">
                      <table class="table mb-0">
                        <thead>
                          <tr>
                            <th>Number of month</th>
                            <th>Interest Rate</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            // if($get_installment_details != null){
                            //   foreach ($get_installment_details as $details) {
                          ?>
                          
                            <tr>
                              <td class="text-bold-500 text-blue"></td>
                              <td></td>
                              <td class="text-bold-500 text-dark"></td>
                            </tr>
                          <?php //} }?>
                        </tbody>
                      </table>
                    </div> -->
                  </div>
                </div>
                <!-- <div class="col-md-12">    
                  <div  id="on">
                    <div class="col-12 mt-3 d-flex justify-content-end">
                      <a href="apply_loan.php" class="btn btn-primary">Proceed (₦ 21,000.00)</a>
                    </div>
                  </div>
                </div> -->
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

<script>
  function show(el, txt){
    var elem1 = document.getElementById('one');
    var elem2 = document.getElementById('on');

    elem1.style.display = (txt == 'One time Payment') ? 'block' : 'none';
    elem2.style.display = (txt == 'On Installement') ? 'block' : 'none';
  }
  $(document).ready(function(){
    $("#payment_option").change(function(){
      var selected_option = $(this).children("option:selected").val();
      $("#show_payment_button").addClass("d-none");
      $("#show_installemt_payment").addClass("d-none");
      if(selected_option == ''){
        alert("Please select an option");
      }
      else if(selected_option == 'one_time'){
        $("#show_payment_button").removeClass("d-none");
      }
      else if(selected_option == 'installment'){
        $("#show_installemt_payment").removeClass("d-none");
      }
    })
  })
</script>
            

