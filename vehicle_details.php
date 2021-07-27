<?php 
    include("includes/sidebar.php");
    include("includes/header.php");

    $get_make_of_vehicles = get_rows_from_table('vehicle_brands');

    $vehicle_details = [];
    if (isset($_SESSION['vehicle_details'])) {
        $vehicle_details = $_SESSION['vehicle_details'];
    }

    $get_vehicles = get_rows_from_one_table('vehicles', 'date_created');
    $get_vehicle_brands = get_rows_from_one_table('vehicle_brands', 'brand_name', "ASC");
    $get_vehicle_models = get_rows_from_one_table('vehicle_models', 'datetime');
    $get_insurer = get_rows_from_one_table('insurers', 'datetime');

?>
<div id="main">
<style type="text/css">
    #bar, #others {display:none;}
</style> 

<div class="main-content container-fluid" id="appWrapper" v-cloak>
    <div class="page-title">
        <h3>Provide Vehicle Details</h3>
        <p class="text-subtitle text-muted">Complete the information to purchase your insurance plan</p>
    </div>

    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-right">
                <li class="breadcrumb-item"><a href="select_action.php">Back</a></li>
                <li class="breadcrumb-item"><a href="#">Vehicle Details</a></li>
            </ol>
        </nav>
    </div>


    <section class="section mt-5">

        <div class="col-md-8 col-sm-12 mx-auto">
            <div class="card">
                <div class="container">
                    <ul class="nav nav-tabs" role="tablist">
                        <div class="col-md-12 text-center">
                            <li role="presentation" class="active">
                                <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
                                    <span class="">
                                        <i data-feather="book" width="100"></i>
                                        <p>Vehicle Details</p>
                                    </span>
                                </a>
                            </li>
                        </div>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-10 col-sm-12 mx-auto">
            <div class="card">
                <div class="card-body">

                    <div class="tab-content">
                        <div class="tab-pane active" role="tabpanel" id="step1">
                            <form class="form" id="vehicle_details" method="post" enctype="multipart/form-data"> <!--action="buy_package.php" -->

                                <div class="row">

                                    <div class="col-md-6 col-12">

                                        <div class="form-group">
                                            <label for="Usagecolumn">Usage</label>
                                            <select class="form-select" name="usage" id="basicSelect">
                                                <option value="">Select Usage</option>
                                                <option value="PrivateAndBusiness" <?php echo isset($vehicle_details["usage"]) && $vehicle_details["usage"] == "Private"?"selected":""; ?>>Private</option>
                                                <option value="PrivateAndBusiness" <?php echo isset($vehicle_details["usage"]) && $vehicle_details["usage"] == "Private"?"selected":""; ?>>Business</option>
                                                <option value="PrivateAndBusiness" <?php echo isset($vehicle_details["usage"]) && $vehicle_details["usage"] == "PrivateAndBusiness"?"selected":""; ?>>Private and Business</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="VehicleType">Vehicle Type</label>
                                            <select name="vehicle_type"
                                            class="form-select" v-model="vehicleType">
                                                <option value="">Select Type</option>
                                                <?php
                                                    foreach ($get_vehicles as $vehicle) {
                                                    ?>
                                                    <option value="<?= $vehicle['unique_id']?>"><?= $vehicle['vehicle_type']?></option>
                                                <?php }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="Maker">Make of Vehicle</label>
                                            <select  name="make_of_vehicle"
                                            class="form-select"
                                            v-model="vehicleMake">
                                                <option value="">Select vehicle brand</option>
                                                <?php
                                                    foreach ($get_vehicle_brands as $brand) {
                                                    ?>
                                                <option value="<?= $brand['brand_name']?>" >
                                                    <?= $brand['brand_name']?>
                                                </option>
                                                <?php
                                                    }
                                                ?>
                                                <option value="others">Others</option>
                                            </select>
                                            <div id="other_vehicle_make" class="mt-3" v-show="vehicleMake == 'others'">
                                                <input type="text" name="other_vehicle_make" class="form-control" placeholder="Please Specify">
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
                                            <label for="Modelcolumn">Vehicle Model</label>
                                            <select class="form-select" name="vehicle_model" id="vehicle_model" v-model="vehicleMakeModel">
                                                <option value="">Select Vehicle Model</option>
                                                <option v-for="(model, index) in vehicleMakeModels"
                                                :key="index" :value="model.Model">
                                                    {{model.Model}}
                                                </option>
                                                <option value="others" v-if="finishedFetchingModels">Others</option>
                                            </select>
                                            <div id="other_vehicle_model" class="mt-3 d-none">
                                                <input type="text" name="other_vehicle_model" class="form-control" placeholder="Please Specify">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="year_of_make">Year of Make</label>
                                            <select class="form-select" name="year_of_make" id="year_of_make">
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
                                            <label for="RegistrationNumber">Vehicle Registration Number</label>
                                            <input type="text" id="Registration" class="form-control" name="vehicle_reg_no" value="<?php echo $vehicle_details["vehicle_reg_no"] ?? ""; ?>" placeholder="Vehicle Registration Number">
                                        </div>

                                        <div class="form-group">
                                            <label for="chassis_number">Chassis Number</label>
                                            <input type="text" id="Chassis" value="<?php echo $vehicle_details["chassis_number"] ?? ""; ?>" class="form-control" name="chassis_number" placeholder="Chassis Number">
                                        </div>

                                        <div class="form-group">
                                            <label for="EngineNumber">Engine Number</label>
                                            <input type="text" id="EngineNumber" value="<?php echo $vehicle_details["engine_number"] ?? ""; ?>" class="form-control" name="engine_number" placeholder="Engine Number">
                                        </div>

                                    </div>

                                    <div class="col-md-6 col-12">

                                        <div class="form-group">
                                            <label for="risk_location">Location Of Vehicle (include city)</label>
                                            <input type="text" id="risk_location" class="form-control" value="<?php echo $vehicle_details["risk_location"] ?? ""; ?>" name="risk_location" placeholder="Enter Vehicle Location eg. Ibadan">
                                        </div>

                                        <div class="form-group">
                                            <label for="InsuredName">Insured Name (if different from your name)</label>
                                            <input type="text" id="InsuredName" value="<?php echo $vehicle_details["insured_name"] ?? ""; ?>" class="form-control" name="insured_name" placeholder="Insured Name">
                                        </div>

                                        <div class="form-group">
                                            <label for="SumInsured">Sum Insured (Value of Vehicle to be Insured)</label>
                                            <input type="text" id="SumInsured" value="<?php echo $vehicle_details["sum_insured"] ?? ""; ?>" class="form-control" name="sum_insured" placeholder="Sum Insured">
                                        </div>

                                        <div class="form-group">
                                            <label for="insured_type">Insured Type</label>
                                            <select name="insured_type" class="form-select">
                                                <option value="">Select Insured Type</option>
                                                <option value="Spouse" <?php echo isset($vehicle_details["insured_type"]) && $vehicle_details["insured_type"] == "Spouse"?"selected":""; ?>>Spouse</option>
                                                <option value="Other" <?php echo isset($vehicle_details["insured_type"]) && $vehicle_details["insured_type"] == "Other"?"selected":""; ?>>Other</option>
                                                <!-- <option value="Option3">Option3</option> -->
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="PolicyStartDate">Policy Start Date (Date of commencement)</label>
                                            <input type="date" id="PolicyStartDate" value="<?php echo $vehicle_details != null? $vehicle_details["policy_start_date"]:""; ?>" class="form-control" name="policy_start_date" placeholder="Policy Start Date">
                                        </div>

                                        <div class="form-group">
                                            <label for="PolicyEndDate">Policy End Date (Policy expiry date)</label>
                                            <input type="date" id="PolicyEndDate" class="form-control" name="policy_end_date" value="<?php echo $vehicle_details != null? $vehicle_details["policy_end_date"]:""; ?>" placeholder="Policy End Date" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="risk_image">Risk Image (Upload vehicle image)</label>
                                            <input type="file" id="risk_image" class="form-control" name="risk_image" value="" placeholder="Policy Start Date">
                                        </div>

                                        <div class="form-group">
                                            <label for="identity_image">Identity Image (Upload your valid Govt. issued ID)</label><br />
                                            <i style="color:tomato; font-size:small;">Note: The image on your ID must tally with your profile picture</i>
                                            <input type="file" id="identity_image" class="form-control" name="identity_image" value="" placeholder="Policy Start Date">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="text-center">
                                        <button type="submit" id="submit_vehicle_details" name="submit_vehicle_details" class="btn btn-primary mr-1 mb-1">Submit</button>
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

<script type="application/javascript" src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>

<?php include("includes/footer.php");?>

<?php include("includes/vueInstanceVehicle.php");?>


<script>



    $("#PolicyStartDate").on("input", function(e) {

        var d = new Date($(this).val()); // Date object

        var amountOfYearsRequired = 1;
        d.setFullYear(d.getFullYear() + amountOfYearsRequired); // This sets the date object to next year date object
        d.setDate(d.getDate() - 1);

        var date = new Date(d);
        var result = date.toISOString().split('T')[0]; // Gives YYY-MM-DD string

        $("#PolicyEndDate").val(result)


    })
</script>