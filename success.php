<?php include("includes/sidebar.php");
     $get_loan_time =  get_one_row_from_one_table_by_id('loan_time_frame','type', 'loan', 'date_created');
?>
<div id="main">

<?php include("includes/header.php");?>            
<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Successful Loan Application</h3>
        <p class="text-subtitle text-muted"><br></p>
    </div>

    <img src="assets/images/form-bg.png" width="100%" height="200px">

<section class="section mt-5">
<div class="col-md-8 col-sm-12 mx-auto">
            <div class="card pt-4">
                <div class="card-body">

                   <p class="text-center">Thank you for choosing Zennal</p>

<p class="text-justify">We are pleased to inform you that your loan application has been received and we are currently working on it. 
Please check your mail often as a mail will be sent to you to inform you about the status of your application. </p>

<p class="text-center" style="color: blue;">We will contact you in about <?= $get_loan_time['time_frame'].' hours';?></p>

<p class="text-center">Please contact us in case you need more information. Thanks.</p>
                </div>
            </div>
        </div>
</section>

    

</div>
<?php include("includes/footer.php");?>
            

