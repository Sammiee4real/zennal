<?php

    include("includes/sidebar.php");
    include("includes/header.php");

    $get_vehicle_types = get_rows_from_table('vehicles');
    $get_vehicle_brands = get_rows_from_table('vehicle_brands');
    $get_permit_types = get_rows_from_table('services');
    $get_insurer = get_rows_from_one_table('insurers', 'datetime');
    $get_insurers = get_rows_from_table('insurers');

    $insurance_plans = [];
    if(isset($_GET['pi'])){
        $insurer_id = $_GET['pi'];
        $insurance_plans = get_rows_from_table_with_one_params("insurance_plans", 'insurer_id', $insurer_id);
    }
    
?> 

<div id="main">

<style type="text/css">
/* #bar, #cus {
    display:none;
} */
#cus {
    display:none;
}
</style>
<script>
    // function show(el, txt){
    //     var elem1 = document.getElementById('bar');
    //     var elem2 = document.getElementById('cus');

    //     elem1.style.display = (txt == 'Comprehensive Insurance') ? 'block' : 'none';
    //     elem2.style.display = (txt == 'Custom number plate') ? 'block' : 'none';
    // }
    function show(el, txt){
        var elem = document.getElementById(el);

        elem.style.display = (txt == 'Comprehensive Insurance') ? 'block' : 'none';
    }
</script>           
<div class="main-content container-fluid" id="appWrapper">
    <div class="page-title">
        <h3>Renew Vehicle Particulars</h3>
        <p class="text-subtitle text-muted">Select type of vehicle and permit below</p>
    </div>


    <section class="section mt-5" id="multiple-column-form ">
        <div class="row match-height">
            <div class="col-6 mx-auto">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="post" id="renew-particulars-form">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="mt-3 mb-3">
                                          <h4 class="card-title">Vehicle Details</h4>
                                        </div>

                                        <div class="form-group">
                                            <label for="vehicleType">Vehicle Type</label>
                                            <select class="form-select" id="vehicleType" name="vehicle_type"
                                            v-model="vehicleType" required>
                                                <option value="">Select vehicle type</option>
                                                <?php
                                                    foreach($get_vehicle_types as $vehicle){
                                                ?>
                                                    <option data-brandId="<?php echo $vehicle["unique_id"] ?>" value="<?php echo $vehicle["unique_id"]?>" <?php echo isset($vehicle_details["vehicle_type"]) && $vehicle_details["vehicle_type"] == $vehicle["vehicle_type"]?"selected":""; ?>><?php echo $vehicle["vehicle_type"]?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label for="vehicleMake">Vehicle Make</label>
                                            <select class="form-select" id="vehicleMake" name="make_of_vehicle" required
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
                                                <label for="otherVehicleMake">Specify Vehicle Model</label>
                                                <input type="text" name="other_vehicle_make" class="form-control" placeholder="Please Specify" id="otherVehicleMake"
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
                                                <label for="otherVehicleMakeModel">Specify Vehicle Model</label>
                                                <input type="text" name="other_vehicle_model" class="form-control" placeholder="Please Specify" id="otherVehicleMakeModel"
                                                v-model="otherVehicleMakeModel">
                                            </div>
                                        </div>



                                        <div class="form-group">
                                            <label for="otherVehicleMakeModel">Year of Make</label>
                                            <select class="form-select" name="year_of_make"
                                            v-model="year" required>
                                                <option value="">Select year of make</option>
                                                <?php
                                                    $year = 1995;
                                                    while($year <= 2099){
                                                        echo "<option value=".$year.">".$year."</option>";
                                                        $year++;
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="plateNumber">Registration Number or Plate Number</label>
                                            <input type="text" id="plateNumber" class="form-control" placeholder="Enter Registration number/Plate number" name="plate_no" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="engineNumber">Engine Number</label>
                                            <input type="text" id="engineNumber" class="form-control" placeholder="Enter Engine number (optional)" name="engine_no" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="chasis">Chasis Number</label>
                                            <input type="text" id="chasis" class="form-control" placeholder="Enter Chasis number" name="chassis_no" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="vehicleLicense">Vehicle License</label>
                                            <input type="text" id="vehicleLicense" class="form-control" placeholder="Name on Vehicle License" name="vehicle_license" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="vehicleColor">Vehicle Color</label>
                                            <select class="form-select" id="vehicleColor" name="vehicle_color" required>
                                                <option value="">Select color</option>
                                                <option value="arsh">Arsh</option>
                                                <option value="blue">Blue</option>
                                                <option value="green">Green</option>
                                                <option value="yellow">Yello</option>
                                                <option value="black">Black</option>
                                                <option value="red">Red</option>
                                                <option value="white">White</option>
                                            </select>
                                        </div>
                                        <ul class="list-unstyled mb-0">
                                            <h6>Check all that applies</h6>
                                            <li class="d-inline-block mr-2 mb-1">
                                                <div class="form-check">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="form-check-input form-check-primary" name="road_worthiness" id="customColorCheck1"
                                                        v-model="roadWorthiness" value="1">
                                                        <label class="form-check-label" for="customColorCheck1">Road Worthiness</label>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="d-inline-block mr-2 mb-1">
                                                <div class="form-check">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="form-check-input form-check-success" name="hackey_permit" id="customColorCheck3"
                                                        v-model="hackneyPermit" value="1">
                                                        <label class="form-check-label" for="customColorCheck3">Hackney Permit</label>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="d-inline-block mr-2 mb-1">
                                                <div class="form-check">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="form-check-input form-check-danger"  name="vehicle_license" id="customColorCheck4"
                                                        v-model="vehicleLicense" value="1">
                                                        <label class="form-check-label" for="customColorCheck4">Vehicle License</label>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="form-group">
                                            <!-- class="choices form-select multiple-remove" multiple="multiple" -->
                                            <label for="permitType">Permit Type</label>
                                            <select class="form-select" id="permitType" name="permit_type" required> 
                                                <option value="">Select type of permit</option>
                                                <?php
                                                    foreach($get_permit_types as $permit_type){
                                                ?>
                                                    <option value="<?php echo $permit_type["unique_id"] ?>" ><?php echo $permit_type["service"]?></option>
                                                <?php    
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="insurance_type">Insurance Type</label>
                                            <select name="insurance_type" class="form-select" id="insurance_type"
                                            v-model="insuranceType" required onChange="show('bar', this.options[this.selectedIndex].firstChild.nodeValue)" v-model="insuranceType"> <!--  onChange="show('bar', this.options[this.selectedIndex].firstChild.nodeValue)" -->
                                                <option value="">Insurance type</option>
                                                <option value="third_party_insurance">3rd Party Insurance</option>
                                                <option value="comprehensive_insurance">Comprehensive Insurance</option>
                                                <option value="no_insurance">(No Insurance)</option>
                                            </select>
                                        </div>
                                        <div id="bar" v-show="insuranceType == 'comprehensive_insurance'">
                                            <div class="row">
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group">
                                                        <span for="first-name-column">Vehicle Value (Without a comma)*</span>
                                                        <input type="text" id="vehicle_value" name="vehicle_value" class="form-control" placeholder="Enter Vehicle Value" name="Vehicle-column" v-model="vehicleValue">
                                                        <span id="help-text"></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <span for="last-name-column">Preferred Insurer * </span>
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
                                                        <span for="last-name-column">Plan *</span>
                                                        <select class="form-select" name="select_plan" id="select_plan" v-model="plan">
                                                            <option value="">Select package plan</option>
                                                            <?php
                                                                if(!empty($insurance_plans)){
                                                                    foreach($insurance_plans as $insurance_plan){
                                                                        $plan_id = $insurance_plan['unique_id'];
                                                                        $plan_name = $insurance_plan['plan_name'];
                                                                        $plan_percentage = $insurance_plan['plan_percentage'];
                                                                        echo "<option value='$plan_id'>$plan_name - $plan_percentage%</option>";
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="premium_amount" id="premiumAmountField">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button id="submit-particular-btn" type="submit" class="btn btn-primary mr-1 mb-1">Proceed</button>
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

<?php include("includes/vueInstanceVehicle.php");?>

<script>
    // $("#insurance_type").change(function(){
    //     var selected_option = $(this).val();
    //     $("#bar").hide();
    //     if(selected_option == 'comprehensive_insurance'){
    //         $("#bar").show();
    //     }
    // });

</script>