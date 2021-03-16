
<?php include("includes/sidebar.php");?>
<div id="main">

<?php include("includes/header.php");?>            
<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Bank Account Details</h3>
        <p class="text-subtitle text-muted">Enter your bank account details to verify your eligibility</p>
    </div>


 <section class="section mt-5">
    <div class="col-md-6 col-12 mx-auto">
        <div class="card">
            <div class="card-content">
            <div class="card-body">
                 <form id="accout_details_form" class="needs-validation">

                    <div class="form-group basic animated">
                        <div class="input-wrapper">
                            <label class="label" for="account_name">Account Name</label>
                            <input type="text" class="form-control" id="account_name" placeholder="Enter bank account name" required>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                            <div class="valid-feedback">Looks good!</div>
                            <div class="invalid-feedback">Please enter account name.</div>
                        </div>
                    </div>
                    <div class="form-group basic animated">
                        <div class="input-wrapper">
                            <label class="label" for="account_no">Account Number</label>
                            <input type="text" class="form-control" id="account_no" placeholder="Enter account number" required>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                            <div class="valid-feedback">Looks good!</div>
                            <div class="invalid-feedback">Please enter account number.</div>
                        </div>
                    </div>
                    <div class="form-group basic animated">
                        <div class="input-wrapper">
                        
                            <select class="form-control custom-select" name="bank_name" id="bank_name" required>
                                <option selected disabled value="">Choose Bank Name...</option>
                                <!-- <option value="1">First Bnak</option>
                                <option value="2">Access Bank</option>
                                <option value="3">GTBank</option> -->
                            </select>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                            <div class="valid-feedback">Looks good!</div>
                            <div class="invalid-feedback">Please enter bank code.</div>
                        </div>
                    </div>

                   

                    <div class="mt-2">
                        <button type="submit" id="submit-acc-details" class="btn btn-primary btn-block" type="submit">Submit</button>
                    </div>

                </form>

            </div>
            </div>
        </div>
        </div>
</section>   

</div>
<script type="text/javascript">
    
</script>
<?php include("includes/footer.php");?>
            

