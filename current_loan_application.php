<?php include("includes/sidebar.php");
    $get_loan_application = get_one_row_from_one_table_by_two_params('personal_loan_application', 'user_id', $user_id, 'approval_status', 1, 'date_created');
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
        <h3>Approved Loan Applications</h3>
        <p class="text-subtitle text-muted">Check if your loan has been approved</p>
    </div>


    <section class="section mt-5">
        <div class="col-md-8 col-sm-12 mx-auto">
            <div class="card">
                <div class="card-body">
                    <?php
                        if($get_loan_application == null){
                            echo "You do not have any approved loan";
                        }else{
                    ?>
                    <div class="mt-3"><span class="font-weight-bold">Loan Purpose:</span> <?php echo $get_loan_application['loan_purpose'];?><div>
                    <div class="mt-3"><span class="font-weight-bold">Requested Amount: </span>&#8358;<?php echo number_format($get_loan_application['user_selection_amount']);?></div>
                    <div class="mt-3"><span class="font-weight-bold">Minimun Approved Amount: </span>&#8358;<?php echo number_format($get_loan_application['admin_selection_amount_min']);?></div>
                    <div class="mt-3"><span class="font-weight-bold">Maximum Approved Amount: </span>&#8358;<?php echo number_format($get_loan_application['admin_selection_amount_max']);?></div>
                    <div class="mt-3"><span class="font-weight-bold">Interest Rate: </span><?php echo $get_loan_application['loan_interest'].'%';?></div>
                    <form action="" method="post" id="submit_loan_application_form">
                        <div class="form-group boxed mt-3">
                            <div class="input-wrapper">
                                <label class="label" for="city5">Preferred Amount</label>
                                <input type="text" class="form-control" id="user_approved_amount" name="user_approved_amount" placeholder="Input your preferred amount between the specified range" value="">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>
                        <input type="hidden" name="loan_id" id="loan_id" value="<?php echo $get_loan_application['unique_id'];?>">
                       
                        <div class="mt-3 mb-3">
                            <button type="button" class="btn btn-primary btn-block" id="submit_loan_application" name="submit_loan_application">Submit</button>
                        </div>

                     </form>
                 <?php }?>
                </div>
            </div>
        </div>
    </section>   

</div>
<?php include("includes/footer.php");?>
