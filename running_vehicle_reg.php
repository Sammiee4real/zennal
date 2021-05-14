<?php include("includes/sidebar.php");
    // $user_id = $_SESSION['user_id'];
    // $user_id = '07bf739aba673b233f89d1a25821870d';
    $get_loan_applications = get_rows_from_one_table_by_two_params('vehicle_reg_installment','user_id',$user_id, 'approval_status', 3);
?>
<div id="main">

<?php include("includes/header.php");?>            
<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Running Installment Payment</h3>
        <p class="text-subtitle text-muted"><?= date("l, d, F, Y ")?></p>
    </div>

  <!--   <div class="page-title mt-5">
        <p class="text-subtitle text-muted">LOAN HISTORY</p>
    </div> -->

 <section class="section">
        <div class="card">
            <div class="card-header">
                
            </div>
            <div class="card-body">
                <table class='table table-striped table-responsive' id="myTable">
                    <thead class="thead-light">
                 <?php 
                    if($get_loan_applications == null){
                        echo "<tr><td>No record found...</td></tr>";
                    } else{ ?>
                  <tr>
                    
                    <th scope="col">Fullname</th>
                    <th>Type</th>
                    <th scope="col">Loan Amount</th>
                    <th scope="col">Loan Interest (per month)</th>
                    <th>Number of Repayment</th>
                    <th scope="col">Amount To repay</th>
                    <th scope="col">Amount Deducted per month</th>
                    <th scope="col">Date of Application</th>

                  </tr>
                </thead>
                <tbody>
                  <?php

                   foreach($get_loan_applications as $value){
                    $get_user = get_one_row_from_one_table_by_id('users','unique_id', $value['user_id'], 'registered_on');
                    $get_interest_rate = get_one_row_from_one_table('installment_payment_interest', 'unique_id', $value['installment_id']);
                    $equity_contribution = (30/100) * $value['total'];
                    $interest_per_month = $value['interest_per_month'];
                    $total_amount_to_repay = $value['amount_to_repay'];
                    $amount_deducted_per_month = $value['amount_deducted_per_month'];
                    $amount_to_borrow = $value['total'] - $equity_contribution;
                    $no_of_repayment = $get_interest_rate['no_of_month'];
                     ?>
                     <tr>
                        <td><?php echo $get_user['first_name'].' '.$get_user['last_name'];?></td>
                        <td>
                            <?php echo 'Vehicle Registration';?>
                        </td>
                        <td>
                            &#8358;<?php echo number_format($amount_to_borrow, 2);?>
                        </td>
                        <td>
                            &#8358;<?php echo number_format($interest_per_month, 2);?>
                        </td>
                        <td>
                            <?php echo $no_of_repayment;?>
                        </td>
                        <td>
                            &#8358;<?php echo number_format($total_amount_to_repay, 2);?>
                        </td>
                        <td>
                            &#8358;<?php echo number_format($amount_deducted_per_month, 2);?>
                        </td>
                        <td>
                          <?php echo $value['date_created'];?>
                        </td>
                      </tr>
                    <?php
                     } 
                    } 
                 ?>
                </tbody>
              </table>
         </div>
     </div>
</section>   

</div>
<?php include("includes/footer.php");?>
            

