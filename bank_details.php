
<?php include("includes/sidebar.php");?>
<div id="main">

<?php include("includes/header.php");?>            
<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Bank Account Details</h3>
        <p class="text-subtitle text-muted">Enter your bank account details to verify your eligibility</p>
    </div>

<section class="section mt-5">
<div class="col-md-8 col-sm-12 mx-auto">
            <div class="card pt-4">
                <div class="card-body">
                    
                    <form action="">
                        <div class="form-group position-relative ">
                            <span for="username">Bank Account Name</span>
                            <div class="position-relative">
                                <input type="text" name="bank_account" class="form-control" id="" placeholder="Bank Account Name" value="" required>
                                
                            </div>
                        </div>
                        <div class="form-group position-relative ">
                            <span for="username">Bank Account Number</span>
                            <div class="position-relative">
                                <input type="number" name="bank_name" class="form-control" id="bank_name" placeholder="Bank Account Number" value="<?= $bank_name?>" required>
                                
                            </div>
                        </div>
                        

                        <div class="form-group position-relative ">
                            <div class="clearfix">
                                <span for="Upload Bank Statement">Bank Name</span>
                                
                            </div>
                            <div class="position-relative">
                               <select id="bank_name_option" class="form-select">
                                <option value="">Select Bank </option>
                                <option value="">First Bank </option>
                                <option value="manual_upload">Access Bank </option>
                                <option value="online_generation">Guarantee Trust Bank</option>
                            </select>
                                
                            </div>
                        </div>

                        <div class="clearfix mt-5">
                            <button class="btn btn-primary btn-block">Submit</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
</section>

    

</div>
<?php include("includes/footer.php");?>
            

