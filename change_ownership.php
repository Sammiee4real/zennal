
<?php include("includes/sidebar.php");?>
<div id="main">

<?php include("includes/header.php");?>            
<div class="main-content container-fluid">
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
                            <form class="form" action="complete_order.php">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                         <div class="mt-3">
                                          <h4 class="card-title">Vehicle Details</h4>
                                         </div>
                                        <div class="form-group">
                                            <select class="form-select">
                                                <option>Select vehicle type</option>
                                                <option>Motorcycle/Tricycle</option>
                                                <option>Saloon Car - Med (1.4-1.9L) e.g. Picanto, Corolla, Almera</option>
                                                <option>Saloon Car - Maxi (1.4-1.9L) e.g. Camry, Benz, Accord</option>
                                                <option>SUV/Jeep/Bus/Pick-up</option>
                                                <option>Coaster Bus</option>
                                                <option>Mini Trucks/ Trucks 15 Tons (Tippers)</option>
                                                <option>Trucks 20 Tons (6-10 Tyres)</option>
                                                <option>Trucks 30 Tons (10+ Tyres)</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-5">
                                            <select class="form-select">
                                                <option>Vehicle license expiry</option>
                                                <option>Less than 1 month</option>
                                                <option>More than 1 month</option>
                                                <option>More than 1 year</option>
                                                <option>More than 2 years</option>
                                                <option>More than 3 years</option>
                                                <option>More than 4 years</option>
                                                <option>More than 5 years</option>
                                                <option>More than 6 years</option>
                                                <option>More than 7 years</option>
                                            </select>
                                        </div>
                                       
                                        <div class="mt-5 ">
                                         <h4 class="card-title">New Owner’s Information</h4>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="" class="form-control" placeholder="Name">
                                        </div>
                                        <div class="form-group">
                                            <input type="number" name="" class="form-control" placeholder="Phone number">
                                        </div>
                                        <div class="form-group">
                                            <span>Date of birth</span>
                                            <input type="date" id="birth" class="form-control" placeholder="Date of birth (dd/mm/yyyy)" name="">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="address" class="form-control" placeholder="Contact address" name="">
                                        </div>
                                        <div class="form-group">
                                            <h5>Upload 6 Required Documents</h5>
                                            <span>1. Current Proof of Ownership  2. Vehicle License  3. Receipt of Purchase / 4. Transfer of Ownership Document / 5. Your Picture or Passport Photograph / 6. Valid ID Card </span>
                                            <input type="file" id="" class="form-control" placeholder="Upload document" name="">
                                        </div>

                                         <div class="mt-5">
                                          <h4 class="card-title">Others</h4>
                                         </div>
                                        <div class="form-group">
                                            <select class="form-select">
                                                <option>Select Registration type</option>
                                                <option>Private Vehicle (with 3rd Party Insurance)</option>
                                                <option>Private Vehicle (No Insurance)</option>
                                                <option>Commercial Vehicle (with 3rd Party Insurance)</option>
                                                <option>Commercial Vehicle (No Insurance)</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-5">
                                            <select class="form-select">
                                                <option>Type of number plate</option>
                                                <option> New number plate</option>
                                                <option> Old number plate</option>
                                                <option>Custom number plate</option>
                                            </select>
                                        </div>
                                        
                                    </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary mr-1 mb-1">Proceed </button>
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
            

