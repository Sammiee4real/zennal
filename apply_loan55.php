<?php include("includes/sidebar.php");?>
<div id="main">

<?php include("includes/header.php");?> 

<style type="text/css">



.colors {
  /*padding: 2em;
  color: #fff;*/
  display: none;
}

a {
 /* color: #c04;
  text-decoration: none;*/
}

a:hover {
 /* color: #903;
  text-decoration: underline;*/
}

#bar, #cus {display:none;}

</style>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
function show(el, txt){
    var elem1 = document.getElementById('bar');
   
    elem1.style.display = (txt == 'Yes') ? 'block' : 'none';
   
    }
</script>

<script type="text/javascript">
    $(function() {
  $('#colorselector').change(function(){
    $('.colors').hide();
    $('#' + $(this).val()).show();
  });
});

</script>
<script>
$(document).ready(function(){
    $("select").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue){
                $(".box").not("." + optionValue).hide();
                $("." + optionValue).show();
            } else{
                $(".box").hide();
            }
        });
    }).change();
});
</script>

      
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
                        <form>
<div class="button dropdown"> 
    <div class="form-group">
                            <span class="" for="city5">Employment Status</span>
                            <select name="employment_status" class="form-select" id="colorselector">
                                <option value="">Select</option>
                                <option value="yellow" id="stu">Student (Must be above 18yrs)</option>
                                <option value="red"  id="nysc">NYSC</option>
                                <option value="red" id="emp">Employed</option>
                                <option value="yellow" id="self_em">Self employed</option>
                                <option value="yellow" id="unemp">Unemployed</option>
                                <option value="yellow" id="bizo">Business Owner</option>
                            </select>
      </div>
</div>

<div class="output">

  <div id="red" class="colors red">

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="" for="city5">Name of Organization</span>
                            <input type="text" class="form-control" id="name_of_organization" name="name_of_organization" placeholder="Enter the name of your Organization">  
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
                            <span for="name1">How long have you been at your current job?</span>
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
  </div>

<div id="yellow" class="colors yellow"> 
 <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="p" for="name1">Education</span>
                            <select name="years_of_experience" class="form-select">
                                <option value="">Select qualification</option>
                                <option value="Primary">Primary</option>
                                <option value="Secondary">Secondary</option>
                                <option value="Graduate">Graduate</option>
                                <option value="Post Graduate">Post Graduate</option>
                            </select>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="p" for="name1">Home Address</span>
                            <input type="text" name="address" placeholder="Home Address" class="form-control">
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="p" for="name1">City</span>
                            <select name="" class="form-select">
                            <option>Select the City you live in</option>
                        </select>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="p" for="name1">State</span>
                            <select name="" class="form-select">
                            <option>Select the State you live in</option>
                        </select>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="p" for="name1">Type of residence</span>
                            <select name="years_of_experience" class="form-select">
                                <option value="">Select residence </option>
                                <option value="Rented">Rented</option>
                                <option value="Owner">Owner</option>
                                <option value="Shared apartment">Shared apartment</option>
                            </select>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="p" for="name1">How long have you lived there?</span>
                            <div class="row">
                                <div class="col-md-6">
                                   <span>How many years?</span> 
                                   <input type="number" name="" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <span>How many months?</span> 
                                   <input type="number" name="" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                            <span class="p" for="name1">Marital Status</span>
                            <select name=""  class="form-select" >
                                <option value="">Select Status</option>
                                <option value="">Single</option>
                                <option value="one">Married</option>
                                <option value="one">Divorced</option>
                                <option value="one">Widowed</option>
                            </select>
                        </div>
            <div class="one box">
                              <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="p" for="name1">Name of Spouse</span>
                            <input type="text" name="address" placeholder="Name of Spouse" class="form-control">
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="p" for="name1">Phone number of Spouse</span>
                            <input type="text" name="address" placeholder="Phone number of Spouse" class="form-control">
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="p" for="name1">Number of Kids</span>
                            <input type="text" name="address" placeholder="Phone number of Spouse" class="form-control">
                        </div>
                    </div>
             </div>
             <!-- end one -->

             <div class="form-group">
                            <span class="" for="name">Professional Category</span>
                            <select name=""  class="form-select" >
                                <option value="">Select category</option>
                                <option value="">Agency/Contract Workers</option>
                                <option value="">Sales/ Shop/ Restaurant</option>
                                <option value="">Artisans</option>
                                <option value="">Religious organization</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <span class="" for="name">Professional subcategory</span>
                            <select name=""  class="form-select" >
                                <option value="">Select Subcategory</option>
                                <option value="">Information Technology</option>
                                <option value="">Marketing Sales</option>
                                <option value="">Communication</option>
                                <option value="">Corporate Services</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <span class="" for="name">Do you have a company?</span>
                            <select name=""  class="form-select"  onChange="show('bar', this.options[this.selectedIndex].firstChild.nodeValue)" >
                                <option value="">Select </option>
                                <option value="">Yes</option>
                                <option value="">No</option>
                            </select>
                        </div>

                <div id="bar">
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="" for="name">Is your company registered?</span>
                            <select name=""  class="form-select" >
                                <option value="">Select </option>
                                <option value="green">Yes</option>
                                <option value="">No</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="green box">
                      <div class="form-group">
                            <span class="" for="name">CAC number</span>
                            <input type="text" name="" value="RC" class="form-control">
                        </div>

                        <div class="form-group">
                            <span class="" for="name">Company Name</span>
                            <input type="text" name="" value="" class="form-control" placeholder="Company Name">
                        </div>    

                        <div class="form-group">
                            <span class="" for="name">Company address</span>
                            <input type="text" name="" value="" class="form-control" placeholder="Company address">
                        </div>  
                </div>

                        <div class="form-group">
                            <span class="" for="name">Estimated Monthly income</span>
                            <input type="text" name="" value="" class="form-control" placeholder="Monthly income">
                        </div>

                        <div class="mt-3 mb-3">
                        <button type="button" class="btn btn-primary btn-block btn-lg" id="submit_employment_details" name="submit_employment_details">Next</button>
                    </div>


</div>
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
<?php include("includes/footer.php");?>
