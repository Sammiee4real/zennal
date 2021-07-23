  
<?php
    include("includes/sidebar.php");
?>
<div id="main">
<?php
    $get_vehicle_types = get_rows_from_table('vehicles');
    $get_vehicle_brands = get_rows_from_table('vehicle_brands');
    $get_permit_types = get_rows_from_table('services');

    $get_vehicles = get_rows_from_one_table('vehicles', 'date_created');
    $get_vehicle_brands = get_rows_from_table('vehicle_brands');

?>
<?php include("includes/header.php");?>
<style type="text/css">
#bar, #cus {display:none;}
</style>
<script>
function show(el, txt){
    var elem1 = document.getElementById('bar');
    var elem2 = document.getElementById('cus');

    elem1.style.display = (txt == 'Comprehensive Insurance') ? 'block' : 'none';
    elem2.style.display = (txt == 'Custom number plate') ? 'block' : 'none';
}
</script>               
<div class="main-content container-fluid" id="appWrapper">
    <div class="page-title">
        <h3>Other Vehicle Permit</h3>
        <p class="text-subtitle text-muted">Select type of vehicle and permit below</p>
    </div>


    <section class="section mt-5" id="multiple-column-form ">
        <div class="row match-height">
            <div class="col-6 mx-auto">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" id="vehicle_permit_form"> <!-- action="complete_order.php"-->
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="mt-3 mb-3">
                                            <h4 class="card-title">Vehicle Permit</h4>
                                        </div>

                                        <div class="form-group">
                                            <select class="form-select" id="vehicle_id" name="vehicle_type"
                                            v-model="vehicleType">
                                                <option value="">Select vehicle type</option>
                                                <?php
                                                    foreach ($get_vehicles as $vehicle) {
                                                    ?>
                                                    <option value="<?= $vehicle['unique_id']?>"><?= $vehicle['vehicle_type']?></option>
                                                <?php }
                                                ?>
                                            </select>
                                        </div>

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
                                        
                                        <!-- <div class="form-group">
                                            <select class="form-select" id="vehicle_model" name="vehicle_model" required>
                                                <option>Select make of vehicle</option>
                                            </select>
                                        </div> -->
                                        <div class="form-group">
                                            <select class="form-select" name="year_of_make" required>
                                                <option name="">Select year of make</option>
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
                                            <input type="text" id="Vehicle" class="form-control" placeholder="Enter Registration number/Plate number" name="plate_no" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="Vehicle" class="form-control" placeholder="Enter Engine number (optional)" name="engine_no">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="chasis" class="form-control" placeholder="Enter Chasis number" name="chassis_no" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="chasis" class="form-control" placeholder="Name on Vehicle License" name="vehicle_license" required>
                                        </div>

                                        <div class="form-group">
                                            <select class="form-select" name="vehicle_color" id="" required>
                                                <option>Select color</option>
                                                <option value="red">Red</option>
                                                <option value="green">Green</option>
                                                <option value="white">White</option>
                                                <option value="yello">Yello</option>
                                                <option value="ash">Ash</option>
                                                <option value="blue">Blue</option>
                                                <option value="black">Black</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <!-- class="choices form-select multiple-remove" multiple="multiple" -->
                                            <label for="permitType">Permit Type</label>
                                            <select class="form-select select2" id="permitType" name="permit_type[]" multiple required
                                            data-placeholder="Select type of permit">
                                                <?php
                                                    foreach($get_permit_types as $permit_type){
                                                ?>
                                                    <option value="<?php echo $permit_type["unique_id"] ?>" ><?php echo $permit_type["service"]?></option>
                                                <?php    
                                                    }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="mt-3 mb-3">
                                            <h4 class="card-title">Expiry Dates</h4>
                                        </div>

                                         <div class="form-group">
                                            <span>Vehicle License Expiry</span>
                                            <input type="date" id="" class="form-control" placeholder="" name="license_expiry">
                                        </div>
                                        <div class="form-group">
                                            <span>Insurance Expiry</span>
                                            <input type="date" id="" class="form-control" placeholder="" name="insurance_expiry">
                                        </div>
                                        <div class="form-group">
                                            <span>Road Worthiness Expiry</span>
                                            <input type="date" id="" class="form-control" placeholder="" name="road_worthiness_expiry">
                                        </div>
                                        <div class="form-group">
                                            <span>Hackney Permit Expiry (If applicable)</span>
                                            <input type="date" id="" class="form-control" placeholder="" name="hackney_permit_expiry">
                                        </div>
                                        <div class="form-group">
                                            <span>Heavy Duty Permit Expiry (If applicable)</span>
                                            <input type="date" id="" class="form-control" placeholder="" name="heavy_duty_permit_expiry">
                                        </div>

                                    </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" id="vehicle_permit_btn" class="btn btn-primary mr-1 mb-1">Proceed</button>
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
