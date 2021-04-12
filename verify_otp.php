<?php include("includes/sidebar.php");
    $reg_id = isset($_GET['reg_id']) ? $_GET['reg_id'] : '';
?>
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
                            <span class="">
                                <i data-feather="git-commit" width="100"></i>
                                <p>Verify OTP</p>
                            </span>
                        </a>
                    </li>
                    </div>

                    <div class="col-md-4 text-center">
                         <li role="presentation" class="disabled">
                        <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3">
                            <a href="financial_details.php" class="">
                                <i data-feather="home" width="100"></i>
                                <p>Financial Details</p>
                            </a>
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
                    <div class="tab-pane  active" role="tabpanel" id="step2">

                    <!-- <div class="alert alert-light-primary color-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>  This is primary alert.</div>
 -->
                        <div class="login-form">
                    <div class="section">
                        <h5>Verify Now</h5>
                        <h6>We sent a verification code to your Email Address</h6>
                    </div>
                    <div class="section mt-2 mb-5">
                        <form action="" method="post" id="verify_otp_form">

                            <div class="form-group boxed">
                                <div class="input-wrapper">
                                    <input type="password" class="form-control verify-input" name="otp" id="otp" placeholder="••••••" maxlength="6">
                                </div>
                            </div>

                            <div class="mt-5">
                                <button type="button" class="btn btn-primary btn-block btn-lg" id="verify_otp" name="verify_otp">Verify</button>
                            </div>
                            <input type="hidden" name="reg_id" id="reg_id" value="<?= $reg_id;?>">
                        </form>
                    </div>
                </div>
                    </div>
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
            

