<?php
include("includes/sidebar.php");
include("includes/header.php");

$get_vehicle_types = get_rows_from_table('vehicles');
$get_vehicle_brands = get_rows_from_table('vehicle_brands');
$get_permit_types = get_rows_from_table('services');
?> 

<div id="main">

<style type="text/css">
/* #bar, #cus {display:none;} */
</style>
<script>
// function show(el, txt){
    // var elem1 = document.getElementById('bar');
    // var elem2 = document.getElementById('cus');

    // elem1.style.display = (txt == 'Comprehensive Insurance') ? 'block' : 'none';
    // elem2.style.display = (txt == 'Custom number plate') ? 'block' : 'none';
    // }
</script>           
<div class="main-content container-fluid">
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
                                            <select class="form-select" name="vehicle_type" required>
                                                <option value="">Select vehicle type</option>
                                                <!-- <option>Motorcycle/Tricycle</option>
                                                <option>Saloon Car - Med (1.4-1.9L) e.g. Picanto, Corolla, Almera</option>
                                                <option>Saloon Car - Maxi (1.4-1.9L) e.g. Camry, Benz, Accord</option>
                                                <option>SUV/Jeep/Bus/Pick-up</option>
                                                <option>Coaster Bus</option>
                                                <option>Mini Trucks/ Trucks 15 Tons (Tippers)</option>
                                                <option>Trucks 20 Tons (6-10 Tyres)</option>
                                                <option>Trucks 30 Tons (10+ Tyres)</option> -->
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
                                            <select class="form-select" class="make_of_vehicle" name="make_of_vehicle" id="make_of_vehicle" required>
                                                <option value="">Vehicle make</option>
                                                <?php
                                                    foreach($get_vehicle_brands as $vehicle_brand){
                                                ?>
                                                    <option data-brandId="<?php echo $vehicle_brand["unique_id"] ?>" value="<?php echo $vehicle_brand["brand_name"]?>" <?php echo isset($vehicle_details["make_of_vehicle"]) && $vehicle_details["make_of_vehicle"] == $vehicle_brand["brand_name"]?"selected":""; ?>><?php echo $vehicle_brand["brand_name"]?></option>
                                                <?php    
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-select" id="vehicle_model" name="vehicle_model" required>
                                                <option name="">Select Vehicle Model</option>
                                            </select>
                                        </div>
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
                                            <input type="text" id="Vehicle" class="form-control" placeholder="Enter Engine number (optional)" name="engine_no" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="chasis" class="form-control" placeholder="Enter Chasis number" name="chassis_no" required>
                                        </div>
                                         <div class="form-group">
                                            <input type="text" id="chasis" class="form-control" placeholder="Name on Vehicle License" name="vehicle_license" required>
                                        </div>

                                        <!-- <div class="form-group">
                                    <input type="number" id="Phone" class="form-control" placeholder="Phone number" name="">
                                </div> -->

                                <div class="form-group">
                                    <select class="form-select" name="vehicle_color" required>
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
                                            <input type="checkbox" class="form-check-input form-check-primary" name="road_worthiness" id="customColorCheck1">
                                            <label class="form-check-label" for="customColorCheck1">Road Worthiness</label>
                                        </div>
                                    </div>
                                </li>

                                <li class="d-inline-block mr-2 mb-1">
                                    <div class="form-check">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="form-check-input form-check-success" name="hackey_permit" id="customColorCheck3" >
                                            <label class="form-check-label" for="customColorCheck3">Hackney Permit</label>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-inline-block mr-2 mb-1">
                                    <div class="form-check">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="form-check-input form-check-danger"  name="vehicle_license" id="customColorCheck4">
                                            <label class="form-check-label" for="customColorCheck4">Vehicle License</label>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="form-group">
                                <!-- class="choices form-select multiple-remove" multiple="multiple" -->
                                <select class="form-select" name="permit_type" required> 
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
                                <select name="insurance_type" class="form-select" required> <!--  onChange="show('bar', this.options[this.selectedIndex].firstChild.nodeValue)" -->
                                    <option value="">Insurance type</option>
                                    <option value="third_party_insurance">3rd Party Insurance</option>
                                    <option value="comprehensive_insurance">Comprehensive Insurance</option>
                                    <option value="no_insurance">(No Insurance)</option>
                                </select>
                            </div>
                            <!-- <div id="bar">
                                 <div class="form-group">
                                   <select class="form-select">
                                                <option>Select Plan</option>
                                                <option> Bronze</option>
                                                <option> Silver</option>
                                            </select>
                                </div>
                            </div> -->
                                        <!-- <div class="form-group">
                                            <select name="thename" class="form-select" onChange="show('cus', this.options[this.selectedIndex].firstChild.nodeValue)">
                                                <option>Type of number plate</option>
                                                <option> Private number plate</option>
                                                <option> Commercial number plate</option>
                                                <option>Custom number plate</option>
                                            </select>
                                        </div>
                                <div id="cus">
                                    <div class="form-group">
                                        <span>Preferrred Number Plate</span>
                                        <input type="text" name="plate" class="form-control" placeholder="e.g (KET-123A)">
                                    </div>
                                </div> -->
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