
<?php include("sidebar.php");?>
<div id="main">

<?php include("header.php");?>
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

    <div class="col-md-8 col-sm-12 mx-auto">
      <div class="card">
         <div class="card-body">

                    <div class="tab-content">
                    <div class="tab-pane active" role="tabpanel" id="step1">
                        <form class="form" action="buy_package.php">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <fieldset class="form-group">
                                            <span for="Usagecolumn">Usage</span>
                                        <select class="form-select" id="basicSelect">
                                            <option value="">Select Usage</option>
                                            <option value="Private">Private</option>
                                            <option value="Business">Business</option>
                                            <option value="pandb">Private and Business</option>
                                        </select>
                                    </fieldset>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <fieldset class="form-group">
                                            <span for="Maker">Make of Vehicle</span>
                                        <select id="basicS" name="thename" class="form-select" onChange="show('others', this.options[this.selectedIndex].firstChild.nodeValue)">
                                            <option value="">Select make</option>
                                            <option value="Honda">Honda</option>
                                            <option value="Toyota">Toyota</option>
                                            <option value="Audi">Audi</option>
                                            <option value="Others">Others</option>
                                        </select>
                                    </fieldset>
                                    </div>

                                    <div id="others">
                                        <div class="form-group">
                                            <span for="Makecolumn">Other Maker of Vehicle</span>
                                            <input type="text" id="Vehiclename" class="form-control" placeholder="Other Make of Vehicle" name="vname-column">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="VehicleType">Vehicle Type</span>
                                            <select id=""  class="form-select">
                                                <option value="Honda">Select Type</option>
                                            <option value="Honda">Bus</option>
                                            <option value="Toyota">Car</option>
                                            <option value="Audi">Motorcycle</option>
                                            <option value="Others">Truck</option>
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
                                            <input type="text" id="Registration" class="form-control" name="Vehicle" placeholder="Vehicle Registration Number">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="Modelcolumn">Vehicle Model</span>
                                            <select class="form-select">
                                            <option value="Honda">Select Model</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="Year-column">Year of Make</span>
                                            <input type="date" id="Yearcolumn" class="form-control" placeholder="Year of Make" name="Yearcolumn">
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
                                            <span for="ChassisNumber">Chassis Number</span>
                                            <input type="number" id="Chassis" class="form-control" name="ChassisNumber" placeholder="Chassis Number">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="EngineNumber">Engine Number</span>
                                            <input type="number" id="EngineNumber" class="form-control" name="EngineNumber" placeholder="Engine Number">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="InsuredName"> Insured Name</span>
                                            <input type="text" id="InsuredName" class="form-control" name="InsuredName" placeholder="Insured Name">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="SumInsured">Sum Insured (Value of Vehicle to be Insured)</span>
                                            <input type="text" id="SumInsured" class="form-control" name="SumInsured" placeholder="Sum Insured">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="SumInsured">Insured Type (Are you the Primary User)</span>
                                            <select name="thename" class="form-select" onChange="show('bar', this.options[this.selectedIndex].firstChild.nodeValue)">
                                                <option>Select Insured Type</option>
                                                <option>Yes</option>
                                                <option>No</option>
                                            </select>
                                        </div>

                                        <div id="bar">
                                        <div class="form-group">
                                            <input type="text" id="" class="form-control" name="" placeholder="Name of primary user ">
                                            <input type="text" id="" class="form-control" name="" placeholder="Relationship (e.g Sister, Mother)">
                                        </div>

                                       </div>
                                    </div>
                                   
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="PolicyStartDate">Policy Start Date (Date of commencement of policy)</span>
                                            <input type="date" id="PolicyStartDate" class="form-control" name="PolicyStartDate" placeholder="Policy Start Date">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="company-column">Vehicle Images (4 sizes of Vehicle including Plate number)</span>
                                            <div class="input-group mb-3">
                                        <div class="form-file">
                                            <input type="file" class="form-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                            <label class="form-file-label" for="inputGroupFile01">
                                                <span class="form-file-text">Choose file...</span>
                                                <span class="form-file-button">Browse</span>
                                            </label>
                                        </div>
                                    </div>
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
                                    
                                    <div class="col-12 d-flex justify-content-end">
                                      <a href=""><button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button></a>
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
<?php include("footer.php");?>