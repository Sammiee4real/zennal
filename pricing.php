
<?php include("sidebar.php");?>
<div id="main">

<?php include("header.php");?>
<style type="text/css">
#bar {display:none;}
#veh {display:none;}

</style>  

<script>
// function show(el, txt){
//     var elem1 = document.getElementById('bar');
//     elem1.style.display = (txt == 'Comprehensive Insurance') ? 'block' : 'none';
//     }

    function show(el, txt){
    var elem1 = document.getElementById('bar');
    var elem2 = document.getElementById('veh');

    elem1.style.display = (txt == 'Comprehensive Insurance') ? 'block' : 'none';
    elem2.style.display = (txt == 'Comprehensive Insurance') ? 'block' : 'none';
    }
</script>                
<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Vehicle Registration</h3>
        <p class="text-subtitle text-muted">Pricing</p>
    </div>

    <section class="section mt-5">
       <div class="col-lg-12 col-xl-6 mx-auto">
    
      <div class="card collapse-icon accordion-icon-rotate">
        <div id="headingCollapse11" class="card-header">
          <a data-toggle="collapse" href="#collapse11" aria-expanded="false" aria-controls="collapse11" class="card-title lead collapsed">Renew Vehicle Particulars <i data-feather="plus" width="20" ></i> </a> <span > </span>
        </div>
        <div id="collapse11" role="tabpanel" aria-labelledby="headingCollapse11" class="collapse" style="">
          <div class="card-body">
            <div class="card-block">
               <div class="col-md-12">
          <div class="alert alert-light-info color-black">Select the type of Vehicle, then check the options you require to see the price. </div>
          <fieldset class="form-group">
            <select class="form-select" id="basicSelect">
                <option>Select vehicle type</option>
                <option></option>
                <option></option>
            </select>
          </fieldset>

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
          <ul class="list-unstyled mb-0">
                                <li class="d-inline-block mr-2 mb-1">
                                    <div class="form-check">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="form-check-input form-check-primary"  name="customCheck" id="customColorCheck1">
                                            <label class="form-check-label" for="customColorCheck1">Road Worthiness</label>
                                        </div>
                                    </div>
                                </li>
                                <!-- <li class="d-inline-block mr-2 mb-1">
                                    <div class="form-check">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="form-check-input form-check-secondary"  name="customCheck" id="customColorCheck2">
                                            <label class="form-check-label" for="customColorCheck2">Third-Party Insurance</label>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-inline-block mr-2 mb-1">
                                    <div class="form-check">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="form-check-input form-check-secondary"  name="customCheck" id="customColorCheck2">
                                            <label class="form-check-label" for="customColorCheck2">Comprehensive Insurance</label>
                                        </div>
                                    </div>
                                </li> -->
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
                            
                       </div>
                  <div class="row">
                       <h4>Total Amount - ₦0.00</h4>
                       <div class="col-md-12 mt-2">
                       <a href="particulars.php"> <button class="btn btn-primary btn-block ">Click to buy</button></a>
                       </div>
                  </div>
            </div>
          </div>
        </div>
      </div>

     <div class="card collapse-icon accordion-icon-rotate">
      <div id="headingCollapse12" class="card-header">
          <a data-toggle="collapse" href="#collapse12" aria-expanded="false" aria-controls="collapse12" class="card-title lead collapsed">Register a New Vehicle <i data-feather="plus" width="20" ></i> </a>
        </div>
        <div id="collapse12" role="tabpanel" aria-labelledby="headingCollapse12" class="collapse" aria-expanded="false" style="">
          <div class="card-body">
            <div class="card-block">
                      <div class="col-md-12">
          <div class="alert alert-light-info color-black">Select the type of Vehicle, then select all the options you require to see the accurate price. </div>
          <fieldset class="form-group">
            <select class="form-select" id="basicSelect">
                <option>Select vehicle type</option>
                <option></option>
                <option></option>
            </select>
          </fieldset>

          <fieldset class="form-group">
            <select class="form-select" id="basicSelect">
                <option>Registration Type</option>
                <option></option>
                <option></option>
            </select>
          </fieldset>

          
             <div class="form-group">
                                            <select name="thename" class="form-select" onChange="show('veh', this.options[this.selectedIndex].firstChild.nodeValue)">
                                                <option>Insurance type</option>
                                                <option>3rd Party Insurance</option>
                                                <option>Comprehensive Insurance</option>
                                                <option>(No Insurance)</option>
                                            </select>
                                          </div>
                            <div id="veh">
                                 <div class="form-group">
                                   <select class="form-select">
                                                <option>Select Plan</option>
                                                <option> Bronze</option>
                                                <option> Silver</option>
                                            </select>
                                </div>
                            </div>

          <fieldset class="form-group">
            <select class="form-select" id="basicSelect">
                <option>Type of Number Plate</option>
                <option></option>
                <option></option>
            </select>
          </fieldset>
        </div>


        <div class="row">
            <h4>Total Amount - ₦0.00</h4>
          <div class="col-md-12 mt-2">
           <a href="vehicle_reg.php"> <button class="btn btn-primary btn-block ">Click to buy</button></a>
           </div>
        </div>
            </div>
          </div>
        </div>
    </div>

    <div class="card collapse-icon accordion-icon-rotate">
      <div id="headingCollapse13" class="card-header">
          <a data-toggle="collapse" href="#collapse13" aria-expanded="false" aria-controls="collapse13" class="card-title lead collapsed">Change of Ownership <i data-feather="plus" width="20" ></i> </a>
        </div>
        <div id="collapse13" role="tabpanel" aria-labelledby="headingCollapse12" class="collapse" aria-expanded="false" style="">
          <div class="card-body">
            <div class="card-block">
                     <div class="col-md-12">
          <div class="alert alert-light-info color-black">Select the type of Vehicle, then select all the options you require, to see the acccurate price.</div>
          <fieldset class="form-group">
            <select class="form-select" id="basicSelect">
                <option>Select vehicle type</option>
                <option></option>
                <option></option>
            </select>
          </fieldset>

          <fieldset class="form-group">
            <select class="form-select" id="basicSelect">
                <option>Vehicle License Expiry</option>
                <option></option>
                <option></option>
            </select>
          </fieldset>

          <fieldset class="form-group">
            <select class="form-select" id="basicSelect">
                <option>Registration Type</option>
                <option></option>
                <option></option>
            </select>
          </fieldset>

          <fieldset class="form-group">
            <select class="form-select" id="basicSelect">
                <option>Number Plate Choice</option>
                <option></option>
                <option></option>
            </select>
          </fieldset>
        </div>
        <div class="row">
            <h4>Total Amount - ₦0.00</h4>
          <div class="col-md-12 mt-2">
            <a href="change_ownership.php"> <button class="btn btn-primary btn-block ">Click to buy</button></a>
          </div>
        </div>
            </div>
          </div>
        </div>
    </div>

    <div class="card collapse-icon accordion-icon-rotate">
      <div id="headingCollapse14" class="card-header">
          <a data-toggle="collapse" href="#collapse14" aria-expanded="false" aria-controls="collapse14" class="card-title lead collapsed">Other Vehicle Papers <i data-feather="plus" width="20" ></i> </a>
        </div>
        <div id="collapse14" role="tabpanel" aria-labelledby="headingCollapse12" class="collapse" aria-expanded="false" style="">
          <div class="card-body">
            <div class="card-block">
                     <div class="col-md-12">
          <div class="alert alert-light-info color-black">Some text to explain the point</div>
          <fieldset class="form-group">
            <select class="form-select" id="basicSelect">
                <option>Select Type of Permit</option>
                <option></option>
                <option></option>
            </select>
          </fieldset>
        </div>
        <div class="row">
            <h4>Total Amount - ₦0.00</h4>
          <div class="col-md-12 mt-2">
            <a href="vehicle_permit.php"> <button class="btn btn-primary btn-block ">Click to buy</button></a>
          </div>
        </div> 
            </div>
          </div>
        </div>
    </div>

  </div>
    </section>


</div>
<?php include("footer.php");?>
            