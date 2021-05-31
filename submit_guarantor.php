<?php include("includes/sidebar.php");?>
<div id="main">

<?php include("includes/header.php");?> 
<style type="text/css">
#bar, #cus {display:none;}
</style>
<script>
function show(el, txt){
    var elem1 = document.getElementById('bar');
    var elem2 = document.getElementById('cus');

    elem1.style.display = (txt == 'Comprehensive Insurance') ? 'block' : 'none';
    elem2.style.display = (txt == 'Custom number plate') ? 'block' : 'none';
    }
</script>           
<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Guarantor's Details</h3>
        <p class="text-subtitle text-muted">Provide the details below</p>
    </div>


<!-- <section class="section mt-5" id="multiple-column-form ">
        <div class="row match-height">
            <div class="col-7 mx-auto">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" id="submit_guarantor_form">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="mt-3 mb-3">
                                          <h4 class="card-title"></h4>
                                        </div>

                                        <div class="alert alert-light-primary color-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>Note: Your guarantor will be held liable if you don't pay within agreed terms.</div>

                        <div class="form-group">
                            <span class="" for="name">Guarantor's name</span>
                            <input type="text" name="guarantor_name" value="" class="form-control" placeholder="Guarantor's name">
                        </div>

                        <div class="form-group">
                            <span class="" for="name">2nd Guarantor's name</span>
                            <input type="text" name="" value="" class="form-control" placeholder="Guarantor's name">
                        </div>

                        <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="" for="name">Relationship </span>
                            <select name="relationship"  class="form-select" >
                                <option value="">Select your relationship with guarantor </option>
                                <option value="">Wife</option>
                                <option>Husband</option>
                                <option value="">Brother</option>
                                <option>Sister</option>
                                <option>Uncle</option>
                                <option>Aunt</option>
                                <option>Son</option>
                                <option>Daughter</option>
                                <option>Nephew</option>
                                <option>Niece</option>
                            </select>
                        </div>
                    </div>

                        <div class="form-group">
                            <span class="" for="name">Phone number</span>
                            <input type="number" name="phone" value="" class="form-control" placeholder="Phone number">
                        </div>

                        <div class="form-group">
                            <span class="" for="name">Loan details</span>
                            <input type="text" name="loan_details" value="" class="form-control" placeholder="Loan details">
                        </div>

                        <div class="form-group">
                            <span class="" for="name">How much do you want to borrow?</span>
                            <input type="number" name="" value="" class="form-control" placeholder="How much do you want to borrow">
                        </div>

                        <div class="form-group">
                            <span class="" for="name">Purpose of Loan</span>
                            <input type="text" name="" value="" class="form-control" placeholder="Purpose of Loan">
                        </div>

                        </div>
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-primary mr-1 mb-1" id="submit_guarantor">Submit</button>
                        </div>

                        </form>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
    </section> -->


<section class="section mt-5">
    <div class="col-md-8 col-sm-12 mx-auto">
        <?php
            if(isset($_GET['message'])){
                if($_GET['message'] == 'transaction_failed'){
                    $message = "Error! Please try again";
                    echo '<div class="alert alert-danger mb-3">'.$message.'</div>';
                }
                else if($_GET['message'] == 'transaction_successful'){
                    $message = "Your loan has been disbursed successfully, you will be redirected shortly";
                    echo '<div class="alert alert-success mb-3">'.$message.'</div>';
                    echo '<meta http-equiv="refresh" content="5; url=index" />';
                }
            }
        ?>
        <div class="card">
            <div class="card-body">
                Please click the button below to submit your guarantors' details<br><br>
                <button onclick="connectViaOptions2()" class="btn btn-primary btn-sm">Submit Guarantor</button>
            </div>
        </div>
    </div>
</section>   

 

</div>
<?php include("includes/footer.php");?>
<script type='text/javascript'>
    function connectViaOptions2() {
        Okra.buildWithOptions({
            name: 'Cloudware Technologies',
            env: 'production-sandbox',
            key: 'a804359f-0d7b-52d8-97ca-1fb902729f1a',
            token: '5f5a2e5f140a7a088fdeb0ac', 
            source: 'link',
            color: '#ffaa00',
            // limit: '6',
            guarantors: {
                status: true,
                number: 2
            },
            // corporate: null,
            connectMessage: 'Which account do you want to connect with?',
            // products: ["auth", "transactions", "balance"],
            //callback_url: 'http://zennal.staging.cloudware.ng/okra_callback.php',
            //callback_url: '<?php//echo $callback_url;?>',
            //redirect_url: 'http://getstarted.naicfund.ng/zennal_redirect.php',
            logo: 'https://cloudware.ng/wp-content/uploads/2019/12/CloudWare-Christmas-Logo.png',
            filter: {
                banks: [],
                industry_type: 'all',
            },
            widget_success: "Your Guarantors' details have been submitted to Cloudware Technologies",
            widget_failed: 'An unknown error occurred, please try again.',
            // currency: 'NGN',
            exp: null,
            success_title: 'Cloudware Technologies!',
            success_message: 'You are doing well!',
            onSuccess: function (data) {
                console.log('success', data);
                $.ajax({
                    url: "ajax/submit_guarantor.php",
                    method: "POST",
                    data: {data},
                    success: function(data){
                        if(data == "success"){
                            // Swal.fire({
                            //     title: "Congratulations!",
                            //     text: "Your Guarantors' details have been submitted successfully, you will be redirected shortly",
                            //     icon: "success",
                            // }).then(setTimeout( function(){ window.location.href = "success"}, 5000));
                            setTimeout( function(){ window.location.href = "success"}, 5000);
                        }
                        else{
                            Swal.fire({
                                title: "Error!",
                                text: data,
                                icon: "error",
                            });
                        }
                    }
                })
            },
            onClose: function () {
                console.log('closed')
            }
        })
    } 
</script>