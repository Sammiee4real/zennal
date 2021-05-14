<?php
//session_start();
include("../config/functions.php");
include("inc/header.php");
$admin_id =$_SESSION['admin_id'];
$admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
$get_loan_applications = get_rows_from_one_table_by_id('personal_loan_application','approval_status', 3 , 'date_created');
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
          <h1 class="h3 mb-2 text-gray-800">Running Loan</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Users Running Loan</h6>
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
</body>

</html>
