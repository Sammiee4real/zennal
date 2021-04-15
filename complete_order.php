
<?php include("includes/sidebar.php");?>
<div id="main">

<?php 
include("includes/header.php");
if(!isset($_GET['rec_id'])){
  echo "
  <script>window.location = `particulars`</script>";
}
$particulars_record_id = $_GET['rec_id']
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
                                       <select  name="thename" class="form-select" onChange="show('bar', this.options[this.selectedIndex].firstChild.nodeValue)">
                                       <option selected>--- Delivery Type ---</option>
                                       <option value="email">Email Delivery</option>
                                       <option value="physical">Physical Delivery</option>
                                       </select>
                                        </div>

                            <div id="bar">
                                 <div class="form-group">
                                   <input type="email" name="" class="form-control" placeholder="johndoe@gmail.com">
                                </div>

                                <div class="form-group">
                                   <input type="text" name="" data-particularsId="<?= $particulars_record_id ?>" class="form-control" id="coupon_field" placeholder="Coupon Code">
                                   <i id="coupon_code_help_txt"></i>
                                </div>

    <h4 class="card-title mt-5">Order Summary</h4>
                                        
        <div class="table-responsive">
          <table class="table mb-0">
            <tbody>
              <tr>
                <td class="text-bold-500 text-blue">Renew Vehicle Particulars</td>
                <td>1</td>
                <td class="text-bold-500 text-dark">₦17,000</td>
              </tr>
              <!-- <tr>
                <td class="text-bold-500 text-blue">Vehicle Registration</td>
                <td>1</td>
                <td class="text-bold-500 text-dark">₦2,000</td>
              </tr> -->
              <tr>
                <td class="text-bold-500 text-blue">Sub Total</td>
                <td></td>
                <td class="text-bold-500 text-dark">₦19,000</td>
              </tr>
              <tr>
                <td class="text-bold-500 text-blue">Coupon Discount</td>
                <td></td>
                <td class="text-bold-500 text-dark">₦0.00</td>
              </tr>
              <tr>
                <td class="text-bold-500 text-blue"><input type="checkbox" class="form-check-input form-check-secondary"  name="customCheck2" id="customColorCheck2"> Remove from my Zennal Wallet</td>
                <td></td>
                <td class="text-bold-500 text-dark">₦12,000</td>
              </tr>
              <tr>
                <td class="text-bold-500 text-blue">Total</td>
                <td></td>
                <td class="text-bold-500 text-dark">₦21,000</td>
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
           <select class="form-select">
             <option>Select delivery area</option>
            </select>
        </div>
        <div class="form-group">
            <select class="form-select">
             <option>Select your city</option>
            </select>
        </div>
                                        
        <div class="form-group">
         <input type="text" name="" class="form-control" placeholder="Enter delivery address">
        </div>

        <div class="form-group">
            <input type="text" name="" class="form-control" placeholder="Coupon Code">
        </div>

         <h4 class="card-title mt-5">Order Summary</h4>
                                        
        <div class="table-responsive">
          <table class="table mb-0">
            <tbody>
              <tr>
                <td class="text-bold-500 text-blue">Change of vehicle ownership</td>
                <td>1</td>
                <td class="text-bold-500 text-dark">₦17,000</td>
              </tr>
              <tr>
                <td class="text-bold-500 text-blue">Insurance Fee</td>
                <td></td>
                <td class="text-bold-500 text-dark">₦2,000</td>
              </tr>
              <tr>
                <td class="text-bold-500 text-blue">Sub Total</td>
                <td></td>
                <td class="text-bold-500 text-dark">₦19,000</td>
              </tr>
              <tr>
                <td class="text-bold-500 text-blue">Coupon Discount</td>
                <td></td>
                <td class="text-bold-500 text-dark">₦0.00</td>
              </tr>

              <tr>
                <td class="text-bold-500 text-blue">Delivery Fee</td>
                <td></td>
                <td class="text-bold-500 text-dark">₦2,000</td>
              </tr>
              
              <tr>
                <td class="text-bold-500 text-blue"><input type="checkbox" class="form-check-input form-check-secondary"  name="customCheck2" id="customColorCheck2"> Remove from my Zennal Wallet</td>
                <td></td>
                <td class="text-bold-500 text-dark">₦12,000</td>
              </tr>
              <tr>
              <tr>
                <td class="text-bold-500 text-blue">Total</td>
                <td></td>
                <td class="text-bold-500 text-dark">₦21,000</td>
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
            <a href="apply_loan.php" type="submit" class="btn btn-primary mr-1 mb-1">Proceed (₦ 21,000.00)</a>
        </div>
   </div>
   <div  class="green box">      
        <div class="col-12 mt-3 d-flex justify-content-end">
            <a href="apply_loan.php" type="submit" class="btn btn-primary mr-1 mb-1">Proceed (₦ 21,000.00)</a>
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
            

