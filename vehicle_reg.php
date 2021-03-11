
<?php include("sidebar.php");?>
<div id="main">

<?php include("header.php");?> 
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

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function(){
    $("select").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue){
                $(".state").not("." + optionValue).hide();
                $("." + optionValue).show();
            } else{
                $(".state").hide();
            }
        });
    }).change();
});
</script>

<div class="main-content container-fluid">
    <div class="page-title">
        <h3>New Vehicle Registration</h3>
        <p class="text-subtitle text-muted">Please fill all the fields below</p>
    </div>


<section class="section mt-5" id="multiple-column-form ">
        <div class="row match-height">
            <div class="col-6 mx-auto">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" action="payment.php">
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
                                        <div class="form-group">
                                            <select class="form-select">
                                                <option>Vehicle make</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-select">
                                                <option>Select  model</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-select">
                                                <option>Select  year</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="Vehicle" class="form-control" placeholder="Enter Engine number" name="Vehicle-column">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="chasis" class="form-control" placeholder="Enter Chasis number" name="Vehicle">
                                        </div>
                                        <div class="form-group">
                                            <select class="form-select">
                                                <option>Select color</option>
                                            </select>
                                        </div>

                                        <div class="mt-5">
                                          <h4 class="card-title">Personal Information & Documents</h4>
                                        </div>

                                        <div class="form-group">
                                            <input type="text" id="Vehicle" class="form-control" placeholder="Occupation" name="">
                                        </div>
                                        <div class="form-group">
                                            <span>Date of birth</span>
                                            <input type="date" id="Date of birth" class="form-control" placeholder="Date of birth" name="">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="Contact address" class="form-control" placeholder="Contact address" name="">
                                        </div>

                                        <div class="mt-5">
                                          <h4 class="card-title">Upload Vehicle Particulars</h4>
                                          <span>Upload pictures of pages of the Original Custom Papers of the vehicle or original local receipt of purchase. Please use your camera flash when taking the picture</span>
                                        </div>

                                        <div class="form-group">
                                            <input type="file" id="occupation" class="form-control" placeholder="Occupation" name="">
                                        </div>

                                        <div class="mt-5">
                                          <h4 class="card-title">Preferences</h4>
                                        </div>

                                        <div class="form-group">
                                            <input type="text" id="Vehicle" class="form-control" placeholder="Name to register with vehicle" name="">
                                        </div>
                                        <div class="form-group">
                                            <input type="number" id="Phone" class="form-control" placeholder="Phone number" name="">
                                        </div>
                                        <div class="form-group">
                                            <select name="" class="form-select" onChange="show('bar', this.options[this.selectedIndex].firstChild.nodeValue)">
                                                <option>Insurance type</option>
                                                <option>3rd Party Insurance</option>
                                                <option>Comprehensive Insurance</option>
                                                <option>(No Insurance)</option>
                                            </select>
                                        </div>
                            <div id="bar">
                                <div class="form-group">
                                   <select class="form-select">
                                                <option>Select Insurer</option>
                                                <option> Mutual Benefits</option>
                                                <option> Old Mutual</option>
                                            </select>
                                </div>
                                 <div class="form-group">
                                   <select class="form-select">
                                                <option>Select Plan</option>
                                                <option> Bronze</option>
                                                <option> Silver</option>
                                            </select>
                                </div>
                            </div>
                                        <div class="form-group">
                                            <select name="" class="form-select" onChange="show('cus', this.options[this.selectedIndex].firstChild.nodeValue)">
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
                                </div>

                                <div class="form-group">
                                            <select name="" class="form-select">
                                                <option>Preferrred State of Registration</option>
                                                <option value="state">Abia</option>
                                                <option value="state">Adamawa</option>
                                                <option value="state">Oyo</option>
                                            </select>
                                        </div>
                                <div class="state box">
                                    <div class="form-group">
                                        <select name="" class="form-select">
                                                <option>Preferrred local government</option>
                                                <option>Oluyole local government</option>
                                                <option>Ono Ara local government</option>
                                            </select>
                                    </div>
                                </div>

                                    </div>

                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary mr-1 mb-1">Proceed</button>
                                    </div>
                                    
                                    </form>
                                </div>
                            
                        </div>
                    </div>
                </div>
            </div>
    </section>

 

</div>
<?php include("footer.php");?>
            

