
<?php include("includes/sidebar.php");
    $get_financial_details = get_one_row_from_one_table_by_id('user_financial_details','user_id',$user_id, 'date_created');
    $get_bank_name = list_of_banks();
    $get_bank_name_decode = json_decode($get_bank_name, true);
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
                            <select name="bank_name" id="bank_name2" class="form-select">
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

                    <div class="row justify-content-center">
                        <div class="col-md-4"></div>
                        <div class="col-md-8">
                            <div id="accordion">
                              <h5 class="mb-3 mt-3">
                                <a class="btn btn-outline-secondary btn-sm text-center" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="font-size: 15px;">
                                  Why is my BVN required?
                                </a>
                              </h5>
                            </div>
                        </div>
                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                          <div class="card-body">
                            We request your BVN to verify that the individual applying for a Zennal Loan is the same as the owner of the provided bank account. This ensures that your account details cannot be used to apply for a loan without your authorization. <br>
                            Please note: Your BVN does not provide access to your account. If in doubt, we encourage you to confirm this from your bank before you proceed. <br>
                            Dial <b>*565*0#</b> to get your BVN<br>Please note: This will only work if you are making the request from the same phone number currently linked to your bank account.
                          </div>
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
                        <input type="file" id="file" accept=".png, .jpg, .jpeg" name="image">
                        <label for="file">
                            <span>
                                <strong>
                                    <ion-icon name="cloud-upload-outline"></ion-icon>
                                    <i id="uploaded_image">Tap to Upload</i>
                                </strong>
                            </span>
                        </label>
                        <input type="hidden" name="image_path" id="image_url">
                    </div>
                        </div>
                    </div>

                    <input type="hidden" name="reg_id" id="reg_id" value="<?= $reg_id;?>">
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
<script type="text/javascript">
    $(document).ready(function(){
        $("select#current_repayment").change(function(){
            var selected_value = $("select#current_repayment").children("option:selected").val();
            if(selected_value == 1){
                $("#current_repayment_amount").css("display", "block");
            }else{
                $("#current_repayment_amount").css("display", "none");
            }
        });
    });

    $(document).on('change', '#file', function(){
        let unique_id3 = "<?php echo $user_id;?>";
        var property = document.getElementById("file").files[0];
        var image_name = property.name;
        var image_size = property.size;
        var image_extension = image_name.split(".").pop().toLowerCase();
        if(jQuery.inArray(image_extension, ['png', 'jpg', 'jpeg']) == -1){
          alert("Invalid Image File");
          $('#uploaded_image').html("Image Upload failed, please try again");
        }
        else if(image_size > 5000000){
          alert("Image File size is very big");
          $('#uploaded_image').html("Image Upload failed, please try again");
        }else{
          var form_data = new FormData();
          form_data.append("file", property);
          form_data.append("unique_id3", unique_id3);
          $.ajax({
            url: "upload_image.php",
            method: "POST",
            data: form_data,
            contentType:false,
            cache:false,
            processData:false,
            beforeSend:function(){
              $('#uploaded_image').html("Image Uploading, please wait...");
            },
            success: function(data){
              $('#uploaded_image').html("Image Uploaded");
              $('#image_url').val(data);
            }
          })
        }
    });
</script>
            

