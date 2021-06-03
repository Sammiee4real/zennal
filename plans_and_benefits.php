
<?php 
include("includes/sidebar.php");
include("includes/header.php");
$insurer_id = base64_decode($_GET['insurer_id']) ?? null;
$get_plans = get_rows_from_table_with_one_params('insurance_plans', 'insurer_id', $insurer_id);
$get_benefits = get_insurance_benefits($insurer_id);
$get_insurer = get_rows_from_table_with_one_params('insurers', 'unique_id', $insurer_id);

?>      
<div id="main">    
<div class="main-content container-fluid">
    <div class="page-title">
        <h3><?php echo $get_insurer[0]['name'];?></h3>
        <p class="text-subtitle text-muted">Plans and Benefits</p>
    </div>

    <div class="row">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-right">
          <li class="breadcrumb-item"><a href="compare_insurance.php">Compare Insurance</a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo $get_insurer[0]['name'];?></a></li>
        </ol>
      </nav>
    </div>

    <section class="section mt-1">
      <div class="row">
      <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false">PRODUCTS & FEATURES</a>
                            </li>
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <!-- <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                  <div class="col-md-2">
                    <img src="assets/images/old.png" width="52px">
                  </div>
                    <div class="col-md-4">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            
                                    <select class="form-select" id="basicSelect">
                                      <option>Old Mutual</option>
                                        </select>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
      </div> -->
      <!--  -->
    </div>
    </section>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                      <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th>
                    <div class="col-md-4">
                       <img src="assets/images/<?php echo $get_insurer[0]['image'];?>" width="52px">
                    </div>
                </th>
                <?php
                  foreach($get_plans as $plan){
                    echo "<th>".$plan["plan_name"]." (".$plan["plan_percentage"]."%)</th>";
                    // <th>Silver (2.85%)</th>
                    // <th>Gold (3.25%)</th>
                    // <th>Diamond (3.75%)</th>
                    // <th>Platinum (4.00%)</th>
                  }
                  // print_r($get_plans);
                ?>
              </tr>
            </thead>
            <tbody>
            <pre>
            <?php 
            // print_r($get_benefits); 
            foreach($get_benefits as $benefit){
            ?>
            <tr>
                <td><?php echo $benefit['benefit'] ?></td>
                <?php 
                foreach($benefit['details'] as $benefit_plan){
                ?>
                  <td><i data-feather="<?php echo $benefit_plan['status'] == 1 ? 'check':'x'; ?>" width="32" height="32" style="<?php echo $benefit_plan['status'] == 1 ? 'color: green':'color: red'; ?>;"></i><?php echo $benefit_plan['description']?></td>
                <?php
                }
                ?>
              </tr>
            <?php
            }
            ?>
              <!-- <tr>
                <td>TOWING VEHICLE BENEFITS</td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i>₦25,000(INTRA), ₦30,000(INTER)</td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i>₦25,000(INTRA), ₦30,000(INTER)</td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i>₦25,000(INTRA), ₦50,000(INTER)</td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i>₦30,000(INTRA), ₦70,000(INTER)</td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i>₦30,000(INTRA), ₦70,000(INTER)</td>
              </tr>
              <tr>
                <td>ACCIDENTAL DAMAGE</td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i></td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i></td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i></td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i></td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i></td>
              </tr>
              <tr>
                <td>FIRE (OWN DAMAGE)</td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i></td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i></td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i></td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i></td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i></td>
              </tr>
              <tr>
                <td>PERMANENT DISABILITY BENEFIT</td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i></td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i></td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i></td>
                <td>
                    <i data-feather="check" width="32" height="32" style=" color: green;"></i>
                    <i>Up to ₦250,000</i>
                </td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i>
                    <i>Up to ₦250,000</i>
                </td>
              </tr>
              <tr>
                <td>STRIKE, RIOT/CIVIL COMMOTION</td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i></td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i></td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i></td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i></td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i></td>
              </tr>
               <tr>
                <td>VEHICLE TRACKER</td>
                <td><i data-feather="x" width="32" height="32" style=" color: red;"></i></td>
                <td><i data-feather="x" width="32" height="32" style=" color: red;"></i></td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i><i>₦5m above</i></td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i><i>₦5m above</i></td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i><i>₦5m above</i></td>
              </tr>
              <tr>
                <td>THIRD PARTY INJURY/DEATH LIABILITY</td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i></td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i></td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i></td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i></td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i></td>
              </tr>
              <tr>
                <td>THIRD PARTY PROPERTY DAMAGE LIABILITY</td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i><i>₦1,000,000.00</i></td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i><i>₦1,000,000.00</i></td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i><i>₦1,000,000.00</i></td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i><i>₦1,000,000.00</i></td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i><i>₦1,000,000.00</i></td>
              </tr>
              <tr>
                <td>EXCESS BUYBACK</td>
                <td><i data-feather="x" width="32" height="32" style=" color: red;"></i></td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i></td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i></td>
                <td>
                    <i data-feather="check" width="32" height="32" style=" color: green;"></i>
                    
                </td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i>
                    
                </td>
              </tr>
              <tr>
                <td>INSURED MEDICAL LIABILITY</td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i></td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i></td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i></td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i></td>
                <td><i data-feather="check" width="32" height="32" style=" color: green;"></i></td>
              </tr> -->
              <tfooter>
              <tr>
                <th></th>
                <?php
                  foreach($get_plans as $plan){
                    $plan_name = $plan["plan_name"];
                    echo "<th>
                      <button data-plan_id=".$plan["unique_id"]."' data-plan_name='$plan_name' class='btn btn-primary compare-insurance-plans' type='button' data-toggle='modal' data-target='#exampleModal'>
                        Compare
                      </button>
                    </th>";
                  }
                ?>
                <!-- <th><a href="#" class="btn btn-primary">Select Package</a></th>
                <th><a href="#" class="btn btn-primary">Select Package</a></th>
                <th><a href="#" class="btn btn-primary">Select Package</a></th>
                <th><a href="#" class="btn btn-primary">Select Package</a></th>
                <th><a href="#" class="btn btn-primary">Select Package</a></th> -->
              </tr>
            </tfooter>
            </tbody>
          </table>
        </div>
                            </div>


                            
                        </div>

                    </div>

                </div>
            </div>

            <!--  -->

            <!--  -->
        </div>

      

      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Compare Plans Benefits</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body"  id="comparePlansModalBody">

              <div class="text-center" id="comparePlansSpinner">
                <div class="spinner-border" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>





    </section>


</div>
<?php include("includes/footer.php");?>

<script>
  $(".compare-insurance-plans").click(function(e){
    var btn = $(this)
    var plan_id = $(this).data("plan_id");
    var plan_name = $(this).data("plan_name");

    $("#comparePlansSpinner").show()

    console.log({plan_id, plan_name});
    
    $.ajax({
      url: "ajax/compare_insurance_plans.php",
      method: "POST",
      data: {plan_id, plan_name},
      success: function(data){
        console.log("Got here");
        console.log(data);
        $("#comparePlansSpinner").hide();
        $("#comparePlansModalBody").html(data)
      },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });
  })
</script>
            