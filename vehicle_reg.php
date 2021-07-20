<?php
    include("includes/sidebar.php");
    $get_vehicles = get_rows_from_one_table('vehicles', 'date_created');
    $get_vehicle_brands = get_rows_from_one_table('vehicle_brands', 'brand_name', "ASC");
    $get_vehicle_models = get_rows_from_one_table('vehicle_models', 'datetime');
    $get_insurer = get_rows_from_one_table('insurers', 'datetime');

    $insurance_plans = [];
    if(isset($_GET['pi'])){
        $insurer_id = $_GET['pi'];
        $insurance_plans = get_rows_from_table_with_one_params("insurance_plans", 'insurer_id', $insurer_id);
    }

?>
<div id="main">

    <?php include("includes/header.php");?> 
    <style type="text/css">
        #cus {display:none;}
    </style>

    <div class="main-content container-fluid" id="appWrapper">
        <div class="page-title">
            <h3>New Vehicle Registration</h3>
            <p class="text-subtitle text-muted">Please fill all the fields below</p>
        </div>


        <section class="section mt-5" id="multiple-column-form ">
            <div class="row match-height">
                <div class="col-7 mx-auto">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" method="post" id="vehicle_registration_form">
                                    <div class="row">
                                        <div class="col-md-12 col-12">

                                            <div class="mt-3">
                                                <h4 class="card-title">Vehicle Details</h4>
                                            </div>

                                            <div class="form-group">
                                                <label for="vehicle_type">Vehicle Type</label>
                                                <select class="form-select" id="vehicle_type" name="vehicle_type"
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
                                                <div id="other_vehicle_model" class="mt-3 d-none">
                                                    <input type="text" name="other_vehicle_model" class="form-control" placeholder="Please Specify">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="year_of_make">Vehicle Year</label>
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
                                                <label for="engine_number">Engine Number</label>
                                                <input type="text" class="form-control" placeholder="Enter Engine number" name="engine_number" id="engine_number">
                                            </div>
                                            <div class="form-group">
                                                <label for="chasis_number">Chasis Number</label>
                                                <input type="text" id="chasis_number" class="form-control" placeholder="Enter Chasis number" name="chasis_number">
                                            </div>
                                            <div class="form-group">
                                                <label for="vehicle_color">Vehicle Color</label>
                                                <select class="form-select" id="vehicle_color" name="vehicle_color">
                                                    <option>Select color</option>
                                                    <option value="Blue">Blue</option>
                                                    <option value="Red">Red</option>
                                                    <option value="Grey">Grey</option>
                                                    <option value="Black">Black</option>
                                                    <option value="White">White</option>
                                                    <option value="Wine">Wine</option>
                                                    <option value="Green">Green</option>
                                                    <option value="others">Others</option>
                                                </select>
                                                <div id="other_vehicle_color" class="mt-3 d-none">
                                                    <input type="text" name="other_vehicle_color" class="form-control" placeholder="Please Specify">
                                                </div>
                                            </div>

                                            <div class="mt-5">
                                                <h4 class="card-title">Personal Information & Documents</h4>
                                            </div>

                                            <div class="form-group">
                                                <label for="occupation">Occupation</label>
                                                <input type="text" id="occupation" class="form-control" placeholder="Occupation" name="occupation">
                                            </div>
                                            <div class="form-group">
                                                <label for="date_of_birth">Date of birth</label>
                                                <input type="date" id="date_of_birth" class="form-control" placeholder="Date of birth" name="date_of_birth">
                                            </div>
                                            <div class="form-group">
                                                <label for="contact_address">Contact address</label>
                                                <input type="text" id="contact_address" class="form-control" placeholder="Contact address" name="contact_address">
                                            </div>

                                            <div class="mt-5">
                                                <h4 class="card-title">Upload Vehicle Particulars</h4>
                                                <span>Upload pictures of pages of the Original Custom Papers of the vehicle or original local receipt of purchase. Please use your camera flash when taking the picture</span>
                                            </div>
                                            <div class="form-group">
                                                <input type="file" id="files" class="form-control" name="files[]" multiple>
                                            </div>
                                            <span id="uploaded_image"></span>
                                            <input type="hidden" name="vehicle_particulars" id="vehicle_particulars">

                                            <div class="mt-5">
                                                <h4 class="card-title">Preferences</h4>
                                            </div>

                                            <div class="form-group">
                                                <label for="name">Vehicle Registration Name</label>
                                                <input type="text" id="name" class="form-control" placeholder="Name to register vehicle with" name="name_on_vehicle">
                                            </div>
                                            <div class="form-group">
                                                <label for="phone">Phone</label>
                                                <input type="number" id="phone" class="form-control" placeholder="Phone number" name="phone">
                                            </div>
                                            <div class="form-group">
                                                <label for="insurance_type">Inurance Type</label>
                                                <select name="insurance_type" id="insurance_type"
                                                class="form-select" v-model="insuranceType">
                                                    <option value="">Insurance type</option>
                                                    <option value="third_party_insurance">3rd Party Insurance</option>
                                                    <option value="comprehensive_insurance">Comprehensive Insurance</option>
                                                    <option value="no_third_party_insurance">(No Insurance)</option>
                                                </select>
                                            </div>
                                            <div id="bar" v-show="insuranceType == 'comprehensive_insurance'">
                                                <div class="form-group">
                                                    <label for="insurer">Insurer</label>
                                                    <select class="form-select" name="insurer" id="insurer"
                                                    v-model="preferredInsurer">
                                                        <option value="">Select Insurer</option>
                                                        <?php
                                                            foreach ($get_insurer as $insurer) {
                                                        ?>
                                                            <option value="<?= $insurer['unique_id']?>"><?= $insurer['name']?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <center>
                                                    <div id="spinner_class2" class="d-none">
                                                        <div class="spinner-border text-primary" role="status">
                                                            <span class="sr-only">Loading...</span>
                                                        </div>
                                                    </div>
                                                </center>
                                                <div class="form-group">
                                                    <label for="plan_type">Plan</label>
                                                    <select class="form-select" name="plan_type" id="plan_type"
                                                    v-model="plan">
                                                        <option value="">Select Plan</option>
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
                                                <div class="form-group">
                                                    <label for="vehicle_value">Vehicle Value</label>
                                                    <input type="number" name="vehicle_value" id="vehicle_value" class="form-control" placeholder="Value of Vehicle (in naira)"
                                                    v-model="vehicleValue">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="plate_number_type">Number Plate Type</label>
                                                <select name="plate_number_type" id="plate_number_type" class="form-select" v-model="numberPlateType">
                                                    <option value="">Type of number plate</option>
                                                    <option value="private"> Private number plate</option>
                                                    <option value="commercial"> Commercial number plate</option>
                                                    <option value="personalized_number">Custom number plate</option>
                                                </select>
                                            </div>
                                            <div id="cus">
                                                <div class="form-group">
                                                    <label for="number_plate">Preferrred Number Plate</label>
                                                    <input type="text" name="number_plate" id="number_plate" class="form-control" placeholder="e.g (KET-123A)">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="state">State of Registration</label>
                                                <select name="state" class="form-select" id="state">
                                                    <option>Preferred State of Registration</option>
                                                    <option value="lagos">Lagos</option><!-- 
                                                    <option value="state">Adamawa</option>
                                                    <option value="state">Oyo</option> -->
                                                </select>
                                            </div>
                                            <div class="state box">
                                                <div class="form-group">
                                                    <label for="first_lg">1st Preferrred Local Government of Registration</label>
                                                    <select name="first_lg" class="form-select" id="first_lg">
                                                            <option> 1st Preferrred local government</option>
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
                                                    <label for="second_lg">2nd Preferrred Local Government of Registration</label>
                                                    <select name="second_lg" class="form-select" id="second_lg">
                                                        <option>2nd Preferrred local government</option>
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
                                                    <label for="third_lg">3rd Preferrred Local Government of Registration</label>
                                                    <select name="third_lg" class="form-select" id="third_lg">
                                                        <option>3rd Preferrred local government</option>
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
                                            </div>

                                            <div class="form-group">
                                                <label for="tinted_permit">Do you want to obtain a Tinted permit?</label>
                                                <select class="form-select" id="tinted_permit" name="tinted_permit">
                                                    <option>Select</option>
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="vehicleRegAgreement">
                                                    I hereby admit that if any of my preferred lga is not available, the admin can pick any other lga for me
                                                </label>
                                                <input type="checkbox" name="agreement" id="vehicleRegAgreement"
                                                v-model="vehicleRegAgreement">
                                            </div>

                                        </div>

                                        <!-- </div> -->
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="button" id="submit_vehicle_registration" class="btn btn-primary mr-1 mb-1" :disabled="!vehicleRegAgreement">Proceed</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>

<script type="application/javascript" src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
<!-- <script type="application/javascript" src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> -->
<?php include("includes/footer.php");?>

<?php include("includes/vueInstanceVehicle.php");?>


<script type="application/javascript">
    $(document).ready(function(){
        // $("select").change(function(){
        //     $(this).find("option:selected").each(function(){
        //         var optionValue = $(this).attr("value");
        //         if(optionValue){
        //             $(".state").not("." + optionValue).hide();
        //             $("." + optionValue).show();
        //         } else{
        //             $(".state").hide();
        //         }
        //     });
        // }).change();

        $("#insurance_type").change(function(){
            var selected_option = $(this).children("option:selected").val();
            $("#bar").hide();
            if(selected_option == 'comprehensive_insurance'){
                $("#bar").show();
            }
        });

        $("#plate_number_type").change(function(){
            var selected_option = $(this).children("option:selected").val();
            $("#cus").hide();
            if(selected_option == 'personalized_number'){
                $("#cus").show();
            }
        });

        $("#vehicle_color").change(function(){
            var selected_option = $(this).children("option:selected").val();
            $("#other_vehicle_color").addClass("d-none");
            if(selected_option == 'others'){
                $("#other_vehicle_color").removeClass("d-none");
            }
        });

        $("#vehicle_make").change(function(){
            var selected_option = $(this).children("option:selected").val();
            $("#other_vehicle_make").addClass("d-none");
            if(selected_option == ''){
                alert("Please select an option");
            }
            else if(selected_option == "others"){
                $("#other_vehicle_make").removeClass("d-none");
            }
            else{
                $.ajax({
                    url: "ajax/get_vehicle_reg_model",
                    method: "POST",
                    data: {"vehicle_make": selected_option},
                    beforeSend: function(){
                        $("#spinner_class").removeClass("d-none");
                    },
                    success: function(data){
                        $("#spinner_class").addClass("d-none");
                        //console.log(data);
                        $("#vehicle_model").html(data);
                    }
                })
            }
        });

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
                    beforeSend: function(){
                        $("#spinner_class2").removeClass("d-none");
                    },
                    success: function(data){
                        $("#spinner_class2").addClass("d-none");
                        //console.log(data);
                        $("#plan_type").html(data);
                    }
                })
            }
        });

        $("#vehicle_model").change(function(){
            var selected_option = $(this).children("option:selected").val();
            $("#other_vehicle_model").addClass("d-none");
            if(selected_option == ''){
                alert("Please select an option");
            }
            else if(selected_option == "others"){
                $("#other_vehicle_model").removeClass("d-none");
            }
        });

    });

    $(document).on('change', '#files', function(){
        let unique_id3 = $("#name").val();
        var form_data = new FormData();
        // Read selected files
        var totalfiles = document.getElementById('files').files.length;
        for (var index = 0; index < totalfiles; index++) {
          form_data.append("files[]", document.getElementById('files').files[index]);
        }
        $.ajax({
            url: 'upload_vehicle_images.php', 
            type: 'post',
            data: form_data,
            dataType: 'json',
            contentType: false,
            processData: false,
            beforeSend:function(){
                $('#uploaded_image').html("<label class='text_primary'><b>Image Uploading, please wait...</b></label>");
            },
            success: function (response) {
                $('#uploaded_image').html("<label class='text_success'><b>Image Uploaded</b></label>");
                $('#vehicle_particulars').val(response);
            }
        });
    });

</script>