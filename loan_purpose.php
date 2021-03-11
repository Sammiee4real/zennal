
<?php include("sidebar.php");?>
<div id="main">

<?php include("header.php");?>            
<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Loan Purpose</h3>
        <p class="text-subtitle text-muted">Tell us what you need the loan for</p>
    </div>

<section class="section mt-5">
<div class="col-md-8 col-sm-12 mx-auto">
            <div class="card pt-4">
                <div class="card-body">
                    
                    <form action="success.php">
                        <div class="form-group position-relative ">
                            <span for="username">Amount (in naira)</span>
                            <div class="position-relative">
                                <input type="number" name="loan_amount" class="form-control" id="loan_amount" placeholder="Amount you want to borrow" value="<?= $loan_amount?>" required>
                                
                            </div>
                        </div>
                        <div class="form-group position-relative ">
                            <div class="clearfix">
                                <span for="Purpose">Purpose</span>
                                
                            </div>
                            <div class="position-relative">
                                <input type="text" name="purpose_of_loan" class="form-control" id="purpose_of_loan" placeholder="Purpose of Loan"  required>
                                <!-- value="<?= $loan_purpose?>" -->
                            </div>
                        </div>

                        <div class="form-group position-relative has-icon-left">
                            <div class="clearfix">
                                <span for="Upload Bank Statement">Upload Bank Statement</span>
                                
                            </div>
                            <div class="position-relative">
                               <select id="bank_statement_option" class="form-select">
                                <option value="">Select an Option</option>
                                <option value="manual_upload">Manual Upload</option>
                                <option value="online_generation">Generate Bank Statement</option>
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
<?php include("footer.php");?>
            

