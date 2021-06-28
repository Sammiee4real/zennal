
<?php 
    include("includes/sidebar.php");
    $get_vehicles = get_rows_from_one_table('vehicles', 'date_created');
    $get_vehicle_brands = get_rows_from_one_table('vehicle_brands', 'datetime');
    $get_vehicle_models = get_rows_from_one_table('vehicle_models', 'datetime');
    $get_insurer = get_rows_from_one_table('insurers', 'datetime');
    $get_other_papers = get_rows_from_one_table('services', 'date_created');
    $get_insurers = get_rows_from_table('insurers');

?>
<div id="main">

<?php include("includes/header.php");?>
    <style type="text/css">
    #bar {display:none;}
    #veh {display:none;}

</style>  

<script>
// function show(el, txt){
//     var elem1 = document.getElementById('bar');
//     elem1.style.display = (txt == 'Comprehensive Insurance') ? 'block' : 'none';
//     }

    // function show(el, txt){
    //   var elem1 = document.getElementById(el);
    //   var elem2 = document.getElementById('veh');

    //   elem1.style.display = (txt == 'Comprehensive Insurance') ? 'block' : 'none';
    //   elem2.style.display = (txt == 'Comprehensive Insurance') ? 'block' : 'none';
    // }

    function show(el, txt){
      var elem = document.getElementById(el);

      elem.style.display = (txt == 'Comprehensive Insurance') ? 'block' : 'none';
      // elem2.style.display = (txt == 'Comprehensive Insurance') ? 'block' : 'none';
    }
</script>                
<div class="main-content container-fluid" id="appWrapper">
    <div class="page-title">
        <h3>Vehicle Registration</h3>
        <p class="text-subtitle text-muted">Pricing</p>
    </div>

    <section class="section mt-5">
        <div class="col-lg-12 col-xl-6 mx-auto">
    
            <div class="card collapse-icon accordion-icon-rotate">
                <div id="headingCollapse11" class="card-header">
                    <a data-toggle="collapse" href="#collapse11" aria-expanded="false" aria-controls="collapse11" class="card-title lead collapsed">
                        Renew Vehicle Particulars <i data-feather="plus" width="20" ></i>
                    </a> <span > </span>
                </div>
                <div id="collapse11" role="tabpanel" aria-labelledby="headingCollapse11" class="collapse" style="">
                    <div class="card-body">
                        <div class="card-block">
                            <div class="col-md-12">
                                <div class="alert alert-light-info color-black">Select the type of Vehicle, then check the options you require to see the price. </div>
                                <form id="renew_vehicle_form" method="POST">
                                    <fieldset class="form-group">
                                      <label for="vehicle_type">Vehicle Type</label>
                                      <select class="form-select" id="vehicle_type" name="vehicle_type" onchange="get_quote1()"
                                      v-model="vehicleType">
                                          <option value="">Select vehicle type</option>
                                          <?php
                                              foreach ($get_vehicles as $vehicle) {
                                              ?>
                                              <option value="<?= $vehicle['unique_id']?>"><?= $vehicle['vehicle_type']?></option>
                                          <?php }
                                          ?>
                                      </select>
                                    </fieldset>

                                    <div class="form-group">
                                        <label for="vehicleMake">Vehicle Make</label>
                                        <select class="form-select" id="vehicleMake" name="vehicle_make"
                                        v-model="vehicleMake">
                                            <option value="">Select vehicle make</option>
                                            <?php
                                                foreach ($get_vehicle_brands as $brand) {
                                                ?>
                                                <option value="<?= $brand['brand_name']?>" >
                                                    <?= $brand['brand_name']?>
                                                </option>
                                            <?php }
                                            ?>
                                            <option value="others">Others</option>
                                        </select>
                                        <div id="other_vehicle_make" class="mt-3" v-if="vehicleMake == 'others'">
                                            <label for="otherVehicleMake">Specify Vehicle Make</label>
                                            <input type="text" id="otherVehicleMake" name="other_vehicle_make" class="form-control" placeholder="Please Specify"
                                            v-model="otherVehicleMake">
                                        </div>
                                    </div>
                                
                                    <center v-if="stillFetchingModels">
                                        <div id="spinner_class">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </div>
                                    </center>
                                    <div class="form-group">
                                          <label for="vehicle_model">Vehicle Model</label>
                                            <select class="form-select" id="vehicle_model"
                                            name="vehicle_model" v-model="vehicleMakeModel">
                                                <option value="">Select vehicle model</option>
                                                <option v-for="(model, index) in vehicleMakeModels"
                                                :key="index" :value="model.Model">
                                                    {{model.Model}}
                                                </option>
                                                <option value="others" v-if="finishedFetchingModels">Others</option>
                                            </select>
                                            <div id="other_vehicle_model" class="mt-3" v-if="vehicleMakeModel == 'others'">
                                                <label for="other_vehicle_model">Specify Vehicle Model</label>
                                                <input type="text" id="other_vehicle_model" name="other_vehicle_model" class="form-control" placeholder="Please Specify"
                                                v-model="otherVehicleMakeModel">
                                            </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="year_of_make">Year of Make</label>
                                        <select class="form-select" id="year_of_make" name="year_of_make"
                                        v-model="year">
                                            <option value="">Select year</option>
                                            <?php
                                                for ($year=1990; $year <= 2099; $year++) { 
                                                ?>
                                                <option value="<?=$year?>"><?=$year;?></option>
                                                <?php
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                      <label for="insurance_type">Insurance Type</label>
                                        <select name="insurance_type" id="insurance_type" class="form-select" onChange="show('bar', this.options[this.selectedIndex].firstChild.nodeValue)" v-model="insuranceType">
                                            <option value="">Select insurance type</option>
                                            <option value="third_party_insurance">3rd Party Insurance</option>
                                            <option value="comprehensive_insurance">Comprehensive Insurance</option>
                                            <option value="no_insurance">(No Insurance)</option>
                                        </select>
                                    </div>
                                    <div id="bar">
                                        <div class="row">
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="vehicle_value">Vehicle Value (Without a comma)*</label>
                                                    <input type="text" id="vehicle_value" name="vehicle_value" class="form-control" placeholder="Enter Vehicle Value" name="Vehicle-column" v-model="vehicleValue">
                                                    <span id="help-text"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="prefered_insurer">Preferred Insurer * </label>
                                                    <select class="form-select" name="prefered_insurer" id="prefered_insurer" v-model="preferredInsurer">
                                                        <option value="">Select Preferred Insurer</option>
                                                        <?php
                                                            foreach($get_insurers as $insurer){
                                                            echo "<option value='".$insurer['unique_id']."'>".$insurer['name']."</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="select_plan">Plan *</label>
                                                    <select class="form-select" name="select_plan" id="select_plan" v-model="plan">
                                                        <option value="">Select package plan</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <input type="hidden" name="premium_amount" id="premiumAmountField">
                                        </div>
                                    </div>
                                    <ul class="list-unstyled mb-0">
                                        <li class="d-inline-block mr-2 mb-1">
                                            <div class="form-check">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="form-check-input form-check-primary"  name="road_worthiness" id="paper1" onclick="get_quote1()" value="1" v-model="roadWorthiness">
                                                    <label class="form-check-label" for="customColorCheck1">Road Worthiness</label>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="d-inline-block mr-2 mb-1">
                                            <div class="form-check">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="form-check-input form-check-success"  name="hackney_permit" id="paper2" onclick="get_quote1()" value="1" v-model="hackneyPermit">
                                                    <label class="form-check-label" for="customColorCheck3">Hackney Permit</label>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="d-inline-block mr-2 mb-1">
                                            <div class="form-check">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="form-check-input form-check-danger"  name="license" id="paper3" onclick="get_quote1()" value="1" v-model="vehicleLicense">
                                                    <label class="form-check-label" for="customColorCheck4">Vehicle License</label>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </form>

                                <center>
                                    <div id="spinner_class" class="d-none">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </center>
            
                            </div>
                            <div class="row">
                                <h4>Total Amount - &#8358; <span id="total" class="quote-amount">0.00</span></h4>

                                <div class="col-md-12 mt-2">
                                    <button class="btn btn-primary btn-block" @click="goToParticulars">Click to buy</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- REGISTER NEW VEHICLE STARTS -->
            <div class="card collapse-icon accordion-icon-rotate">
                <div id="headingCollapse12" class="card-header">
                    <a data-toggle="collapse" href="#collapse12" aria-expanded="false" aria-controls="collapse12" class="card-title lead collapsed">Register a New Vehicle <i data-feather="plus" width="20" ></i> </a>
                </div>
                <div id="collapse12" role="tabpanel" aria-labelledby="headingCollapse12" class="collapse" aria-expanded="false" style="">
                    <div class="card-body">
                        <div class="card-block">
                            <div class="col-md-12">
                                <div class="alert alert-light-info color-black">Select the type of Vehicle, then select all the options you require to see the accurate price. </div>
                                    <form method="post" id="register_vehicle_form">
                                        <fieldset class="form-group">
                                            <label for="vehicle_type1">Vehicle Type</label>
                                            <select class="form-select" id="vehicle_type1" name="vehicle_type" onchange="get_quote2()" v-model="vehicleTypeNewVehicle">
                                                <option value="">Select vehicle type</option>
                                                <?php
                                                    foreach ($get_vehicles as $vehicle) {
                                                    ?>
                                                    <option value="<?= $vehicle['unique_id']?>"><?= $vehicle['vehicle_type']?></option>
                                                <?php }
                                                ?>
                                            </select>
                                        </fieldset>

                                        <div class="form-group">
                                            <label for="vehcileMake1">Vehicle Make</label>
                                            <select class="form-select" id="vehcileMake1" name="vehicle_make"
                                            v-model="vehicleMakeNewVehicle">
                                                <option value="">Select vehicle make</option>
                                                <?php
                                                    foreach ($get_vehicle_brands as $brand) {
                                                    ?>
                                                        <option value="<?= $brand['brand_name']?>" >
                                                            <?= $brand['brand_name']?>
                                                        </option>
                                                    <?php }
                                                    ?>
                                                    <option value="others">Others</option>
                                            </select>
                                            <div id="other_vehicle_make" class="mt-3" v-if="vehicleMakeNewVehicle == 'others'">
                                                <label for="otherVehicleMake1">Specify Vehicle Make</label>
                                                <input type="text" id="otherVehicleMake1" name="other_vehicle_make" class="form-control" placeholder="Please Specify"
                                                v-model="otherVehicleMakeNewVehicle">
                                            </div>
                                        </div>
                                        
                                        <center v-if="stillFetchingModelsNewVehicle">
                                            <div id="spinner_class">
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </div>
                                        </center>
                                        <div class="form-group">
                                            <label for="vehicle_model_nv">Vehicle Model</label>
                                            <select class="form-select" id="vehicle_model_nv"
                                            name="vehicle_model" v-model="vehicleMakeModelNewVehicle">
                                                <option value="">Select vehicle model</option>
                                                <option v-for="(model, index) in vehicleMakeModelsNewVehicle"
                                                :key="index" :value="model.Model">
                                                    {{model.Model}}
                                                </option>
                                                <option value="others" v-if="finishedFetchingModelsNewVehicle">Others</option>
                                            </select>
                                            <div id="other_vehicle_model" class="mt-3" v-if="vehicleMakeModelNewVehicle == 'others'">
                                              <label for="other_vehicle_model">Specify Vehicle Model</label>
                                              <input type="text" name="other_vehicle_model" class="form-control" placeholder="Please Specify" v-model="otherVehicleMakeModelNewVehicle">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                          <label for="year_of_make">Year of Make</label>
                                          <select class="form-select" id="year_of_make" name="year_of_make"
                                          v-model="yearNewVehicle">
                                              <option value="">Select year</option>
                                              <?php
                                                  for ($year=1990; $year <= 2099; $year++) { 
                                                  ?>
                                                  <option value="<?=$year?>"><?=$year;?></option>
                                                  <?php
                                                  }
                                              ?>
                                          </select>
                                        </div>
                                        
                                        <div class="form-group">
                                          <label for="insurance_type1">Insurance Type</label>
                                          <select name="insurance_type" id="insurance_type1" class="form-select" onChange="show('veh', this.options[this.selectedIndex].firstChild.nodeValue)" v-model="insuranceTypeNewVehicle">
                                              <option value="">Selecte insurance type</option>
                                              <option value="third_party_insurance">3rd Party Insurance</option>
                                              <option value="comprehensive_insurance">Comprehensive Insurance</option>
                                              <option value="no_insurance_insurance">(No Insurance)</option>
                                          </select>
                                        </div>
                                        <div id="veh">
                                            <div class="form-group">
                                              <label for="vehicle_value">Vehicle Value</label>
                                              <input type="number" name="vehicle_value" id="vehicle_value" class="form-control" placeholder="Value of Vehicle (in naira)"
                                              v-model="vehicleValueNewVehicle">
                                            </div>
                                            <div class="form-group">
                                              <label for="insurer">Insurer</label>
                                              <select class="form-select" name="insurer" id="insurer" v-model="preferredInsurerNewVehicle">
                                                <option value="">Select Insurer</option>
                                                <?php
                                                    foreach ($get_insurer as $insurer) {
                                                ?>
                                                    <option value="<?= $insurer['unique_id']?>"><?= $insurer['name']?></option>
                                                <?php } ?>
                                              </select>
                                            </div>
                                            <div class="form-group">
                                              <label for="plan_type">Plan</label>
                                              <select class="form-select" name="plan_type" id="plan_type" onchange="get_quote2()" v-model="planNewVehicle">
                                                <option value="">Select Plan</option>
                                              </select>
                                            </div>
                                        </div>

                                        <fieldset class="form-group">
                                          <label for="plate_number_type">Number Plate</label>
                                          <select name="plate_number_type" id="plate_number_type" class="form-select" onchange="get_quote2()" v-model="numberPlateTypeNewVehicle">
                                            <option value="">Type of number plate</option>
                                            <option value="private"> Private number plate</option>
                                            <option value="commercial"> Commercial number plate</option>
                                            <option value="personalized_number">Custom number plate</option>
                                          </select>
                                        </fieldset>
                                    </form>
                                </div>
                                <center>
                                    <div id="spinner_class1" class="d-none">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </center>

                                <div class="row">
                                    <h4>
                                        Total Amount - &#8358;<span id="total1" class="quote-amount-new-vehicle">
                                        0.00</span>
                                    </h4>
                                <div class="col-md-12 mt-2">
                                <button type="button" class="btn btn-primary btn-block"
                                @click="goToVehicleReg">
                                    Click to buy
                                </button>
                                <!-- <a href="vehicle_reg.php"> <button class="btn btn-primary btn-block ">Click to buy</button></a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- REGISTER NEW VEHICLE ENDS -->
        </div>

    <div class="card collapse-icon accordion-icon-rotate">
      <div id="headingCollapse13" class="card-header">
          <a data-toggle="collapse" href="#collapse13" aria-expanded="false" aria-controls="collapse13" class="card-title lead collapsed" @click="unsetVehiclDetails">
            Change of Ownership <i data-feather="plus" width="20" ></i>
          </a>
        </div>
        <div id="collapse13" role="tabpanel" aria-labelledby="headingCollapse12" class="collapse" aria-expanded="false" style="">
          <div class="card-body">
            <div class="card-block">
            <div class="col-md-12">
          <div class="alert alert-light-info color-black">Select the type of Vehicle, then select all the options you require, to see the acccurate price.</div>
          <form id="change_ownership_quote_form">

            <fieldset class="form-group">
              <select class="form-select" id="vehicle_type2" name="vehicle_type" onchange="get_quote3()"
              v-model="vehicleTypeOwnership">
                <option value="">Select vehicle type</option>
                <?php
                    foreach ($get_vehicles as $vehicle) {
                    ?>
                    <option value="<?= $vehicle['unique_id']?>"><?= $vehicle['vehicle_type']?></option>
                <?php }
                ?>
              </select>
            </fieldset>

            <div class="form-group">
              <select class="form-select" id="" name="vehicle_make"
              v-model="vehicleMakeOwnership">
                  <option value="">Select vehicle make</option>
                  <?php
                      foreach ($get_vehicle_brands as $brand) {
                      ?>
                      <option value="<?= $brand['brand_name']?>" >
                          <?= $brand['brand_name']?>
                      </option>
                  <?php }
                  ?>
                  <option value="others">Others</option>
              </select>
              <div id="other_vehicle_make" class="mt-3"
              v-if="vehicleMakeOwnership == 'others'">
                  <input type="text" name="other_vehicle_make" class="form-control" placeholder="Please Specify"
                  v-model="otherVehicleMakeOwnership">
              </div>
            </div>
          
            <center v-if="stillFetchingModelsOwnership">
                <div id="spinner_class">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </center>
            <div class="form-group">
              <label for="vehicle_model_o">Vehicle Model</label>
              <select class="form-select" id="vehicle_model_o"
              name="vehicle_model" v-model="vehicleMakeModelOwnership">
                  <option value="">Select vehicle model</option>
                  <option v-for="(model, index) in vehicleMakeModelsOwnership"
                  :key="index" :value="model.Model">
                      {{model.Model}}
                  </option>
                  <option value="others" v-if="finishedFetchingModelsOwnership">Others</option>
              </select>
              <div id="other_vehicle_model" class="mt-3"
              v-if="vehicleMakeModelOwnership == 'others'">
                  <input type="text" name="other_vehicle_model" class="form-control" placeholder="Please Specify"
                  v-model="otherVehicleMakeModelOwnership">
              </div>
            </div>

            <div class="form-group">
                <select class="form-select" id="year_of_make" name="year_of_make"
                v-model="yearOwnership">
                    <option value="">Select year</option>
                    <?php
                        for ($year=1990; $year <= 2099; $year++) { 
                        ?>
                        <option value="<?=$year?>"><?=$year;?></option>
                        <?php
                        }
                    ?>
                </select>
            </div>

            <fieldset class="form-group">
              <select class="form-select" onchange="get_quote3()" v-model="vehicleLicenseExpiryOwnership">
                <option value="">Vehicle license expiry</option>
                <option value="less_than_one_month">Less than 1 month</option>
                <option value="more_than_one_month">More than 1 month</option>
                <option value="more_than_one_year">More than 1 year</option>
                <option value="more_than_two_years">More than 2 years</option>
                <option value="more_than_three_years">More than 3 years</option>
                <option value="more_than_four_years">More than 4 years</option>
                <option value="more_than_five_years">More than 5 years</option>
                <option value="more_than_six_years">More than 6 years</option>
                <option value="more_than_seven_years">More than 7 years</option>
              </select>
            </fieldset>

            <fieldset class="form-group">
              <select class="form-select" id="registration_type" name="registration_type" onchange="get_quote3()"
              v-model="registrationTypeOwnership">
                <option value="">Select Registration type</option>
                <option value="private_with_third">Private Vehicle (with 3rd Party Insurance)</option>
                <option value="private_without_third">Private Vehicle (No Insurance)</option>
                <option value="commercial_with_third">Commercial Vehicle (with 3rd Party Insurance)</option>
                <option value="commercial_without_third">Commercial Vehicle (No Insurance)</option>
              </select>
            </fieldset>

            <fieldset class="form-group">
              <select class="form-select" id="plate_number_type2" name="plate_number_type" onchange="get_quote3()"
              v-model="numberPlateTypeOwnership">
                <option value="">Type of number plate</option>
                <option value="new"> New number plate</option>
                <option value="old"> Old number plate</option>
                <option value="custom">Custom number plate</option>
              </select>
            </fieldset>
          </form>
        </div>

        <center>
          <div id="spinner_class2" class="d-none">
              <div class="spinner-border text-primary" role="status">
                  <span class="sr-only">Loading...</span>
              </div>
          </div>
        </center>
        <div class="row">
            <h4>Total Amount - &#8358;<span id="total2">0.00</span></h4>
          <div class="col-md-12 mt-2">
            <button class="btn btn-primary btn-block" @click="goToChangeOwnership">
              Click to buy
            </button>
            <!-- <a href="change_ownership.php"> <button class="btn btn-primary btn-block ">Click to buy</button></a> -->
          </div>
        </div>
            </div>
          </div>
        </div>
    </div>

    <div class="card collapse-icon accordion-icon-rotate">
      <div id="headingCollapse14" class="card-header">
          <a data-toggle="collapse" href="#collapse14" aria-expanded="false" aria-controls="collapse14" class="card-title lead collapsed" @click="unsetVehiclDetails">
            Other Vehicle Papers <i data-feather="plus" width="20" ></i>
          </a>
        </div>
        <div id="collapse14" role="tabpanel" aria-labelledby="headingCollapse12" class="collapse" aria-expanded="false" style="">
          <div class="card-body">
            <div class="card-block">
                     <div class="col-md-12">
          <div class="alert alert-light-info color-black">Select the type of Vehicle Permit below</div>
          <form method="GET" id="vehicle_permit_pricing_form" action="vehicle_permit">
            <fieldset class="form-group">
              <select class="form-select select2 permits" id="vehicle_permit"
              name="vehicle_permit[]" onchange="get_quote4()" style="width:100%"
              multiple data-placeholder="Chose number">
                <option></option>
                <?php
                    foreach ($get_other_papers as $permit) {
                    ?>
                    <option value="<?= $permit['unique_id']?>"><?= $permit['service']?></option>
                <?php }
                ?>
              </select>
            </fieldset>
            <center>
          <div id="spinner_class3" class="d-none">
              <div class="spinner-border text-primary" role="status">
                  <span class="sr-only">Loading...</span>
              </div>
          </div>
        </center>
          <div class="row">
              <h4>Total Amount - &#8358;<span id="total3">0.00</span></h4>
            <div class="col-md-12 mt-2">
              <!-- <a href="vehicle_permit.php"> <button class="btn btn-primary btn-block ">Click to buy</button></a> -->
              <button class="btn btn-primary btn-block">Click to buy</button>
              
            </div>
          </div>
          </form>
        </div>
         
            </div>
          </div>
        </div>
    </div>

  </div>
    </section>


</div>

<?php include("includes/footer.php");?>

<?php include("includes/VueInstance.php");?>

<script>
  function formatNumber(num) {
      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
  }
  function get_quote1(){
    $.ajax({
      url: "ajax/get_quote",
      method: "POST",
      data: $("#renew_vehicle_form").serialize(),
      beforeSend: function(){
        $("#spinner_class").removeClass("d-none");
      },
      success: function(data){
        $("#spinner_class").addClass("d-none");
        //var new_total = parseInt(total + data);
        $("#total").html(formatNumber(data));
      }
    })
  }

  function get_quote2(){
    $.ajax({
      url: "ajax/get_quote2",
      method: "POST",
      data: $("#register_vehicle_form").serialize(),
      beforeSend: function(){
        $("#spinner_class1").removeClass("d-none");
      },
      success: function(data){
        $("#spinner_class1").addClass("d-none");
        //var new_total = parseInt(total + data);
        $("#total1").html(formatNumber(data));
      }
    })
  }

  function get_quote3(){
    $.ajax({
      url: "ajax/get_quote3",
      method: "POST",
      data: $("#change_ownership_quote_form").serialize(),
      beforeSend: function(){
        $("#spinner_class2").removeClass("d-none");
      },
      success: function(data){
        $("#spinner_class2").addClass("d-none");
        //var new_total = parseInt(total + data);
        $("#total2").html(formatNumber(data));
      }
    })
  }

  function get_quote4(){
    $.ajax({
      url: "ajax/get_quote4",
      method: "POST",
      data: $("#vehicle_permit_pricing_form").serialize(),
      beforeSend: function(){
        $("#spinner_class3").removeClass("d-none");
      },
      success: function(data){
        $("#spinner_class3").addClass("d-none");
        $("#total3").html(formatNumber(data));
      }
    })
  }

  $(document).ready(function(){
    $("#insurer").change(function(){
      var selected_option = $(this).children("option:selected").val();
      if(selected_option == ''){
        alert("Please select an option");
      }
      else{
        $.ajax({
          url: "ajax/get_insurance_plan",
          method: "POST",
          data: {"insurer": selected_option},
          success: function(data){
            $("#plan_type").html(data);
          }
        })
      }
    });

    $("#vehicle_value").keyup($.debounce(1000, get_quote2))

    $("#insurance_type").change(function(){
      //var vehicle_type = $(this).children("option:selected").val();
      var insurance_type = $(this).children("option:selected").val();
      var total = $("#total").html();
      $("#total").html(formatNumber(0));
      if(insurance_type == 'third_party_insurance' || insurance_type == 'no_insurance'){
        $.ajax({
          url: "ajax/get_quote",
          method: "POST",
          data: $("#renew_vehicle_form").serialize(),
          beforeSend: function(){
            $("#spinner_class").removeClass("d-none");
          },
          success: function(data){
            $("#spinner_class").addClass("d-none");
            //var new_total = parseInt(total + data);
            $("#total").html(formatNumber(data));
          }
        })
      }
    })

    $("#insurance_type1").change(function(){
      //var vehicle_type = $(this).children("option:selected").val();
      var insurance_type = $(this).children("option:selected").val();
      var total = $("#total").html();
      $("#total1").html(formatNumber(0));
      console.log("Got here");
      if(insurance_type == 'third_party_insurance' || insurance_type == 'no_insurance'){
        $.ajax({
          url: "ajax/get_quote2",
          method: "POST",
          data: $("#register_vehicle_form").serialize(),
          beforeSend: function(){
            $("#spinner_class1").removeClass("d-none");
          },
          success: function(data){
            $("#spinner_class1").addClass("d-none");
            //var new_total = parseInt(total + data);
            $("#total1").html(formatNumber(data));
          }
        })
      }
      else if(insurance_type == 'comprehensive_insurance'){
        $("#veh").show();
      }
    })


    
  })
</script>
            