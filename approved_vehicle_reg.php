<?php include("includes/sidebar.php");
    $get_loan_application = get_one_row_from_one_table_by_two_params('vehicle_reg_installment', 'user_id', $user_id, 'approval_status', 1, 'date_created');
    $get_installment_details = get_rows_from_one_table('installment_payment_interest','date_created');
    $equity_contribution = (30/100) * $get_loan_application['total'];
    $amount_to_borrow = $get_loan_application['total'] - $equity_contribution;
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
        <h3>Approved Installment Payment</h3>
        <p class="text-subtitle text-muted">Check if your installment payment has been approved</p>
    </div>


    <section class="section mt-5">
        <div class="col-md-10 col-sm-12 mx-auto">
            <div class="card">
                <div class="card-body">
                    <?php
                      if($get_loan_application == null){
                        echo "You do not have any approved installmental payment";
                      }else{
                    ?>
                <h5>INSTALLMENT DETAILS</h5>
                    <small class="font-weight-bold">You are to pay 30% equity charge for any installment plan chosen</small><br><br>
                    Total Amount: <span class="ml-3 font-weight-bold" style="font-size: 20px">&#8358;<?= number_format($get_loan_application['total']);?></span><br>
                    Equity Contribution: <span class="ml-3 font-weight-bold" style="font-size: 20px">&#8358;<?= number_format($equity_contribution);?></span><br>
                    Amount to borrow: <span class="ml-3 font-weight-bold" style="font-size: 20px">&#8358;<?= number_format($amount_to_borrow);?></span><br>
                    <div class="table-responsive" style="background-color: #e8f3ff; padding: 15px;">
                      <table class="table mb-0">
                        <thead>
                          <tr>
                            <th>Number of month</th>
                            <th>Interest Rate (per month)</th>
                            <th>Total amount to repay</th>
                            <th>Amount to pay per month</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            if($get_installment_details != null){
                              foreach ($get_installment_details as $details) {
                               $calculate_repayment_details = calculate_repayment_details($amount_to_borrow, $details['unique_id']);
                               $calculate_repayment_details_decode = json_decode($calculate_repayment_details, true);
                               $total_amount_to_pay = $calculate_repayment_details_decode['total_amount_to_pay'];
                               $amount_to_pay_per_month = $calculate_repayment_details_decode['amount_to_pay_per_month'];
                          ?>
                          
                            <tr>
                              <td class="text-bold-500 text-blue"><?=$details['no_of_month']?></td>
                              <td><?=$details['interest_rate'].'%'?></td>
                              <td>&#8358;<?= number_format($total_amount_to_pay, 2);?></td>
                              <td>&#8358;<?= number_format($amount_to_pay_per_month, 2);?></td>
                              <td class="text-bold-500 text-dark">
                                <button type="button" id="<?php echo $details['unique_id'];?>" class="btn btn-primary btn-sm proceed_to_payment_btn">Proceed</button>
                                <input type="hidden" name="unique_id" id="unique_id" value="<?= $get_loan_application['unique_id'];?>">
                              </td>
                            </tr>
                          <?php } } }?>
                        </tbody>
                      </table>
                    </div>
        </div>
    </section>   

</div>
<?php include("includes/footer.php");?>
<script>
    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }
</script>
