
<?php include("includes/sidebar.php");?>
<div id="main">

<?php include("includes/header.php");?>            
<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Apply for Loan</h3>
        <p class="text-subtitle text-muted">Let's know you better</p>
    </div>


 <section class="section mt-5">
<div class="col-md-8 col-sm-12 mx-auto">
    <div class="card">
      <div class="wizard-inner">
                <!-- <div class="connecting-line"></div> -->
                <div class="container">
                <ul class="nav nav-tabs" role="tablist">
                    <div class="col-md-4 text-center">
                        <li role="presentation" class="">
                        <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
                            <a  href="apply_loan.php" class="">
                                <i data-feather="briefcase" width="100"></i>
                                <p>Employment Details</p>
                                
                            </a>
                        </a>
                    </li>
                    </div>

                    <div class="col-md-4 text-center">
                        <li role="presentation" class="active">
                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                            <a href="verify_otp.php" class="">
                                <i data-feather="git-commit" width="100"></i>
                                <p>Verify OTP</p>
                            </a>
                        </a>
                    </li>
                    </div>

                    <div class="col-md-4 text-center">
                         <li role="presentation" class="disabled">
                        <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3">
                            <span class="">
                                <i data-feather="home" width="100"></i>
                                <p>Financial Details</p>
                            </span>
                        </a>
                    </li>

                    </div>

                </ul>
                </div>
                
            </div>  
    </div>
</div>

<!-- details -->

    <div class="col-md-8 col-sm-12 mx-auto">
        <div class="card">
           
            <div class="card-body">
        <div class="wizard">
                <div class="tab-content">
                    
                    <div class="tab-pane active" role="tabpanel" id="step3">
                    <form action="loan_purpose.php" method="post" id="submit_financial_details_form" enctype="multipart/form-data">
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="span" for="name1">Bank Name</span>
                            <select name="bank_name" id="bank_name" class="form-select">
                                <option value="">Select Bank Name</option>
                                <?php foreach ($get_bank_name_decode['data'] as $value){ ?>
                                <option value="<?php echo $value['code']?>"><?php echo $value['name']?></option>
                                <?php } ?>
                            </select>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                             <span class="span" for="name1">Account Number (Salary Account)</span>
                            <input type="text" class="form-control" id="account_number" name="account_number" placeholder="Account Number (please note that it must be your salary account)" >
                            <!-- value="<?= $get_financial_details['account_number']?>" -->
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                    <!-- <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="name1">Account Name</label>
                            <input type="text" class="form-control" id="name1" placeholder="Enter account name">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div> -->
                      <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="span" for="name1">Account Type</span>
                            <select name="account_type" class="form-select">
                                <option value="">Select Account Type</option>
                                <option value="savings">Savings</option>
                                <option value="current">Current</option>
                            </select>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="name1">BVN</label>
                            <input type="number" class="form-control" id="bvn" name="bvn" placeholder="BVN" value="<?= $get_financial_details['bvn']?>">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                      <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="span" for="name1">Do you Currently have an existing loan?</span>
                            <select name="existing_loan" class="form-select" id="current_repayment">
                                <option value="">Select whether you have existing loan or not</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                    <div class="form-group boxed" id="current_repayment_amount" style="display: none;">
                        <div class="input-wrapper">
                            <span class="span" for="name1">Current Monthly repayment on existing loan</span>
                            <input type="text" class="form-control" id="monthly_repayment" name="monthly_repayment" placeholder="Monthly Repayment on existing loan (if applicable)" value="<?= $get_financial_details['monthly_repayment']?>">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="span" for="email1">Upload a Government Issued ID</span>
                             <div class="custom-file-upload">
                        <input type="file" id="fileuploadInput" accept=".png, .jpg, .jpeg" name="image">
                        <label for="fileuploadInput">
                            <span>
                                <strong>
                                    <ion-icon name="cloud-upload-outline"></ion-icon>
                                    <i>Tap to Upload</i>
                                </strong>
                            </span>
                        </label>
                    </div>
                        </div>
                    </div>
                    <div class="mt-3 mb-3">
                       <button type="submit" class="btn btn-primary btn-block btn-lg" id="submit_financial_details" name="submit_financial_details">Submit</button>
                    </div>
                </form>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="complete">
                        <h3>Complete</h3>
                        <p>You have successfully completed all steps.</p>
                    </div>
                    <div class="clearfix"></div>
                </div>
        </div> 
         </div>
     </div>
    </div>
</section>   

</div>
<script type="text/javascript">
    
</script>
<?php include("includes/footer.php");?>
            

