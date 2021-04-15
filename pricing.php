
<?php 
  include("includes/sidebar.php");
  $get_vehicles = get_rows_from_one_table('vehicles', 'date_created');
  $get_vehicle_brands = get_rows_from_one_table('vehicle_brands', 'datetime');
  $get_vehicle_models = get_rows_from_one_table('vehicle_models', 'datetime');
  $get_insurer = get_rows_from_one_table('insurers', 'datetime');
  $get_other_papers = get_rows_from_one_table('services', 'date_created');
?>
<div id="main">

<?php include("includes/header.php");?>
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
          <form id="renew_vehicle_form" method="POST">
            <fieldset class="form-group">
              <select class="form-select" id="vehicle_type" name="vehicle_type" onchange="get_quote1()">
                <option>Select vehicle type</option>
                <?php
                    foreach ($get_vehicles as $vehicle) {
                    ?>
                    <option value="<?= $vehicle['unique_id']?>"><?= $vehicle['vehicle_type']?></option>
                <?php }
                ?>
              </select>
            </fieldset>

            <div class="form-group">
              <select name="insurance_type" id="insurance_type" class="form-select" onChange="show('bar', this.options[this.selectedIndex].firstChild.nodeValue)">
                <option>Insurance type</option>
                <option value="third_party">3rd Party Insurance</option>
                <option value="comprehensive">Comprehensive Insurance</option>
                <option value="no_insurance">(No Insurance)</option>
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
                          <input type="checkbox" class="form-check-input form-check-primary"  name="road_worthiness" id="paper1" onclick="get_quote1()">
                          <label class="form-check-label" for="customColorCheck1">Road Worthiness</label>
                      </div>
                  </div>
              </li>
              <li class="d-inline-block mr-2 mb-1">
                  <div class="form-check">
                      <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="form-check-input form-check-success"  name="hackney_permit" id="paper2" onclick="get_quote1()">
                          <label class="form-check-label" for="customColorCheck3">Hackney Permit</label>
                      </div>
                  </div>
              </li>
              <li class="d-inline-block mr-2 mb-1">
                  <div class="form-check">
                      <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="form-check-input form-check-danger"  name="license" id="paper3" onclick="get_quote1()">
                          <label class="form-check-label" for="customColorCheck4">Vehicle License</label>
                      </div>
                  </div>
              </li>
          </ul>
          </form>

          <center>
            <div id="spinner_class" class="d-none">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
          </center>
        
   </div>
      <div class="row">
       <h4>Total Amount - &#8358; <span id="total">0.00</span></h4>

       <div class="col-md-12 mt-2">
       <a href="particulars"> <button class="btn btn-primary btn-block ">Click to buy</button></a>
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
         <form method="post" id="register_vehicle_form">
            <fieldset class="form-group">
              <select class="form-select" id="vehicle_type1" name="vehicle_type" onchange="get_quote2()">
                <option>Select vehicle type</option>
                <?php
                    foreach ($get_vehicles as $vehicle) {
                    ?>
                    <option value="<?= $vehicle['unique_id']?>"><?= $vehicle['vehicle_type']?></option>
                <?php }
                ?>
              </select>
            </fieldset>

            <!-- <fieldset class="form-group">
              <select class="form-select" id="basicSelect">
                  <option>Registration Type</option>
                  <option></option>
                  <option></option>
              </select>
            </fieldset> -->
               <div class="form-group">
                  <select name="insurance_type" id="insurance_type1" class="form-select" onChange="show('veh', this.options[this.selectedIndex].firstChild.nodeValue)">
                      <option>Insurance type</option>
                      <option value="third_party">3rd Party Insurance</option>
                      <option value="comprehensive">Comprehensive Insurance</option>
                      <option value="no_insurance">(No Insurance)</option>
                  </select>
                </div>
                <div id="veh">
                  <div class="form-group">
                   <select class="form-select" name="insurer" id="insurer">
                        <option>Select Insurer</option>
                        <?php
                            foreach ($get_insurer as $insurer) {
                        ?>
                            <option value="<?= $insurer['unique_id']?>"><?= $insurer['name']?></option>
                        <?php } ?>
                    </select>
                  </div>
                   <div class="form-group">
                     <select class="form-select" name="plan_type" id="plan_type" onchange="get_quote2()">
                        <option>Select Plan</option>
                      </select>
                  </div>
                  <div class="form-group">
                    <input type="number" name="vehicle_value" id="vehicle_value" class="form-control" placeholder="Value of Vehicle (in naira)">
                  </div>
                </div>

            <fieldset class="form-group">
              <select name="plate_number_type" id="plate_number_type" class="form-select" onchange="get_quote2()">
                <option>Type of number plate</option>
                <option value="private"> Private number plate</option>
                <option value="commercial"> Commercial number plate</option>
                <option value="personalized_number">Custom number plate</option>
              </select>
            </fieldset>
         </form>
        </div>
        <center>
          <div id="spinner_class1" class="d-none">
              <div class="spinner-border text-primary" role="status">
                  <span class="sr-only">Loading...</span>
              </div>
          </div>
        </center>

        <div class="row">
            <h4>Total Amount - &#8358;<span id="total1">0.00</span></h4>
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
          <form id="change_ownership_quote_form">
            <fieldset class="form-group">
              <select class="form-select" id="vehicle_type2" name="vehicle_type" onchange="get_quote3()">
                <option>Select vehicle type</option>
                <?php
                    foreach ($get_vehicles as $vehicle) {
                    ?>
                    <option value="<?= $vehicle['unique_id']?>"><?= $vehicle['vehicle_type']?></option>
                <?php }
                ?>
              </select>
            </fieldset>

            <fieldset class="form-group">
              <select class="form-select" onchange="get_quote3()">
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
            </fieldset>

            <fieldset class="form-group">
              <select class="form-select" id="registration_type" name="registration_type" onchange="get_quote3()">
                <option>Select Registration type</option>
                <option value="private_with_third">Private Vehicle (with 3rd Party Insurance)</option>
                <option value="private_without_third">Private Vehicle (No Insurance)</option>
                <option value="commercial_with_third">Commercial Vehicle (with 3rd Party Insurance)</option>
                <option value="commercial_without_third">Commercial Vehicle (No Insurance)</option>
              </select>
            </fieldset>

            <fieldset class="form-group">
              <select class="form-select" id="plate_number_type2" name="plate_number_type" onchange="get_quote3()">
                <option>Type of number plate</option>
                <option value="new"> New number plate</option>
                <option value="old"> Old number plate</option>
                <option value="custom">Custom number plate</option>
              </select>
            </fieldset>
          </form>
        </div>

        <center>
          <div id="spinner_class2" class="d-none">
              <div class="spinner-border text-primary" role="status">
                  <span class="sr-only">Loading...</span>
              </div>
          </div>
        </center>
        <div class="row">
            <h4>Total Amount - &#8358;<span id="total2">0.00</span></h4>
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
          <div class="alert alert-light-info color-black">Select the type of Vehicle Permit below</div>
          <form method="post" id="vehicle_permit_form">
            <fieldset class="form-group">
              <select class="form-select" id="vehicle_permit" name="vehicle_permit" onchange="get_quote4()">
                <option>Select type of Permit</option>
                <?php
                    foreach ($get_other_papers as $permit) {
                    ?>
                    <option value="<?= $permit['unique_id']?>"><?= $permit['service']?></option>
                <?php }
                ?>
              </select>
            </fieldset>
          </form>
        </div>
        <center>
          <div id="spinner_class3" class="d-none">
              <div class="spinner-border text-primary" role="status">
                  <span class="sr-only">Loading...</span>
              </div>
          </div>
        </center>
        <div class="row">
             <h4>Total Amount - &#8358;<span id="total3">0.00</span></h4>
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
<?php include("includes/footer.php");?>
<script>
  function formatNumber(num) {
      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
  }
  function get_quote1(){
    $.ajax({
      url: "ajax/get_quote",
      method: "POST",
      data: $("#renew_vehicle_form").serialize(),
      beforeSend: function(){
        $("#spinner_class").removeClass("d-none");
      },
      success: function(data){
        $("#spinner_class").addClass("d-none");
        //var new_total = parseInt(total + data);
        $("#total").html(formatNumber(data));
      }
    })
  }

  function get_quote2(){
    $.ajax({
      url: "ajax/get_quote2",
      method: "POST",
      data: $("#register_vehicle_form").serialize(),
      beforeSend: function(){
        $("#spinner_class1").removeClass("d-none");
      },
      success: function(data){
        $("#spinner_class1").addClass("d-none");
        //var new_total = parseInt(total + data);
        $("#total1").html(formatNumber(data));
      }
    })
  }

  function get_quote3(){
    $.ajax({
      url: "ajax/get_quote3",
      method: "POST",
      data: $("#change_ownership_quote_form").serialize(),
      beforeSend: function(){
        $("#spinner_class2").removeClass("d-none");
      },
      success: function(data){
        $("#spinner_class2").addClass("d-none");
        //var new_total = parseInt(total + data);
        $("#total2").html(formatNumber(data));
      }
    })
  }

  function get_quote4(){
    $.ajax({
      url: "ajax/get_quote4",
      method: "POST",
      data: $("#vehicle_permit_form").serialize(),
      beforeSend: function(){
        $("#spinner_class3").removeClass("d-none");
      },
      success: function(data){
        $("#spinner_class3").addClass("d-none");
        $("#total3").html(formatNumber(data));
      }
    })
  }

  $(document).ready(function(){
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
          success: function(data){
            $("#plan_type").html(data);
          }
        })
      }
    });

    $("#vehicle_value").keyup($.debounce(1000, get_quote2))

    $("#insurance_type").change(function(){
      //var vehicle_type = $(this).children("option:selected").val();
      var insurance_type = $(this).children("option:selected").val();
      var total = $("#total").html();
      if(insurance_type == 'third_party' || insurance_type == 'no_insurance'){
        $.ajax({
          url: "ajax/get_quote",
          method: "POST",
          data: $("#renew_vehicle_form").serialize(),
          beforeSend: function(){
            $("#spinner_class").removeClass("d-none");
          },
          success: function(data){
            $("#spinner_class").addClass("d-none");
            //var new_total = parseInt(total + data);
            $("#total").html(formatNumber(data));
          }
        })
      }
    })

    $("#insurance_type1").change(function(){
      //var vehicle_type = $(this).children("option:selected").val();
      var insurance_type = $(this).children("option:selected").val();
      var total = $("#total").html();
      if(insurance_type == 'third_party' || insurance_type == 'no_insurance'){
        $.ajax({
          url: "ajax/get_quote2",
          method: "POST",
          data: $("#register_vehicle_form").serialize(),
          beforeSend: function(){
            $("#spinner_class1").removeClass("d-none");
          },
          success: function(data){
            $("#spinner_class1").addClass("d-none");
            //var new_total = parseInt(total + data);
            $("#total1").html(formatNumber(data));
          }
        })
      }
      else if(insurance_type == 'comprehensive'){
        $("#veh").show();
      }
    })


    
  })
</script>
            