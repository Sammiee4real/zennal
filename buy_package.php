
<?php include("sidebar.php");?>
<div id="main">

<?php include("header.php");?>

<style type="text/css">
#one, #on {display:none;}
</style>
<script>
function show(el, txt){
    var elem1 = document.getElementById('one');
    var elem2 = document.getElementById('on');

    elem1.style.display = (txt == 'One time Installement') ? 'block' : 'none';
    elem2.style.display = (txt == 'On Installement') ? 'block' : 'none';
    }
</script>       

<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Buy Package</h3>
        <p class="text-subtitle text-muted">Preferred Insurance Package</p>
    </div>

    <div class="main-content container-fluid">
     <section class="section mt-2">
      <div class="row">
      <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">BUY A PACKAGE</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
      </div>
      
      <!--  -->
    </div>
    </section>

    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <div class="row">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <select class="form-select" id="basicSelect">
                                      <option>Select  Insurer</option>
                                      <option>Mutual Benefits</option>
                                      <option>Old Mutual</option>
                                        </select>
                        </ul>
                </div>
            </div>
        </div>
      </div>

      <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <div class="row">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <select class="form-select" id="basicSelect">
                                      <option>Select a package</option>
                                      <option>Bronze</option>
                                      <option>Silver</option>
                                      <option>Gold</option>
                                      <option>Diamond</option>
                                      <option>Platinum</option>
                                        </select>
                        </ul>
                </div>
            </div>
        </div>
      </div>

      <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <div class="row">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <select name="thename" class="form-select" onChange="show('one', this.options[this.selectedIndex].firstChild.nodeValue)">
                                      <option>Select Payment Option</option>
                                      <option>One time Installement</option>
                                      <option>On Installement</option>
                                        </select>
                        </ul>
                  </div>
                </div>
            </div>
        </div>

   <div class="col-md-6">    
      <div class="" id="one">
          <div class="table-responsive">
          <table class="table table-striped mb-0">
            <tbody>
              <tr>
                <td class="text-bold-500">ANNUAL (ONE-TIME PAYMENT)</td>
                <td>₦29,750</td>
                <td><a href="bank_details.php"><button class="btn btn-primary">BUY NOW</button></a></td>
              </tr>
            </tbody>
          </table>
        </div>
    </div>
  </div>

      <div class="col-md-6">    
      <div class="" id="on">
        <div class="alert alert-light-primary color-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>  30% equity contribution on all Installments.</div>
          <div class="table-responsive">
          <table class="table table-striped mb-0">
            <tbody>
              <tr>
                <td class="text-bold-500">TWO INSTALLMENTS</td>
                <td>₦29,750</td>
                <td><a href="apply_loan.php"><button class="btn btn-primary">BUY NOW</button></a></td>
              </tr>
              <tr>
                <td class="text-bold-500">THREE INSTALLMENTS</td>
                <td>₦29,750</td>
                <td><a href="#"><button class="btn btn-primary">BUY NOW</button></a></td>
              </tr>
              <tr>
                <td class="text-bold-500">FOUR INSTALLMENTS</td>
                <td>₦29,750</td>
                <td><a href="#"><button class="btn btn-primary">BUY NOW</button></a></td>
              </tr>
              <tr>
                <td class="text-bold-500">FIVE INSTALLMENTS</td>
                <td>₦29,750</td>
                <td><a href="#"><button class="btn btn-primary">BUY NOW</button></a></td>
              </tr>
              <tr>
                <td class="text-bold-500">SIX INSTALLMENTS</td>
                <td>₦29,750</td>
                <td><a href="#"><button class="btn btn-primary">BUY NOW</button></a></td>
              </tr>
            </tbody>
          </table>
        </div>
     </div>
    </div>


    </div>



</div>
<?php include("footer.php");?>
            