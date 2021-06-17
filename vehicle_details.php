<?php 
include("includes/sidebar.php");
include("includes/header.php");

$get_make_of_vehicles = get_rows_from_table('vehicle_brands');

if (isset($_SESSION['vehicle_details'])) {
$vehicle_details = $_SESSION['vehicle_details'];
}

?>
<div id="main">
<style type="text/css">
#bar, #others {display:none;}
</style>
<script>
function show(el, txt){
    var elem1 = document.getElementById('bar');
    var elem2 = document.getElementById('others');

    elem1.style.display = (txt == 'No') ? 'block' : 'none';
    elem2.style.display = (txt == 'Others') ? 'block' : 'none';
    }
</script>   

<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Provide Vehicle Details</h3>
        <p class="text-subtitle text-muted">Complete the information to purchase your insurance plan</p>
    </div>
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

                    <!-- <div class="col-md-6 text-center">
                        <li role="presentation" class="disabled">
                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                            <a href="attachments.php" class="">
                                <i data-feather="git-commit" width="100"></i>
                                <p>Attachments</p>
                            </a>
                        </a>
                    </li>
                    </div> -->
                </ul>
                </div>
    </div>
</div>
<!-- details -->

    <div class="col-md-10 col-sm-12 mx-auto">
      <div class="card">
         <div class="card-body">

                    <div class="tab-content">
                    <div class="tab-pane active" role="tabpanel" id="step1">
                        <form class="form" id="vehicle_details" method="post" enctype="multipart/form-data"> <!--action="buy_package.php" -->
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <fieldset class="form-group">
                                            <span for="Usagecolumn">Usage</span>
                                            <select class="form-select" name="usage" id="basicSelect">
                                            <option value="">Select Usage</option>
                                            <option value="PrivateAndBusiness" <?php echo isset($vehicle_details["usage"]) && $vehicle_details["usage"] == "Private"?"selected":""; ?>>Private</option>
                                            <option value="PrivateAndBusiness" <?php echo isset($vehicle_details["usage"]) && $vehicle_details["usage"] == "Private"?"selected":""; ?>>Business</option>
                                            <option value="PrivateAndBusiness" <?php echo isset($vehicle_details["usage"]) && $vehicle_details["usage"] == "PrivateAndBusiness"?"selected":""; ?>>Private and Business</option>
                                        </select>
                                    </fieldset>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <fieldset class="form-group">
                                            <span for="Maker">Make of Vehicle</span>
                                            <!-- <select id="basicS" name="make_of_vehicle" class="form-select" onChange="show('others', this.options[this.selectedIndex].firstChild.nodeValue)">
                                                <option value="">Select make</option>
                                                <option value="Honda" <?php // echo isset($vehicle_details["make_of_vehicle"]) && $vehicle_details["make_of_vehicle"] == "Honda"?"selected":""; ?>>Honda</option>
                                                <option value="Toyota" <?php // echo isset($vehicle_details["make_of_vehicle"]) && $vehicle_details["make_of_vehicle"] == "Toyota"?"selected":""; ?>>Toyota</option>
                                                <option value="Audi" <?php // echo isset($vehicle_details["make_of_vehicle"]) && $vehicle_details["make_of_vehicle"] == "Audi"?"selected":""; ?>>Audi</option>
                                                <option value="Others" <?php // echo isset($vehicle_details["make_of_vehicle"]) && $vehicle_details["make_of_vehicle"] == "Others"?"selected":""; ?>>Others</option>
                                            </select> -->
                                            <select id="basicS" name="make_of_vehicle" class="form-select make_of_vehicle">
                                                <option value="">Select vehicle brand</option>
                                                <?php
                                                    foreach($get_make_of_vehicles as $vehicle_brand){
                                                ?>
                                                    <option data-brandId="<?php echo $vehicle_brand["unique_id"] ?>" value="<?php echo $vehicle_brand["brand_name"]?>" <?php echo isset($vehicle_details["make_of_vehicle"]) && $vehicle_details["make_of_vehicle"] == $vehicle_brand["brand_name"]?"selected":""; ?>><?php echo $vehicle_brand["brand_name"]?></option>
                                                <?php    
                                                }
                                                ?>
                                            </select>
                                        </fieldset>
                                    </div>

                                    <div id="others">
                                        <div class="form-group">
                                            <span for="Makecolumn">Other Maker of Vehicle</span>
                                            <input type="text" id="Vehiclename" class="form-control" value="<?php $vehicle_details["other_make_of_vehicle"] ?? ""; ?>" placeholder="Other Make of Vehicle" name="other_make_of_vehicle">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="VehicleType">Vehicle Type</span>
                                            <select id="" name="vehicle_type"  class="form-select">
                                                <option value="">Select Type</option>
                                                <option value="323" <?php echo isset($vehicle_details["vehicle_type"]) && $vehicle_details["vehicle_type"] == "323"?"selected":""; ?>>SUV</option>
                                                <option value="323" <?php echo isset($vehicle_details["vehicle_type"]) && $vehicle_details["vehicle_type"] == "323"?"selected":""; ?>>Car</option>
                                                <option value="323" <?php echo isset($vehicle_details["vehicle_type"]) && $vehicle_details["vehicle_type"] == "323"?"selected":""; ?>>Bus</option>
                                            </select>
                                        </div>
                                    </div>

                                    
                                    <!-- <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="BackValue">Excess Buy BackValue</span>
                                            <input type="number" id="BackValue" class="form-control" placeholder="Excess Buy BackValue" name="BackValue">
                                        </div>
                                    </div> -->

                        <!-- <div class="col-md-6 col-12">
                            <div class="form-group">
                                <div class="row">
                                    <span for="Flood">Flood Cover </span>
                                        <div class="col-md-3 col-12">
                                           <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" checked>
                                           <label class="form-check-label" for="gridRadios1">True</label>
                                           </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
                                            <label class="form-check-label" for="gridRadios2">False</label>
                                           </div>
                                        </div>
                                </div>
                            </div>
                        </div> -->

                        <!-- <div class="col-md-6 col-12">
                            <div class="form-group">
                                <div class="row">
                                    <span for="Vehicle">Vehicle Replacement</span>
                                        <div class="col-md-3 col-12">
                                           <div class="form-check">
                                            <input class="form-check-input" type="radio" name="Vehicle" id="Vehicle1">
                                            <label class="form-check-label" for="Vehicle3"> True </label>
                                           </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-check">
                                            <input class="form-check-input" type="radio" name="Vehicle" id="Vehicle2" checked="">
                                            <label class="form-check-label" for="Vehicle4"> False </label>
                                           </div>
                                        </div>
                                </div>
                            </div>
                        </div>
 -->
                        <!-- <div class="col-md-6 col-12">
                            <div class="form-group">
                                <div class="row">
                                    <span for="Tracker">Tracker Discount</span>
                                        <div class="col-md-3 col-12">
                                           <div class="form-check">
                                            <input class="form-check-input" type="radio" name="trackRadios" id="trackRadios1" value="option1" checked>
                                           <label class="form-check-label" for="trackRadios1">True</label>
                                           </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-check">
                                            <input class="form-check-input" type="radio" name="trackRadios" id="trackRadios2" value="option2">
                                            <label class="form-check-label" for="trackRadios2">False</label>
                                           </div>
                                        </div>
                                </div>
                            </div>
                        </div> -->

                        <!-- <div class="col-md-6 col-12">
                            <div class="form-group">
                                <div class="row">
                                    <span for="Tracker">Tracker</span>
                                        <div class="col-md-3 col-12">
                                           <div class="form-check">
                                            <input class="form-check-input" type="radio" name="tRadios" id="tRadios1" value="option1" checked>
                                           <label class="form-check-label" for="tRadios1">True</label>
                                           </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-check">
                                            <input class="form-check-input" type="radio" name="tRadios" id="tRadios2" value="option2">
                                            <label class="form-check-label" for="tRadios2">False</label>
                                           </div>
                                        </div>
                                </div>
                            </div>
                        </div> -->

                               <!--  <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="TrackerAmount">Tracker Amount</span>
                                            <input type="number" id="Tracker" class="form-control" name="Vehicle" placeholder="Tracker Amount">
                                        </div>
                                    </div> -->

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="RegistrationNumber">Vehicle Registration Number</span>
                                            <input type="text" id="Registration" class="form-control" name="vehicle_reg_no" value="<?php echo $vehicle_details["vehicle_reg_no"] ?? ""; ?>" placeholder="Vehicle Registration Number">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="Modelcolumn">Vehicle Model</span>
                                            <select class="form-select" name="vehicle_model" id="vehicle_model">
                                            <option value="">Select Vehicle Model</option>
                                            <?php
                                                if (isset($vehicle_details["vehicle_model"])) {
                                            ?>
                                                    <option value="<?= $vehicle_details["vehicle_model"]?>" selected><?= $vehicle_details["vehicle_model"]?></option>
                                            <?php
                                                }
                                            ?>
                                            
                                            <!-- <option value="Accord" <?php //echo isset($vehicle_details["vehicle_model"]) && $vehicle_details["vehicle_model"] == "Accord"?"selected":""; ?>>Accord</option> -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="year_of_make">Year of Make</span>
                                            <!-- <input type="text" id="year_of_make" value="<?php //echo $vehicle_details["year_of_make"] ?? ""; ?>" class="form-control" placeholder="Year of Make" name="year_of_make"> -->
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
                                    </div>

                                     <!-- <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="Location">Location of Risk</span>
                                            <input type="text" id="Location" class="form-control" placeholder="Location of Risk" name="Location">
                                        </div>
                                    </div>
                                     <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="OtherLocation">Other Location of Risk</span>
                                            <input type="text" id="OtherLocation" class="form-control" placeholder="Other Location of Risk" name="Yearcolumn">
                                        </div>
                                    </div> -->
                                    
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="chassis_number">Chassis Number</span>
                                            <input type="text" id="Chassis" value="<?php echo $vehicle_details["chassis_number"] ?? ""; ?>" class="form-control" name="chassis_number" placeholder="Chassis Number">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="EngineNumber">Engine Number</span>
                                            <input type="text" id="EngineNumber" value="<?php echo $vehicle_details["engine_number"] ?? ""; ?>" class="form-control" name="engine_number" placeholder="Engine Number">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="risk_location">Location Of Vehicle (include city)</span>
                                            <input type="text" id="risk_location" class="form-control" value="<?php echo $vehicle_details["risk_location"] ?? ""; ?>" name="risk_location" placeholder="Enter Vehicle Location eg. Ibadan">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="InsuredName">Insured Name (if different from your name)</span>
                                            <input type="text" id="InsuredName" value="<?php echo $vehicle_details["insured_name"] ?? ""; ?>" class="form-control" name="insured_name" placeholder="Insured Name">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="SumInsured">Sum Insured (Value of Vehicle to be Insured)</span>
                                            <input type="text" id="SumInsured" value="<?php echo $vehicle_details["sum_insured"] ?? ""; ?>" class="form-control" name="sum_insured" placeholder="Sum Insured">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="insured_type">Insured Type</span>
                                            <select name="insured_type" class="form-select">
                                                <option value="">Select Insured Type</option>
                                                <option value="Spouse" <?php echo isset($vehicle_details["insured_type"]) && $vehicle_details["insured_type"] == "Spouse"?"selected":""; ?>>Spouse</option>
                                                <option value="Other" <?php echo isset($vehicle_details["insured_type"]) && $vehicle_details["insured_type"] == "Other"?"selected":""; ?>>Other</option>
                                                <!-- <option value="Option3">Option3</option> -->
                                            </select>
                                        </div>
                                    </div>

                               
                                   
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="PolicyStartDate">Policy Start Date (Date of commencement)</span>
                                            <input type="date" id="PolicyStartDate" value="<?php echo $vehicle_details["policy_start_date"] != null? $vehicle_details["policy_start_date"]:""; ?>" class="form-control" name="policy_start_date" placeholder="Policy Start Date">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="PolicyEndDate">Policy End Date (Policy expiry date)</span>
                                            <input type="date" id="PolicyEndDate" class="form-control" name="policy_end_date" value="<?php echo $vehicle_details["policy_end_date"] != null? $vehicle_details["policy_end_date"]:""; ?>" placeholder="Policy End Date" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="risk_image">Risk Image (Upload vehicle image)</span>
                                            <input type="file" id="risk_image" class="form-control" name="risk_image" value="" placeholder="Policy Start Date">
                                        </div>
                                    </div>  

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="identity_image">Identity Image (Upload your valid Govt. issued ID)</span><br />
                                            <i style="color:tomato; font-size:small;">Note: The image on your ID must tally with your profile picture</i>
                                            <input type="file" id="identity_image" class="form-control" name="identity_image" value="" placeholder="Policy Start Date">
                                        </div>
                                    </div>   


                                    <!-- <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="PolicyEndDate">Policy End Date</span>
                                            <input type="date" id="PolicyEndDate" class="form-control" name="PolicyEndDate" placeholder="Policy End Date">
                                        </div>
                                    </div> -->

                                    <!-- <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="SumInsuredType">Sum Insured Type</span>
                                            <input type="text" id="SumInsuredType" class="form-control" name="SumInsuredType" placeholder="Sum Insured Type">
                                        </div>
                                    </div>
 -->
                                    <!-- <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="Currency">Currency</span>
                                            <input type="text" id="Currency" class="form-control" name="Currency" placeholder="Currency">
                                        </div>
                                    </div> -->


                                    <!-- </div>
                                    </div> -->




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
<script type="text/javascript">
    
</script>
<?php include("includes/footer.php");?>

<script>



    $("#PolicyStartDate").on("input", function(e) {

        var d = new Date($(this).val()); // Date object

        var amountOfYearsRequired = 1;
        d.setFullYear(d.getFullYear() + amountOfYearsRequired); // This sets the date object to next year date object

        var date = new Date(d);
        var result = date.toISOString().split('T')[0]; // Gives YYY-MM-DD string

        $("#PolicyEndDate").val(result)


    })
</script>