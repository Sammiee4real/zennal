
<?php include("includes/sidebar.php");?>
<div id="main">

<?php 
  include("includes/header.php");
  if(!isset($_GET['rec_id'])){
    echo "
    <script>window.location = `particulars`</script>";
  }
  $particulars_record_id = $_GET['rec_id'];

  $is_vehicle_permit = (isset($_GET['type']) && $_GET['type'] == 'vehicle_permit');
  if($is_vehicle_permit){
    $get_payment_details = calculate_vehicle_permit($particulars_record_id);
    $get_payment_details_decode = json_decode($get_payment_details, true);
  }else{
    $get_payment_details = calculate_renew_vehicle_particulars($particulars_record_id);
    $get_payment_details_decode = json_decode($get_payment_details, true);
    // $vehicle_registration_charge = $get_payment_details_decode['service_charge'] + $get_payment_details_decode['number_plate_charge'];
    // $insurance_charge = $get_payment_details_decode['insurance_charge'];
    // $get_delivery_fee = get_one_row_from_one_table('delivery_fee', 'delivery_for', 'vehicle_registration');
    // $delivery_fee = $get_delivery_fee['fee'];
    // $subtotal = $vehicle_registration_charge + $insurance_charge;
    // $total = $subtotal + $delivery_fee;
    // $get_installment_details = get_rows_from_one_table('installment_payment_interest','date_created');
    // print_r($get_payment_details_decode);
    
  }
  $get_user_wallet_balance = get_one_row_from_one_table('wallet', 'user_id', $user_id);
  $wallet_balance = ($get_user_wallet_balance != null) ? $get_user_wallet_balance['balance'] : 0;
?>
<style type="text/css">
#bar, #physical {display:none;}
</style>
<script>
function show(el, txt){
    var elem1 = document.getElementById('bar');
    var elem2 = document.getElementById('physical');

    elem1.style.display = (txt == 'Email Delivery') ? 'block' : 'none';
    elem2.style.display = (txt == 'Physical Delivery') ? 'block' : 'none';
    }
</script>  
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function(){
    $("select").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue){
                $(".box").not("." + optionValue).hide();
                $("." + optionValue).show();
            } else{
                $(".box").hide();
            }
        });
    }).change();
});
</script>


<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Complete your Order</h3>
        <p class="text-subtitle text-muted">Select fill all the details below</p>
    </div>


<section class="section mt-5" id="multiple-column-form ">
        <div class="row match-height">
            <div class="col-6 mx-auto">
                <div class="card">
                    <!-- <div class="card-header">
                        <h4 class="card-title">Delivery Details</h4>
                    </div> -->
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" action="">
                                <div class="row">
                                  <div class="col-md-12 col-12">
                                    <h4 class="card-title mt-3 mb-3">Type of Delivery</h4>
                                    <div class="form-group">
                                      <select  name="thename" id="delivery_type" class="form-select delivery_type" onChange="show('bar', this.options[this.selectedIndex].firstChild.nodeValue)">
                                      <option selected>--- Delivery Type ---</option>
                                      <option value="email">Email Delivery</option>
                                      <option value="physical">Physical Delivery</option>
                                      </select>
                                      <input type="hidden" id="record_id" name="record_id" value="<?= $particulars_record_id?>">
                                    </div>

                            <div id="bar">
                                 <div class="form-group">
                                   <input id="delivery-email" type="email" name="" class="form-control delivery-email" placeholder="johndoe@gmail.com">
                                </div>

                                <div class="form-group">
                                   <input type="text" name="" data-type="vehicle_permit" data-total="<?= $get_payment_details_decode['total'] ?>" data-particularsId="<?= $particulars_record_id ?>" class="form-control coupon_field" placeholder="Coupon Code">
                                   <i class="coupon_code_help_txt"></i>
                                </div>

    <h4 class="card-title mt-5">Order Summary</h4>
                                        
        <div class="table-responsive">
          <table class="table mb-0">
            <tbody>
              <tr>
                <?php
                  if($is_vehicle_permit){
                    echo '<td class="text-bold-500 text-blue">Vehicle Permit</td>';
                  }
                  else{
                    echo '<td class="text-bold-500 text-blue">Renew Vehicle Particulars</td>';
                  }
                ?>
                <td>1</td>
                <td class="text-bold-500 text-dark">₦<?= number_format($get_payment_details_decode['cost']) ?></td>
              </tr>
              <?php
              if(!$is_vehicle_permit){
                ?>
                <tr>
                  <td class="text-bold-500 text-blue">Insurance Cost</td>
                  <td></td>
                  <td class="text-bold-500 text-dark">₦<?= number_format($get_payment_details_decode['insurance_cost']) ?></td>
                </tr>
              <?php
              }?>
              <tr>
                <td class="text-bold-500 text-blue">Delivery Fee</td>
                <td></td>
                <td class="text-bold-500 text-dark">₦<?= number_format($get_payment_details_decode['delivery_fee']) ?></td>
              </tr>
              <tr>
                <td class="text-bold-500 text-blue">Sub Total</td>
                <td></td>
                <td class="text-bold-500 text-dark">₦<?= number_format($get_payment_details_decode['total']) ?></td>
              </tr>
              <tr>
                <td class="text-bold-500 text-blue">Coupon Discount</td>
                <td></td>
                <td class="text-bold-500 text-dark coupon_discount" id="coupon_discount">₦0.00</td>
              </tr>
              <tr>
                <td class="text-bold-500 text-blue"><input type="checkbox" class="form-check-input form-check-secondary remove_from_wallet"  name="customCheck2" id="remove_from_wallet"> Remove from my Zennal Wallet</td>
                <td></td>
                <td class="text-bold-500 text-dark">₦<?= number_format($wallet_balance)?></td>
              </tr>
              <tr>
                <td class="text-bold-500 text-blue">Total</td>
                <td></td>
                <td class="text-bold-500 text-dark total_cost" id="total_cost">₦<?= number_format($get_payment_details_decode['total']) ?></td>
              </tr>
            </tbody>
          </table>
        </div>

<div class="form-group">
    <select data-amount="<?= $get_payment_details_decode['total'] ?>" name="thename" class="form-select payment-option" >
       <option value="">--- Payment Option ---</option>
        <option value="one_time">One time Payment</option>
        <option value="installmemt">On installment</option>
    </select>
</div>    

    <div  class="one box">      
        <div class="col-12 mt-3 d-flex justify-content-end">
            <a href="apply_loan.php" type="submit" class="btn btn-primary mr-1 mb-1">Proceed (₦ 21,000.00)</a>
        </div>
   </div>
   <div  class="green box">      
        <div class="col-12 mt-3 d-flex justify-content-end">
            <a href="apply_loan.php" type="submit" class="btn btn-primary mr-1 mb-1">Proceed (₦ 21,000.00)</a>
        </div>
   </div>
   </div>

<!--  -->
   <div id="physical">
        <div class="form-group">
            <select id="delivery-city" class="form-select delivery-city">
             <option>Select your city</option>
             <option value="Lagos">Lagos</option>
            </select>
        </div>
        <div class="form-group">
           <select id="delivery-area" class="form-select">
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
         <input type="text" id="delivery_address" class="form-control" placeholder="Enter delivery address">
        </div>

        <div class="form-group">
        <input type="text" name="" data-type="vehicle_permit" data-total="<?= $get_payment_details_decode['total'] ?>" data-particularsId="<?= $particulars_record_id ?>" class="form-control coupon_field" placeholder="Coupon Code">
        <i class="coupon_code_help_txt"></i>
      </div>

         <h4 class="card-title mt-5">Order Summary</h4>
                                        
        <div class="table-responsive">
        <table class="table mb-0">
            <tbody>
              <tr>
                <?php
                  if($is_vehicle_permit){
                    echo '<td class="text-bold-500 text-blue">Vehicle Permit</td>';
                  }
                  else{
                    echo '<td class="text-bold-500 text-blue">Renew Vehicle Particulars</td>';
                  }
                ?>
                <td>1</td>
                <td class="text-bold-500 text-dark">₦<?= number_format($get_payment_details_decode['cost']) ?></td>
              </tr>
              <?php
              if(!$is_vehicle_permit){
                ?>
                <tr>
                  <td class="text-bold-500 text-blue">Insurance Cost</td>
                  <td></td>
                  <td class="text-bold-500 text-dark">₦<?= number_format($get_payment_details_decode['insurance_cost']) ?></td>
                </tr>
              <?php
              }?>
              <tr>
                <td class="text-bold-500 text-blue">Delivery Fee</td>
                <td></td>
                <td class="text-bold-500 text-dark">₦<?= number_format($get_payment_details_decode['delivery_fee']) ?></td>
              </tr>
              <tr>
                <td class="text-bold-500 text-blue">Sub Total</td>
                <td></td>
                <td class="text-bold-500 text-dark">₦<?= number_format($get_payment_details_decode['total']) ?></td>
              </tr>
              <tr>
                <td class="text-bold-500 text-blue">Coupon Discount</td>
                <td></td>
                <td class="text-bold-500 text-dark coupon_discount" id="coupon_discount">₦0.00</td>
              </tr>
              <tr>
                <td class="text-bold-500 text-blue"><input type="checkbox" class="form-check-input form-check-secondary remove_from_wallet"  name="customCheck2" id="remove_from_wallet"> Remove from my Zennal Wallet</td>
                <td></td>
                <td class="text-bold-500 text-dark">₦<?= number_format($wallet_balance)?></td>
              </tr>
              <tr>
                <td class="text-bold-500 text-blue">Total</td>
                <td></td>
                <td class="text-bold-500 text-dark total_cost" id="total_cost">₦<?= number_format($get_payment_details_decode['total']) ?></td>
              </tr>
            </tbody>
          </table>
        </div>

 
              
            </tbody>
          </table>
          <div class="form-group">
            <select data-amount="<?= $get_payment_details_decode['total'] ?>" name="thename" class="form-select payment-option" >
              <option value="">--- Payment Option ---</option>
              <option value="one_time">One time Payment</option>
              <option value="installment">On installment</option>
            </select>
        </div> 
        </div>

                                      
    <div  class="one box">      
        <div class="col-12 mt-3 d-flex justify-content-end">
            <a href="apply_loan.php" type="submit" class="btn btn-primary mr-1 mb-1">Proceed (₦ 21,000.00)</a>
        </div>
   </div>
   <!-- <div  class="green box">      
        <div class="col-12 mt-3 d-flex justify-content-end">
            <a href="apply_loan.php" type="submit" class="btn btn-primary mr-1 mb-1">Proceed (₦ 21,000.00)</a>
        </div>
   </div> -->
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
            

