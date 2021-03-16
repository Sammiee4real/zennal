<?php include("includes/sidebar.php");
    // $user_id = $_SESSION['user_id'];
    // $user_id = '07bf739aba673b233f89d1a25821870d';
    $get_user_running_loan = get_one_row_from_one_table_by_two_params('user_loan_details','user_id',$user_id,'loan_status','1', 'date_created');
    $get_loan_applications = get_rows_from_one_table_by_id('personal_loan_application','user_id',$user_id, 'date_created');
    $total_loan = get_total_loan($user_id);
?>
<div id="main">

<?php include("includes/header.php");?>            
<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Zennal Loans</h3>
        <p class="text-subtitle text-muted"><?= date("l, d, F, Y ")?></p>
    </div>

<section class="section mt-5">
<div class="col-xl-5 col-md-5 col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="row no-gutters">
                            <div class="col-lg-7 col-12">
                                <div class="card-body">
                                    <p class="card-text text-ellipsis">
                                       Apply for you loan, enter all your details to get approval.
                                    </p>
                                    <a href="apply_loan.php"><button class="btn btn-info">APPLY FOR LOAN</button></a>
                                </div>
                            </div>
                            <?php
                                if($get_user_running_loan != null){
                                    echo '
                                        <div class="col-lg-5 col-12 mt-4">
                                            <h6>TOTAL ACTIVE LOAN</h6>
                                            <h4 class="text-success ">&#8358;'.number_format($total_loan).'</h4>

                                            <h6>AMOUNT DUE</h6>
                                            <h4 class="text-danger">&#8358;'.number_format($get_user_running_loan['amount_deducted_per_month'], 2).'</h4>
                                        </div>
                                    ';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
</section>

    <div class="page-title mt-5">
        <p class="text-subtitle text-muted">LOAN HISTORY</p>
    </div>

 <section class="section">
        <div class="card">
            <div class="card-header">
                
            </div>
            <div class="card-body">
                <table class='table table-striped' id="myTable">
                    <thead class="thead-light">
                 <?php 
                    if($get_loan_applications == null){
                        echo "<tr><td>No record found...</td></tr>";
                    } else{ ?>
                  <tr>
                    
                    <th scope="col">Fullname</th>
                    <th scope="col">Loan Purpose</th>
                    <th scope="col">Loan Interest</th>
                    <th scope="col">Approved Amount</th>
                    <th scope="col">Amount To repay</th>
                    <th scope="col">Loan Status</th>
                    <th scope="col">Date of Application</th>

                  </tr>
                </thead>
                <tbody>
                  <?php

                   foreach($get_loan_applications as $value){
                    $get_user = get_one_row_from_one_table_by_id('users','unique_id', $value['user_id'], 'registered_on');
                     ?>
                     <tr>
                        <td><?php echo $get_user['first_name'].' '.$get_user['last_name'];?></td>
                        <td>
                            <?php echo $value['loan_purpose'];?>
                        </td>
                        <td>
                            <?php echo $value['loan_interest'].'%';?>
                        </td>
                        <td>
                            &#8358;<?php echo number_format($value['user_approved_amount'], 2);?>
                        </td>
                        <td>
                            &#8358;<?php echo number_format($value['amount_to_repay'], 2);?>
                        </td>
                        <td>
                            <?php 
                                if($value['approval_status'] == 0){
                                    echo '<span class="badge bg-primary">Pending</span>';
                                }
                                else if($value['approval_status'] == 1){
                                    echo '<span class="badge badge-success">Approved</small>';
                                }
                                else if($value['approval_status'] == 2){
                                    echo '<span class="badge bg-danger">Rejected</small>';
                                }
                                else if($value['approval_status'] == 3){
                                    echo '<span class="badge bg-warning">Ongoing</small>';
                                }
                                else if($value['approval_status'] == 4){
                                    echo '<span class="badge badge-success">Completed</small>';
                                }
                                else{
                                    echo '<span class="badge bg-danger">No status</small>';
                                }
                            ?>
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
            

