<?php
//session_start();
include("../config/database_functions.php");
include("inc/header.php");
$admin_id =$_SESSION['admin_id'];
$admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
//$get_users_employment = get_one_row_from_one_table_by_id('user_employment_details','user_id', $user_id, 'date_created');
$get_loan_category = get_rows_from_one_table('loan_category','date_created');
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
          <h1 class="h3 mb-2 text-gray-800">Set Loan Packages</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Loan Packages</h6>
            </div>
            <div class="card-body">
              <form method="post" id="set_packages_form">
                <div class="row justify-content-center">
                  <div class="col-md-8">
                    <label>Package Category</label>
                    <select name="loan_category" class="form-control">
                      <option value="">Select a package category</option>
                      <?php
                        foreach ($get_loan_category as $value) {
                          if($value['type'] != 3){
                      ?>
                      <option value="<?php echo $value['unique_id'];?>"><?php echo $value['name'];?></option>
                          <?php }
                        }
                      ?>
                    </select>
                  </div>
                  <div class="col-md-8 mt-3">
                    <label>Number of Repayment Month</label>
                    <input type="number" name="no_of_month" class="form-control">
                  </div>
                  <div class="col-md-8 mt-3">
                    <label>Interest per Month (in percentage)</label>
                    <input type="number" name="interest_per_month" class="form-control">
                  </div>
                  <div class="col-md-8 mt-3">
                    <label>Equity Contribution (in percentage)</label>
                    <input type="number" name="equity_contribution" class="form-control" placeholder="Applicable to Asset finance only">
                  </div>
                  <div class="col-md-8 mt-3">
                    <button type="button" class="btn btn-secondary" id="set_loan_package">Create Package</button>
                  </div>
                </div>
              </form>
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
