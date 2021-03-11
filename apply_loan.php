
<?php include("sidebar.php");?>
<div id="main">

<?php include("header.php");?>            
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
                        <li role="presentation" class="active">
                        <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
                            <span class="">
                                <i data-feather="briefcase" width="100"></i>
                                <p>Employment Details</p>
                                
                            </span>
                        </a>
                    </li>
                    </div>

                    <div class="col-md-4 text-center">
                        <li role="presentation" class="disabled">
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
                    <div class="tab-pane active" role="tabpanel" id="step1">
                    <form action="" method="post" id="submit_employment_details_form">
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="" for="city5">Employment Status</span>
                            <select name="employment_status" class="form-select">
                                <option >Select</option>
                                <option >Employed</option>
                                <option >Unemployed</option>
                                <option >Business Owner</option>
                                 </select>
                                 <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="" for="city5">Name of Organization</span>
                            <input type="text" class="form-control" id="name_of_organization" name="name_of_organization" placeholder="Enter the name of your Organization"  
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="p" for="name1">Contact Address of Organization</span>
                            <textarea name="contact_address_of_organization" class="form-control" rows="2"placeholder="Organization's Contact Address">
                            </textarea>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="p" for="name1">Job Title</span>
                            <input type="text" class="form-control" id="job_title" name="job_title" placeholder="Enter your job title" >
                           <!--  value="<?= $get_employment_details['job_title']?>" -->
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                   <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="p" for="name1">Employment Type</span>
                            <select name="employment_type" class="form-select">
                                <option value="">Select Employment Type</option>
                                <option value="permanent">Permanent</option>
                                <option value="contract">Contract</option>
                            </select>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                        <div class="form-group boxed">
                        <div class="input-wrapper">
                            <p class="span" for="name1">How long have you been at your current job?</span>
                            <select name="employment_duration" class="form-select">
                                <option value="">Select Employment Duration</option>
                                <option value="<6 months">Less than 6 months</option>
                                <option value="6 months">6 months</option>
                                <option value="7 months">7 months</option>
                                <option value="8 months">8 months</option>
                                <option value="9 months">9 months</option>
                                <option value="10 months">10 months</option>
                                <option value="11 months">11 months</option>
                                <option value="12 months">12 months</option>
                                <option value="over a year">Over a year</option>
                            </select>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                       <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="p" for="name1">Cumulative years of experience</span>
                            <select name="years_of_experience" class="form-select">
                                <option value="">Select Cumulative years of Experience</option>
                                <option value="0-3">0-3</option>
                                <option value="4-8">4-8</option>
                                <option value="9-15">9-15</option>
                                <option value="16-24">16-24</option>
                                <option value="25 years and above">25 years and above</option>
                            </select>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                     <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="p" for="name1">Type of Industry</span>
                            <input type="text" class="form-control" id="industry_type" name="industry_type" placeholder="Type of Industry (Banking, Other fin. Services, Telecoms, Oil and Gas etc.)" >
                            <!-- value="<?= $get_employment_details['industry_type']?>" -->
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                      <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="span" for="name1">Current Monthly Salary (Net)</span>
                            <input type="text" class="form-control" id="monthly_salary" name="monthly_salary" placeholder="Current Monthly Salary (Net) in naira">
                             <!-- value="<?= $get_employment_details['monthly_salary']?>" -->
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="p" for="name1">Payday</span>
                            <input type="text" class="form-control" id="salary_payday" name="salary_payday" placeholder="Salary Payday (from 1st to 31st)" >
                            <!-- value="<?= $get_employment_details['salary_payday']?>" -->
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="span" for="lastname1">Email Address</span>
                            <input type="email" class="form-control" id="official_email_address" name="official_email_address" placeholder="Official Email Address" >
                            <!-- value="<?= $get_user_details['email']?>" -->
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                            <div class="valid-feedback">Looks good!</div>
                            <div class="invalid-feedback">Please enter your email address.</div>
                        </div>
                    </div>
                   
                    <div class="mt-3 mb-3">
                        <button type="button" class="btn btn-primary btn-block btn-lg" id="submit_employment_details" name="submit_employment_details">Next</button>
                    </div>

                </form>
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
<?php include("footer.php");?>
            

