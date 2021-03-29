<?php 
include("includes/sidebar.php");
    // $user_id =$_SESSION['uid'];
    $loan_amount = isset($_SESSION['loan_amount']) ? $_SESSION['loan_amount'] : '';
    $loan_purpose = isset($_SESSION['purpose_of_loan']) ? $_SESSION['purpose_of_loan'] : '';
    $transaction_id = isset($_GET['transaction_id']) ? $_GET['transaction_id'] : '';
    if($transaction_id != ""){
        $callback_url = "http://$_SERVER[HTTP_HOST]"."zennal_callback.php?transaction_id=".$transaction_id;
        $redirect_url = "http://$_SERVER[HTTP_HOST]"."zennal_callback.php?transaction_id=".$transaction_id;
    }
    else{
        $callback_url = "https://$_SERVER[HTTP_HOST]"."zennal_callback";
        $redirect_url = "https://$_SERVER[HTTP_HOST]"."zennal_callback";
    }
    $get_user_employment_status = get_one_row_from_one_table_by_id('user_employment_details','user_id', $user_id ,'date_created');
?>
<div id="main">

<?php include("includes/header.php");?>            
<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Loan Purpose</h3>
        <p class="text-subtitle text-muted">Tell us what you need the loan for</p>
    </div>
<section class="section mt-5">
<div class="col-md-8 col-sm-12 mx-auto">
            <?php
                if(isset($_GET['message'])){
                    if($_GET['message'] == 'transaction_failed'){
                        $message = "Your transaction failed, please try again";
                        echo '<div class="alert alert-danger mb-3">'.$message.'</div>';
                    }
                    else if($_GET['message'] == 'transaction_successful'){
                        $message = "Your transaction was successful, please generate statement below";
                        echo '<div class="alert alert-success mb-3">'.$message.'</div>';
                    }
                }
            ?>
            <div class="card pt-4">
                <div class="card-body">
                    <form action="" method="post" id="submit_loan_purpose_form">
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
                                <input type="text" name="purpose_of_loan" class="form-control" id="purpose_of_loan" placeholder="Purpose of Loan" value="<?= $loan_purpose?>"  required>
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

                            <div class="form-group position-relative mt-2" id="manual_upload">
                                <div class="input-wrapper">
                                    <span class="label" for="email1">Manual Upload</span>
                                     <div class="custom-file-upload">
                                <input type="file" id="fileuploadInput" accept=".png, .jpg, .jpeg, .pdf" name="file">
                                <label for="fileuploadInput">
                                    <span>
                                        <strong>
                                            <ion-icon name="cloud-upload-outline"></ion-icon>
                                            <i id="uploaded_image">Tap to Upload</i>
                                        </strong>
                                    </span>
                                </label>
                            </div>
                                </div>
                                <span id=""></span>
                                <input type="hidden" name="bank_statement" id="bank_statement">
                            </div>

                            <div class="mt-2 text-center" id="online_generation">
                               <a href="#" id="online_bank_statement" class="font-weight-bold"> Click here to pay</a>  &nbsp<small> (Please note you will be charged &#8358;2100)</small>
                            </div>
                            <div class="mt-2">
                                <?php
                                    if(isset($_GET['message'])){
                                        if($_GET['message'] == 'transaction_successful'){
                                            // $message = "Your transaction failed, please try again";
                                            echo '<button type="button" class="btn btn-success mb-3" onclick="connectViaOptions()">Click here to generate Statement</button> &nbsp;&nbsp;<br>';
                                            echo "<small>Please submit when you're done</small>";
                                        }
                                    }
                                ?>
                            </div>
                             <div class="form-group">
                                <br>
                                <li class="d-inline-block mr-2 mb-1">
                                    <div class="form-check">
                                        <div class="checkbox">
                                            <input type="checkbox" class="form-check-input" id="checkbox2">
                                            <label for="checkbox2">I agree to Terms & Conditions</label>
                                        </div>
                                    </div>
                                </li>    
                            </div>
                            <div class="clearfix mt-3">
                                <button class="btn btn-primary btn-block" id="submit_loan_purpose">Submit</button>
                            </div>
                        </div>
                        <input type="hidden" name="employment_status" id="employment_status" value="<?= $get_user_employment_status['employment_status'];?>">
                    </form>
                    
                </div>
            </div>
        </div>
</section>

</div>
<?php include("includes/footer.php");?>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        $(document).ready(function(){
            $("#manual_upload").hide();
            $("#online_generation").hide();
            $("#bank_statement_option").change(function(){
                var bank_statement_option = $("select#bank_statement_option").children("option:selected").val();
                if(bank_statement_option == ""){
                    alert("Please select an option");
                }
                else if(bank_statement_option == 'manual_upload'){
                    $("#manual_upload").show();
                    $("#online_generation").hide();
                }
                else if(bank_statement_option == 'online_generation'){
                    $("#manual_upload").hide();
                    $("#online_generation").show();
                }
            });

            $(document).on('change', '#fileuploadInput', function(){
            var property = document.getElementById("fileuploadInput").files[0];
            var image_name = property.name;
            var image_size = property.size;
            var image_extension = image_name.split(".").pop().toLowerCase();
            if(jQuery.inArray(image_extension, ['png', 'jpg', 'jpeg', 'pdf', 'doc', 'docx']) == -1){
              alert("Invalid Image File");
              $('#uploaded_image').html("<label class='text_primary'><b>Image Upload failed, please try again</b></label>");
            }
            else if(image_size > 10000000){
              alert("Image File size is very big");
              $('#uploaded_image').html("<label class='text_primary'><b>Image Upload failed, please try again</b></label>");
            }else{
              var form_data = new FormData();
              form_data.append("file", property);
              $.ajax({
                url: "ajax/upload_image.php",
                method: "POST",
                data: form_data,
                contentType:false,
                cache:false,
                processData:false,
                beforeSend:function(){
                  $('#uploaded_image').html("<label class='text_primary'><b>Image Uploading, please wait...</b></label>");
                },
                success: function(data){
                  $('#uploaded_image').html("<label class='text_success'><b>Image Uploaded</b></label>");
                  $('#bank_statement').val(data);
                }
              })
            }
        }); 
        });

        function connectViaOptions() {
            Okra.buildWithOptions({
                name: 'Cloudware Technologies',
                env: 'production-sandbox',
                key: 'a804359f-0d7b-52d8-97ca-1fb902729f1a',
                token: '5f5a2e5f140a7a088fdeb0ac', 
                source: 'link',
                color: '#ffaa00',
                limit: '24',
                // amount: 5000,
                // currency: 'NGN',
                // charge: {
                //       type: 'recurring',
                //       amount: 5000,
                //       note: '',
                //       startDate: '2020-12-27',
                //       endDate: '2020-12-30',
                //       currency: 'NGN',
                //       account: '5ecfd65b45006210350becce'
                //     },
                corporate: null,
                connectMessage: 'Which account do you want to connect with?',
                products: ["auth", "transactions", "balance"],
                // callback_url: 'http://zennal.staging.cloudware.ng/okra_callback.php',
                callback_url: '<?php echo $callback_url?>',
                //redirect_url: 'http://getstarted.naicfund.ng/zennal_redirect.php',
                logo: 'https://cloudware.ng/wp-content/uploads/2019/12/CloudWare-Christmas-Logo.png',
                filter: {
                    banks: [],
                    industry_type: 'all',
                },
                widget_success: 'Your account was successfully linked to Cloudware Technologies',
                widget_failed: 'An unknown error occurred, please try again.',
                currency: 'NGN',
                exp: null,
                success_title: 'Cloudware Technologies!',
                success_message: 'You are doing well!',
                onSuccess: function (data) {
                    console.log('success', data);
                    //window.location.href = "http://getstarted.naicfund.ng/zennal_redirect.php";
                    //window.location.href = '<?php echo $redirect_url?>';
                    //console.log('http://localhost/zennal/zennal_callback.php?transaction_id='+<?php //echo $transaction_id;?>);
                },
                onClose: function () {
                    console.log('closed')
                }
            })
        }
    </script>