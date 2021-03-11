
<?php include("sidebar.php");?>
<div id="main">

<?php include("header.php");?>            
<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Vehicle Insurance</h3>
        <p class="text-subtitle text-muted">Get a quote</p>
    </div>

        <div class="row">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-right">
                            <li class="breadcrumb-item"><a href="select_action.php">Home</a></li>
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
                            <form class="form" action="">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <span for="first-name-column">Vehicle Value *</span>
                                            <input type="text" id="Vehicle" class="form-control" placeholder="Enter Vehicle Value" name="Vehicle-column">
                                        </div>
                                        <div class="form-group">
                                            <span for="last-name-column">Preferred Insurer * </span>
                                            <select class="form-select">
                                                <option>Select Preferred Insurer</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <span for="last-name-column">Plan *</span>
                                            <select class="form-select">
                                                <option>Plan</option>
                                                <option>Silver</option>
                                                <option>Gold</option>
                                                <option>Diamond</option>
                                                <option>Platinum</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" id="checkbox1" class="form-check-input">
                                            <span for="country-floating">Save quote</span>
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
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary mr-1 mb-1">Calculate</button>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                            <h3 for="id-column">Total - ₦29,750</h3>
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
            

