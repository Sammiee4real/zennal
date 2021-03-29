<?php include("includes/sidebar.php");
    $loan_id = isset($_GET['loan_id']) ? $_GET['loan_id'] : '';
    $get_loan_application = get_one_row_from_one_table_by_id('personal_loan_application', 'unique_id', $loan_id, 'approval_status', 1, 'date_created');
    $amount = $get_loan_application['amount_to_repay'];
    if($loan_id != ""){
        $callback_url = "http://$_SERVER[HTTP_HOST]"."/new_zennal/direct_debit_callback.php?loan_id=".$loan_id;
        $redirect_url = "http://$_SERVER[HTTP_HOST]"."/new_zennal/direct_debit_callback.php?loan_id=".$loan_id;
    }
    else{
        $callback_url = "https://$_SERVER[HTTP_HOST]"."/new_zennal/direct_debit_callback";
        $redirect_url = "https://$_SERVER[HTTP_HOST]"."/new_zennal/direct_debit_callback";
    }
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

      
<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Direct Debit Confirmation</h3>
        <p class="text-subtitle text-muted">Confirm you want your account to be debited after one month</p>
    </div>


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
                    Please click the button below to confirm that your account should be debited after one month<br><br>
                    <button onclick="connectViaOptions2()" class="btn btn-primary btn-sm">Direct Debit Confirmation</button>
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
            limit: '6',
            // payment: true,
            debitLater: true,
            debitAmount: '<?php echo $amount;?>', // optional kobo amount 
            debitType: 'recurring',
            currency: 'NGN',
            corporate: null,
            connectMessage: 'Which account do you want to connect with?',
            products: ["auth", "transactions", "balance"],
            //callback_url: 'http://zennal.staging.cloudware.ng/okra_callback.php',
            callback_url: '<?php echo $callback_url;?>',
            //redirect_url: 'http://getstarted.naicfund.ng/zennal_redirect.php',
            logo: 'https://cloudware.ng/wp-content/uploads/2019/12/CloudWare-Christmas-Logo.png',
            filter: {
                banks: [],
                industry_type: 'all',
            },
            widget_success: 'Your account was successfully linked to Cloudware Technologies',
            widget_failed: 'An unknown error occurred, please try again.',
            // currency: 'NGN',
            exp: null,
            success_title: 'Cloudware Technologies!',
            success_message: 'You are doing well!',
            onSuccess: function (data) {
                console.log('success', data);
                window.location.href = '<?php echo $redirect_url;?>';
            },
            onClose: function () {
                console.log('closed')
            }
        })
    } 
</script>
