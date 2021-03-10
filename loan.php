
<?php include("sidebar.php");?>
<div id="main">

<?php include("header.php");?>            
<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Zennal Loans</h3>
        <p class="text-subtitle text-muted">Friday, 08,January 2021</p>
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
                            <div class="col-lg-5 col-12 mt-4">
                            	<h6>TOTAL ACTIVE LOAN</h6>
                            	<h4 class="text-success ">₦20,000.00</h4>

                            	<h6>AMOUNT DUE</h6>
                            	<h4 class="text-danger">₦5,000.00</h4>
                            </div>
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
                 //if($get_loan_applications == null){
                        echo "<tr><td>No record found...</td></tr>";
                     // } else{ ?>
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

                   //foreach($get_loan_applications as $value){
                    // $get_user = get_one_row_from_one_table_by_id('users','unique_id', $value['user_id'], 'registered_on');
                     ?>
                     <tr>
                        <td><?php //echo $get_user['first_name'].' '.$get_user['last_name'];?></td>
                        <td>
                            <?php //echo $value['loan_purpose'];?>
                        </td>
                        <td>
                            <?php //echo $value['loan_interest'].'%';?>
                        </td>
                        <td>
                            &#8358;<?php// echo number_format($value['user_approved_amount'], 2);?>
                        </td>
                        <td>
                            &#8358;<?php// echo number_format($value['amount_to_repay'], 2);?>
                        </td>
                        <td>
                            <?php 
                                // if($value['approval_status'] == 0){
                                //     echo '<small class="badge badge-sm badge-primary">Pending</small>';
                                // }
                                // else if($value['approval_status'] == 1){
                                //     echo '<small class="badge badge-sm badge-success">Approved</small>';
                                // }
                                // else if($value['approval_status'] == 2){
                                //     echo '<small class="badge badge-sm badge-danger">Rejected</small>';
                                // }
                                // else if($value['approval_status'] == 3){
                                //     echo '<small class="badge badge-sm badge-warning">Ongoing</small>';
                                // }
                                // else if($value['approval_status'] == 4){
                                //     echo '<small class="badge badge-sm badge-success">Completed</small>';
                                // }
                                // else{
                                //     echo '<small class="badge badge-sm badge-danger">No status</small>';
                                // }
                            ?>
                        </td>
                        <td>
                          <?php //echo $value['date_created'];?>
                        </td>
                      </tr>
                    <?php
                     // } 
                 //} 
                 ?>
                </tbody>
              </table>
         </div>
     </div>
</section>   

</div>
<?php include("footer.php");?>
            

