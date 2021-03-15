
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
<div class="main-content container-fluid">
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
                            <form class="form" action="complete_order.php">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                         <div class="mt-3 mb-3">
                                          <h4 class="card-title">Vehicle Permit</h4>
                                        </div>

                                        <div class="form-group">
                                        <select class=" form-select"> 
                                                <option>Select type of permit</option> 
                                                <option>Tinted Glass Permit</option>
                                                <option>S/W Local Government Permits (Motorcycle)</option>
                                                <option>State Carriage Permit (Motorcycle)</option>
                                                <option>Rider’s Card (Motorcycle)</option>
                                                <option>S/W Local Government Permits (Buses)</option>
                                                <option>Nigeria Government Permits (Cars/Buses)</option>
                                                <option>Nigeria Government Permits (Trucks)</option>
                                                <option>Permit to Operate Heavy Motor Vehicle</option>
                                                <option>Change of Vehicle Engine</option>
                                        </select>
                                    </div>


                                        <!-- <div class="form-group">
                                            <select class="form-select">
                                                <option>Select type of permit</option>
                                                <option>Tinted Glass Permit</option>
                                                <option>S/W Local Government Permits (Motorcycle)</option>
                                                <option>State Carriage Permit (Motorcycle)</option>
                                                <option>Rider’s Card (Motorcycle)</option>
                                                <option>S/W Local Government Permits (Buses)</option>
                                                <option>Nigeria Government Permits (Cars/Buses)</option>
                                                <option>Nigeria Government Permits (Trucks)</option>
                                                <option>Permit to Operate Heavy Motor Vehicle</option>
                                                <option>Change of Vehicle Engine</option>
                                            </select>
                                        </div> -->

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
                                                <option>Select Vehicle  model</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-select">
                                                <option>Select  year of make</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="Vehicle" class="form-control" placeholder="Enter Vehicle registration number/Plate number" name="column">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="Vehicle" class="form-control" placeholder="Enter Engine number" name="Vehicle-column">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="chasis" class="form-control" placeholder="Enter Chasis number" name="Vehicle">
                                        </div>
                                        
                                         <div class="form-group">
                                            <input type="text" id="chasis" class="form-control" placeholder="Name on Vehicle License" name="Vehicle">
                                        </div>

                                        <!-- <div class="form-group">
                                    <input type="number" id="Phone" class="form-control" placeholder="Phone number" name="">
                                </div> -->

                                <div class="form-group">
                                            <select class="form-select">
                                                <option>Select color</option>
                                            </select>
                                        </div>

                                <div class="mt-3 mb-3">
                                          <h4 class="card-title">Expiry Dates</h4>
                                </div>

                                         <div class="form-group">
                                            <span>Vehicle License Expiry</span>
                                            <input type="date" id="" class="form-control" placeholder="" name="Vehicle">
                                        </div>
                                        <div class="form-group">
                                            <span>Insurance Expiry</span>
                                            <input type="date" id="" class="form-control" placeholder="" name="Vehicle">
                                        </div>
                                        <div class="form-group">
                                            <span>Road Worthiness Expiry</span>
                                            <input type="date" id="" class="form-control" placeholder="" name="Vehicle">
                                        </div>
                                        <div class="form-group">
                                            <span>Hackney Permit Expiry (If applicable)</span>
                                            <input type="date" id="" class="form-control" placeholder="" name="Vehicle">
                                        </div>
                                        <div class="form-group">
                                            <span>Heavy Duty Permit Expiry (If applicable)</span>
                                            <input type="date" id="" class="form-control" placeholder="" name="Vehicle">
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
<?php include("footer.php");?>
            

