
<?php
include("includes/sidebar.php");
include("includes/header.php");
$get_insurers = get_rows_from_table('insurers');
?>            
<div id="main">
<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Vehicle Insurance</h3>
        <p class="text-subtitle text-muted">Get a quote</p>
    </div>

    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-right">
                <li class="breadcrumb-item"><a href="select_action.php">Back</a></li>
                <li class="breadcrumb-item"><a href="">Get a quote</a></li>
            </ol>
        </nav>
    </div>

<section class="section mt-5" id="multiple-column-form ">
        <div class="row match-height">
            <div class="col-6 mx-auto">
                <div class="card">
                    <div class="card-header">
                       <!--  <h4 class="card-title"></h4> -->
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" id="vehicle-quote-form" method="post">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <span for="first-name-column">Vehicle Value (Without a comma)*</span>
                                            <input type="text" id="vehicle_value" name="vehicle_value" class="form-control" placeholder="Enter Vehicle Value" name="Vehicle-column">
                                            <span id="help-text"></span>
                                        </div>
                                        <div class="form-group">
                                            <span for="last-name-column">Preferred Insurer * </span>
                                            <select class="form-select" name="prefered_insurer" id="prefered_insurer">
                                                <option>Select Preferred Insurer</option>
                                                <?php
                                                    foreach($get_insurers as $insurer){
                                                    echo "<option value='".$insurer['unique_id']."'>".$insurer['name']."</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <span for="last-name-column">Plan *</span>
                                            <select class="form-select" name="select_plan" id="select_plan">
                                                <option>Select package plan</option>
                                            </select>
                                        </div>
                                        <div class="flex form-group" id="save-quote-container">
                                            <input type="checkbox" id="save-quote" class="form-check-input">
                                            <span for="save-quote">Save quote</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        </div>
                                        <!-- <div class="form-group">
                                            <div class="form-check">
                                        <div class="checkbox">
                                            <input type="checkbox" id="checkbox2" class="form-check-input" >
                                            <span for="checkbox1"><span for="company-column">I declare that I have read the privacy information on the use of personal data</span></span>
                                        </div>
                                    </div>
                                    </div> -->
                                    </div>
                                    <!-- </div> -->
                                    <!-- <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary mr-1 mb-1">Calculate</button>
                                    </div> -->
                                    <div class="col-12 d-flex justify-content-end">
                                            <h4 for="id-column">Premium amount: ₦ <span id="premium_amount">--</span></h4>
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
            

