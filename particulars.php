
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
        <h3>Renew Vehicle Particulars</h3>
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
                                                <option>Select Vehicle  model</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-select">
                                                <option>Select  year of make</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="Vehicle" class="form-control" placeholder="Enter Engine number" name="Vehicle-column">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="chasis" class="form-control" placeholder="Enter Chasis number" name="Vehicle">
                                        </div>
                                        
                                         <div class="form-group">
                                            <input type="text" id="chasis" class="form-control" placeholder="Name on Vehicle Lisence" name="Vehicle">
                                        </div>

                                        <!-- <div class="form-group">
                                    <input type="number" id="Phone" class="form-control" placeholder="Phone number" name="">
                                </div> -->

                                <div class="form-group">
                                            <select class="form-select">
                                                <option>Select color</option>
                                            </select>
                                        </div>


                           <ul class="list-unstyled mb-0">
                            <h6>Check all that applies</h6>
                                <li class="d-inline-block mr-2 mb-1">
                                    <div class="form-check">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="form-check-input form-check-primary"  name="customCheck" id="customColorCheck1">
                                            <label class="form-check-label" for="customColorCheck1">Road Worthiness</label>
                                        </div>
                                    </div>
                                </li>

                                <li class="d-inline-block mr-2 mb-1">
                                    <div class="form-check">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="form-check-input form-check-success"  name="customCheck" id="customColorCheck3">
                                            <label class="form-check-label" for="customColorCheck3">Hackney Permit</label>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-inline-block mr-2 mb-1">
                                    <div class="form-check">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="form-check-input form-check-danger"  name="customCheck" id="customColorCheck4">
                                            <label class="form-check-label" for="customColorCheck4">Vehicle License</label>
                                        </div>
                                    </div>
                                </li>
                            </ul>

                               
                                        <div class="form-group">
                                            <select name="thename" class="form-select" onChange="show('bar', this.options[this.selectedIndex].firstChild.nodeValue)">
                                                <option>Insurance type</option>
                                                <option>3rd Party Insurance</option>
                                                <option>Comprehensive Insurance</option>
                                                <option>(No Insurance)</option>
                                            </select>
                                        </div>
                            <div id="bar">
                                 <div class="form-group">
                                   <select class="form-select">
                                                <option>Select Plan</option>
                                                <option> Bronze</option>
                                                <option> Silver</option>
                                            </select>
                                </div>
                            </div>
                                        <div class="form-group">
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
            

