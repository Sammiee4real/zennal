<?php include("includes/sidebar.php");
  $unique_id = isset($_GET['unique_id']) ? $_GET['unique_id'] : '';
  $get_details = get_one_row_from_one_table('vehicle_reg_installment', 'unique_id', $unique_id);
  $get_interest_rate = get_one_row_from_one_table('installment_payment_interest', 'unique_id', $get_details['installment_id']);
  $interest_rate = $get_interest_rate['interest_rate'];
  $equity_contribution = (30/100) * $get_details['total'];
  $interest_per_month = $get_details['interest_per_month'];
  $total_amount_to_repay = $get_details['amount_to_repay'];
  $amount_deducted_per_month = $get_details['amount_deducted_per_month'];
  $amount_to_borrow = $get_details['total'] - $equity_contribution;
    //$balance = $get_details['total'] - $equity_contribution;
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
        <h3>Repayment Details</h3>
        <p class="text-subtitle text-muted">Check your repayment details</p>
    </div>


    <section class="section mt-5">
        <div class="col-md-8 col-sm-12 mx-auto">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive" style="background-color: #e8f3ff; padding: 15px;">
                        <table class="table mb-0">
                          <tr>
                            <td>Total Amount</td>
                            <td></td>
                            <td><span class="ml-3 font-weight-bold" style="font-size: 16px">&#8358;<?= number_format($get_details['total'], 2);?></span></td>
                          </tr>
                          <tr>
                            <td>Equity Contribution</td>
                            <td></td>
                            <td><span class="ml-3 font-weight-bold" style="font-size: 16px">&#8358;<?= number_format($equity_contribution, 2);?></span></td>
                          </tr>
                          <tr>
                            <td>Amount to borrow</td>
                            <td></td>
                            <td><span class="ml-3 font-weight-bold" style="font-size: 16px">&#8358;<?= number_format($amount_to_borrow, 2);?></span></td>
                          </tr>
                          <tr>
                            <td>Interest Rate</td>
                            <td></td>
                            <td><span class="ml-3 font-weight-bold" style="font-size: 16px"><?= number_format($interest_rate).'%';?></span></td>
                          </tr>
                          <tr>
                            <td>Interest per Month</td>
                            <td></td>
                            <td><span class="ml-3 font-weight-bold" style="font-size: 16px">&#8358;<?= number_format($interest_per_month, 2);?></span></td>
                          </tr>
                          <tr>
                            <td>Total Amount to repay</td>
                            <td></td>
                            <td><span class="ml-3 font-weight-bold" style="font-size: 16px">&#8358;<?= number_format($total_amount_to_repay, 2);?></span></td>
                          </tr>
                          <tr>
                            <td>Amount to be deducted per month</td>
                            <td></td>
                            <td><span class="ml-3 font-weight-bold" style="font-size: 16px">&#8358;<?= number_format($amount_deducted_per_month, 2);?></span></td>
                          </tr>
                        </table>
                        <a href="okra_debit_confirmation2?unique_id=<?php echo $unique_id?>" class="btn btn-primary btn-sm mt-3 float-right">Proceed</a>
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
