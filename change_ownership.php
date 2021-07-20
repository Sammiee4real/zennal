<?php include("includes/sidebar.php");
    $get_vehicles = get_rows_from_one_table('vehicles', 'date_created');
    $get_vehicle_brands = get_rows_from_table('vehicle_brands');
?>
<div id="main">

<?php include("includes/header.php");?>            
<div class="main-content container-fluid" id="appWrapper">
    <div class="page-title">
        <h3>Change of Ownership</h3>
        <p class="text-subtitle text-muted">Please fill all the fields below</p>
    </div>

    <section class="section mt-5" id="multiple-column-form ">
        <div class="row match-height">
            <div class="col-6 mx-auto">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="post" id="change_ownership_form">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="mt-3">
                                            <h4 class="card-title">Vehicle Details</h4>
                                        </div>

                                        <div class="form-group">
                                            <select class="form-select" id="vehicle_id" name="vehicle_id"
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


                                        <div class="form-group mb-5">
                                            <label for="vehicleLicenseExpiry">Vehicle License Expiry</label>
                                            <select class="form-select" name="license_expiry"
                                            v-model="vehicleLicenseExpiry">
                                                <option value="">Select vehicle license expiry</option>
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
                                        </div>
                                    
                                        <div class="mt-5 ">
                                            <h4 class="card-title">New Owner’s Information</h4>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control" placeholder="Name">
                                        </div>
                                        <div class="form-group">
                                            <input type="number" name="phone" class="form-control" placeholder="Phone number">
                                        </div>
                                        <div class="form-group">
                                            <span>Date of birth</span>
                                            <input type="date" id="birth" class="form-control" placeholder="Date of birth (dd/mm/yyyy)" name="dob">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="address" class="form-control" placeholder="Contact address" name="address">
                                        </div>
                                        <div class="form-group">
                                            <h5>Upload 6 Required Documents</h5>
                                            <span>1. Current Proof of Ownership  2. Vehicle License  3. Receipt of Purchase / 4. Transfer of Ownership Document / 5. Your Picture or Passport Photograph / 6. Valid ID Card </span>
                                            <input type="file" name="files[]" placeholder="Upload Document" class="form-control" id="files" multiple >
                                            <span id="uploaded_image"></span>
                                            <input type="hidden" name="vehicle_documents" id="image_url">
                                        </div>

                                        <div class="mt-5">
                                        <h4 class="card-title">Others</h4>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-select" name="registration_type"
                                            v-model="registrationType">
                                                <option value="">Select Registration type</option>
                                                <option value="private_with_third">Private Vehicle (with 3rd Party Insurance)</option>
                                                <option value="private_without_third">Private Vehicle (No Insurance)</option>
                                                <option value="commercial_with_third">Commercial Vehicle (with 3rd Party Insurance)</option>
                                                <option value="commercial_without_third">Commercial Vehicle (No Insurance)</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-5">
                                            <select class="form-select" name="plate_number_type"
                                            v-model="numberPlateType">
                                                <option value="">Type of number plate</option>
                                                <option value="new"> New number plate</option>
                                                <option value="old"> Old number plate</option>
                                                <option value="custom">Custom number plate</option>
                                            </select>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="button" id="change_ownership_btn" class="btn btn-primary mr-1 mb-1">Proceed </button>
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
    $(document).on('change', '#files', function(){
        let unique_id3 = $("#name").val();
        var form_data = new FormData();
        // Read selected files
        var totalfiles = document.getElementById('files').files.length;
        for (var index = 0; index < totalfiles; index++) {
        form_data.append("files[]", document.getElementById('files').files[index]);
        }
        $.ajax({
            url: 'upload_document_document.php', 
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
                $('#image_url').val(response);
            }
        });

    });
</script>
            

