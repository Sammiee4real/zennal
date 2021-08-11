<?php
//session_start();
include("../config/functions.php");
include("inc/header.php");
$admin_id =$_SESSION['admin_id'];
$admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
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
          <h1 class="h3 mb-2 text-gray-800">Running Installment Payment</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Users Running Installment Payment</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class='table table-striped' id="running_inst_loans_tbl">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col">S/N</th>
                      <th scope="col">Fullname</th>
                      <th>Type</th>
                      <th scope="col">Loan Amount</th>
                      <th scope="col">Loan Interest (per month)</th>
                      <th>Number of Repayment</th>
                      <th>Current Number of Repayment</th>
                      <th scope="col">Amount To repay</th>
                      <th scope="col">Amount Deducted per month</th>
                      <th scope="col">Date of Application</th>
                    </tr>
                  </thead>
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
</body>

</html>
