<?php
//session_start();
include("../config/functions.php");
include("inc/header.php");
$admin_id =$_SESSION['admin_id'];
$admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
$get_loan_applications = get_rows_from_one_table('user_loan_details','date_created');
?>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Sidebar -->
    <?php include("inc/sidebar.php");?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
        <?php include("inc/topnav.php");?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Loan Applications</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                  <thead class="thead-light">
                 <?php if($get_loan_applications == null){
                        echo "<tr><td>No record found...</td></tr>";
                      } else{ ?>
                  <tr>
                    
                    <th scope="col">Fullname</th>
                    <th scope="col">Type of Loan</th>
                    <th scope="col">Repayment Plan</th>
                    <th scope="col">Loan Amount</th>
                    <th scope="col">Purpose of Loan</th>
                    <th scope="col">Number of Repayment Month</th>
                    <th scope="col">Current Repayment Month</th>
                    <th scope="col">Loan Status</th>
                    <th scope="col">Amount Repaid</th>
                    <th scope="col">Interest per month</th>
                    <th scope="col">Transaction Status</th>
                    <th scope="col">Date of Application</th>

                  </tr>
                </thead>
                <tbody>
                  <?php

                   foreach($get_loan_applications as $value){
                    $get_user = get_one_row_from_one_table_by_id('users','unique_id', $value['user_id'], 'registered_on');
                    $get_loan_type = get_one_row_from_one_table_by_id('loan_category','unique_id',$value['loan_category_id'], 'date_created');
                    $get_loan_package = get_one_row_from_one_table_by_id('loan_packages','unique_id',$value['loan_package_id'], 'date_created');
                     ?>
                     <tr>
                        <td><?php echo $get_user['first_name'].' '.$get_user['last_name'];?></td>
                        <td>
                            <?php echo $get_loan_type['name'];?>
                        </td>
                        <td>
                            <?php echo $get_loan_package['no_of_month'].' month(s) Repayment Plan';?>
                        </td>
                        <td>
                            &#8358;<?php echo number_format($value['loan_amount'], 2);?>
                        </td>
                        <td>
                            <?php echo $value['purpose_of_loan'];?>
                        </td>
                        <td>
                            <?php echo $value['no_of_repayment_month'].' month(s)';?>
                        </td>
                        <td>
                            <?php echo $value['current_repayment_month'];?>
                        </td>
                        <td>
                            <?php 
                                if($value['no_of_repayment_month'] > $value['current_repayment_month']){
                                    echo '<small class="badge badge-sm badge-primary">Ongoing</small>';
                                }else{
                                    echo '<small class="badge badge-sm badge-success">Completed</small>';
                                }
                            ?>
                        </td>
                        <td>
                            &#8358;<?php echo number_format($value['total_amount_to_repay'], 2);?>
                        </td>
                        <td>
                          <?php echo $value['interest_per_month'].'%';?>
                        </td>
                        <td>
                            <?php 
                                if($value['transaction_status'] == NULL || $value['transaction_status'] == 0){
                                    echo '<small class="badge badge-sm badge-danger">Failed/Canceled</small>';
                                }else if($value['transaction_status'] == 1){
                                    echo '<small class="badge badge-sm badge-success">Successful</small>';
                                }
                            ?>
                        </td>
                        <td>
                          <?php echo $value['date_created'];?>
                        </td>
                      </tr>
                    <?php } } ?>
                </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
        <?php include("inc/footer.php");?>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <?php include("inc/scripts.php");?>
  <script>
    $(document).ready(function(){
      $(".disable_user_modal").click(function(){
        $("#modal").modal('show');
        let user_id = $(this).attr('id');
        //console.log(id);
        $("#user_id").val(user_id);
      });
      $(".enable_user_modal").click(function(){
        $("#modal2").modal('show');
        let user_id = $(this).attr('id');
        //console.log(id);
        $("#user_id2").val(user_id);
      });
    });
  </script>
</body>

</html>
