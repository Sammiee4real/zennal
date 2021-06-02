
<?php include("includes/sidebar.php");
    $get_employment_details =  get_one_row_from_one_table_by_id('user_employment_details','user_id', $user_id, 'date_created');
    $get_user_details  =  get_one_row_from_one_table_by_id('users','unique_id', $user_id, 'registered_on');
    @$get_loan_details = get_rows_from_one_table_by_id('personal_loan_application','user_id', $user_id, 'date_created');
    $count = 0;
    $reg_id = isset($_GET['reg_id']) ? $_GET['reg_id'] : '';
    // foreach ($get_loan_details as $value) {
    //     if($value['approval_status'] == 3){
    //         $count++;
    //     }
    // }
    // if($count > 0){
    //     echo '<meta http-equiv="refresh" content="0; url=error_page" />';
    // }
?>
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
    var color = $("#colorselector").children("option:selected").val();
    if(color == 1 || color == 4 || color == 5 || color == 6){
        $("#yellow").show();
    }else if(color == 2 || color == 3 ){
        $("#red").show();
    }
    //$('#' + option_class).show();
  });
});

</script>
<script>
$(document).ready(function(){
     $(".show_martial").hide();
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
    $('#marital_status').change(function(){
        $(".show_martial").hide();
        var status = $("select#marital_status").children("option:selected").val();
        if(status == 2){
            $(".show_martial").show();
        }
        //$('#' + option_class).show();
    });
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
                            <a class="">
                                <i data-feather="git-commit" width="100"></i>
                                <p>Verify OTP</p>
                            </a>
                        </a>
                    </li>
                    </div>

                    <div class="col-md-4 text-center">
                         <li role="presentation" class="disabled">
                        <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3">
                            <a class="">
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
                        <small class="text-warning">All fields are required</small>
   <form method="post" id="submit_employment_details_form">
        <div class="button dropdown"> 
            <div class="form-group">
                <span class="" for="city5">Employment Status</span>
                <select name="employment_status" class="form-select" id="colorselector">
                    <option value="">Select</option>
                    <option class="yellow" value="1">Student (Must be above 18yrs)</option>
                    <option class="red" value="2">NYSC</option>
                    <option class = "red" value="3">Employed</option>
                    <option class="yellow" value="4">Self employed</option>
                    <option class="yellow" value="5">Unemployed</option>
                    <option class="yellow" value="6">Business Owner</option>
                </select>
              </div>
        </div>
            <input type="hidden" name="reg_id" id="reg_id" value="<?= $reg_id;?>">
            <div class="output">

            <div id="red" class="colors red">
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="" for="city5">Name of Organization</span>
                            <input type="text" class="form-control" id="name_of_organization" name="name_of_organization" placeholder="Enter the name of your Organization" value="<?= $get_employment_details['name_of_organization']?>">  
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="p" for="name1">Contact Address of Organization</span>
                            <textarea name="contact_address_of_organization" class="form-control" rows="2"placeholder="Organization's Contact Address">
                                <?= $get_employment_details['contact_address_of_organization']?>
                            </textarea>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="p" for="name1">Job Title</span>
                            <input type="text" class="form-control" id="job_title" name="job_title" placeholder="Enter your job title" value="<?= $get_employment_details['job_title']?>">
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
                                <option value="1">Permanent</option>
                                <option value="2">Contract</option>
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
                            <input type="text" class="form-control" id="industry_type" name="industry_type" placeholder="Type of Industry (Banking, Other fin. Services, Telecoms, Oil and Gas etc.)" value="<?= $get_employment_details['industry_type']?>">
                            <!-- value="<?= $get_employment_details['industry_type']?>" -->
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                      <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="span" for="name1">Current Monthly Salary (Net)</span>
                            <input type="text" class="form-control" id="monthly_salary" name="monthly_salary" placeholder="Current Monthly Salary (Net) in naira" value="<?= $get_employment_details['monthly_salary']?>">
                             <!-- value="<?= $get_employment_details['monthly_salary']?>" -->
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="p" for="name1">Payday</span>
                            <input type="text" class="form-control" id="salary_payday" name="salary_payday" placeholder="Salary Payday (from 1st to 31st)" value="<?= $get_employment_details['salary_payday']?>">
                            <!-- value="<?= $get_employment_details['salary_payday']?>" -->
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                     <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="span" for="lastname1">Email Address</span>
                            <input type="email" class="form-control" id="official_email_address" name="official_email_address" placeholder="Official Email Address" value="<?= $get_user_details['email']?>">
                            <!-- value="<?= $get_user_details['email']?>" -->
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                            <div class="valid-feedback">Looks good!</div>
                            <div class="invalid-feedback">Please enter your email address.</div>
                        </div>
                    </div>
                   
                    <div class="mt-3 mb-3">
                        <button type="button" class="btn btn-primary btn-block btn-lg submit_employment_details" id="" name="submit_employment_details">Next</button>
                    </div>
                </div>

                <div id="yellow" class="colors yellow"> 
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="p" for="name1">Education</span>
                            <select name="education" class="form-select">
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
                            <input type="text" name="home_address" placeholder="Home Address" class="form-control" value="<?= $get_user_details['address']?>">
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="p" for="name1">City</span>
                            <input type="text" name="city" class="form-control" value="<?=$get_employment_details['city'];?>">
                        </select>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="p" for="name1">State</span>
                            <input type="text" name="state" class="form-control" value="<?=$get_employment_details['state'];?>">
                        </select>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="p" for="name1">Type of residence</span>
                            <select name="residence_type" class="form-select">
                                <option value="">Select residence </option>
                                <option value="1">Rented</option>
                                <option value="2">Owner</option>
                                <option value="3">Shared apartment</option>
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
                                   <input type="" name="years_of_stay" class="form-control" value="<?=$get_employment_details['years_of_stay'];?>">
                                </div>
                                <div class="col-md-6">
                                    <span>How many months?</span> 
                                   <input type="number" name="months_of_stay" class="form-control" value="<?=$get_employment_details['months_of_stay'];?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                            <span class="p" for="name1">Marital Status</span>
                            <select name="marital_status" id="marital_status"  class="form-select" >
                                <option value="">Select Status</option>
                                <option value="1">Single</option>
                                <option value="2">Married</option>
                                <option value="3">Divorced</option>
                                <option value="4">Widowed</option>
                            </select>
                        </div>
            <div class="show_martial">
                              <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="p" for="name1">Name of Spouse</span>
                            <input type="text" name="name_of_spouse" placeholder="Name of Spouse" class="form-control"value="<?=$get_employment_details['name_of_spouse'];?>">
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="p" for="name1">Phone number of Spouse</span>
                            <input type="text" name="phone_of_spouse" placeholder="Phone number of Spouse" class="form-control" value="<?=$get_employment_details['phone_of_spouse'];?>">
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="p" for="name1">Number of Kids</span>
                            <input type="number" name="no_of_kids" placeholder="Phone number of Spouse" class="form-control" value="<?=$get_employment_details['no_of_kids'];?>">
                        </div>
                    </div>
             </div>
             <!-- end one -->

             <div class="form-group">
                            <span class="" for="name">Professional Category</span>
                            <select name="professional_category"  class="form-select" >
                                <option value="">Select category</option>
                                <option value="1">Agency/Contract Workers</option>
                                <option value="2">Sales/ Shop/ Restaurant</option>
                                <option value="3">Artisans</option>
                                <option value="4">Religious organization</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <span class="" for="name">Professional subcategory</span>
                            <select name="professional_subcategory"  class="form-select" >
                                <option value="">Select Subcategory</option>
                                <option value="1">Information Technology</option>
                                <option value="2">Marketing Sales</option>
                                <option value="3">Communication</option>
                                <option value="4">Corporate Services</option>
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
                            <input type="text" name="cac_number" class="form-control" value="<?= $get_employment_details['cac_number'];?>">
                        </div>

                        <div class="form-group">
                            <span class="" for="name">Company Name</span>
                            <input type="text" name="company_name" value="" class="form-control" placeholder="Company Name" value="<?= $get_employment_details['company_name'];?>">
                        </div>    

                        <div class="form-group">
                            <span class="" for="name">Company address</span>
                            <input type="text" name="company_address" value="" class="form-control" placeholder="Company address" value="<?= $get_employment_details['company_address'];?>">
                        </div>  
                </div>

                        <div class="form-group">
                            <span class="" for="name">Estimated Monthly income</span>
                            <input type="text" name="monthly_income" class="form-control" placeholder="Monthly income" value="<?= $get_employment_details['monthly_income'];?>">
                        </div>

                        <div class="mt-3 mb-3">
                        <button type="button" class="btn btn-primary btn-block btn-lg submit_employment_details" id="" >Next</button>
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
