
<?php include("includes/sidebar.php");?>
<div id="main">

<?php include("includes/header.php");?>
<style type="text/css">
#one, #on {display:none;}
</style>
<script>
function show(el, txt){
    var elem1 = document.getElementById('one');
    var elem2 = document.getElementById('on');

    elem1.style.display = (txt == 'One time Payment') ? 'block' : 'none';
    elem2.style.display = (txt == 'On Installement') ? 'block' : 'none';
    }
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
                                      <h4 class="card-title">Delivery Details</h4>
                                    <div class="col-md-12 col-12">
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

                              
      <h4 class="card-title mt-5">Order Summary</h4>
                                        
        <div class="table-responsive">
          <table class="table mb-0">
            <tbody>
              <tr>
                <td class="text-bold-500 text-blue">Vehicle Registration</td>
                <td>1</td>
                <td class="text-bold-500 text-dark">₦2,000</td>
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
                <td class="text-bold-500 text-blue"><input type="checkbox" class="form-check-input form-check-secondary"  name="customCheck2" id="customColorCheck2"> Remove from my Zennal Wallet</td>
                <td></td>
                <td class="text-bold-500 text-dark">₦12,000</td>
              </tr>
              <tr>
                <td class="text-bold-500 text-blue">Delivery Fee</td>
                <td></td>
                <td class="text-bold-500 text-dark">₦2,000</td>
              </tr>
              <tr>
                <td class="text-bold-500 text-blue">Total</td>
                <td></td>
                <td class="text-bold-500 text-dark">₦21,000</td>
              </tr>
            </tbody>
          </table>
        </div>

      <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <select name="thename" class="form-select" onChange="show('one', this.options[this.selectedIndex].firstChild.nodeValue)">
                                      <option>Select Payment Option</option>
                                      <option>One time Payment</option>
                                      <option>On Installement</option>
                            </select>
                        </ul>
                  </div>
                </div>
            </div>
        </div>


  <div class="col-md-12">    
      <div id="one">
        <div class="col-12 mt-3 d-flex justify-content-end">
             <button type="submit" class="btn btn-primary mr-1 mb-1">Proceed (₦ 21,000.00)</button>
        </div>
    </div>
  </div>


    <div class="col-md-12">    
      <div  id="on">
        <div class="col-12 mt-3 d-flex justify-content-end">
            <a href="apply_loan.php" class="btn btn-primary">Proceed (₦ 21,000.00)</a>
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
            

