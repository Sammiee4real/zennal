<?php include("includes/sidebar.php");
    $get_vehicles = get_rows_from_one_table('vehicles', 'date_created');
    $get_vehicle_brands = get_rows_from_one_table('vehicle_brands', 'datetime');
    $get_vehicle_models = get_rows_from_one_table('vehicle_models', 'datetime');
?>
<div id="main">

<?php include("includes/header.php");?> 
<style type="text/css">
#bar, #cus {display:none;}
</style>

<div class="main-content container-fluid">
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
                                            <select class="form-select" id="vehicle_type" name="vehicle_type">
                                                <option>Select vehicle type</option>
                                                <?php
                                                    foreach ($get_vehicles as $vehicle) {
                                                    ?>
                                                    <option value="<?= $vehicle['unique_id']?>"><?= $vehicle['vehicle_type']?></option>
                                                <?php }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-select" id="vehicle_make" name="vehicle_make">
                                                <option>Select vehicle make</option>
                                                <?php
                                                    foreach ($get_vehicle_brands as $brand) {
                                                    ?>
                                                    <option value="<?= $brand['unique_id']?>"><?= $brand['brand_name']?></option>
                                                <?php }
                                                ?>
                                                <option value="others">Others</option>
                                            </select>
                                            <div id="other_vehicle_make" class="mt-3 d-none">
                                                <input type="text" name="other_vehicle_make" class="form-control" placeholder="Please Specify">
                                            </div>
                                        </div>
                                        <center>
                                            <div id="spinner_class" class="d-none">
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </div>
                                        </center>
                                        <div class="form-group">
                                            <select class="form-select" id="vehicle_model" name="vehicle_model">
                                                <option>Select vehicle model</option>
                                            </select>
                                            <div id="other_vehicle_model" class="mt-3 d-none">
                                                <input type="text" name="other_vehicle_model" class="form-control" placeholder="Please Specify">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-select" id="year_of_make" name="year_of_make">
                                                <option>Select  year</option>
                                                <?php
                                                    for ($year=1990; $year <= 2099; $year++) { 
                                                    ?>
                                                    <option value="<?= $year?>"><?= $year;?></option>
                                                    <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Enter Engine number" name="engine_number" id="engine_number">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="chasis_number" class="form-control" placeholder="Enter Chasis number" name="chasis_number">
                                        </div>
                                        <div class="form-group">
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
                                            <input type="text" id="occupation" class="form-control" placeholder="Occupation" name="occupation">
                                        </div>
                                        <div class="form-group">
                                            <span>Date of birth</span>
                                            <input type="date" id="date_of_birth" class="form-control" placeholder="Date of birth" name="date_of_birth">
                                        </div>
                                        <div class="form-group">
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
                                            <input type="text" id="name" class="form-control" placeholder="Name to register with vehicle" name="name_on_vehicle">
                                        </div>
                                        <div class="form-group">
                                            <input type="number" id="phone" class="form-control" placeholder="Phone number" name="phone">
                                        </div>
                                        <div class="form-group">
                                            <select name="insurance_type" id="insurance_type" class="form-select">
                                                <option>Insurance type</option>
                                                <option value="third_party_insurance">3rd Party Insurance</option>
                                                <option value="comprehensive">Comprehensive Insurance</option>
                                                <option value="no_third_party_insurance">(No Insurance)</option>
                                            </select>
                                        </div>
                                        <div id="bar">
                                            <div class="form-group">
                                               <select class="form-select" name="insurer" id="insurer">
                                                    <option>Select Insurer</option>
                                                    <option> Mutual Benefits</option>
                                                    <option> Old Mutual</option>
                                                </select>
                                            </div>
                                             <div class="form-group">
                                               <select class="form-select" name="plan_type" id="plan_type">
                                                    <option>Select Plan</option>
                                                    <option> Bronze</option>
                                                    <option> Silver</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <select name="plate_number_type" id="plate_number_type" class="form-select">
                                                <option>Type of number plate</option>
                                                <option value="private"> Private number plate</option>
                                                <option value="commercial"> Commercial number plate</option>
                                                <option value="personalized_number">Custom number plate</option>
                                            </select>
                                        </div>
                                <div id="cus">
                                    <div class="form-group">
                                        <span>Preferrred Number Plate</span>
                                        <input type="text" name="number_plate" id="number_plate" class="form-control" placeholder="e.g (KET-123A)">
                                    </div>
                                </div>

                                <div class="form-group">
                                            <select name="state" class="form-select" id="state">
                                                <option>Preferred State of Registration</option>
                                                <option value="lagos">Lagos</option><!-- 
                                                <option value="state">Adamawa</option>
                                                <option value="state">Oyo</option> -->
                                            </select>
                                        </div>
                                <div class="state box">
                                    <div class="form-group">
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
                                    <span>Do you want to obtain a Tinted permit?</span>
                                            <select class="form-select" id="tinted_permit" name="tinted_permit">
                                                <option>Select</option>
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>

                                    </div>

                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="button" id="submit_vehicle_registration" class="btn btn-primary mr-1 mb-1">Proceed</button>
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

<!-- <script>
function show(el, txt){
    var elem1 = document.getElementById('bar');
    var elem2 = document.getElementById('cus');
   
    elem1.style.display = (txt == 'Comprehensive Insurance') ? 'block' : 'none';
    elem2.style.display = (txt == 'Custom number plate') ? 'block' : 'none';
   
    }
</script> -->
<script>
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
            if(selected_option == 'comprehensive'){
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