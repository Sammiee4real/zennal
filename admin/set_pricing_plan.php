<?php
//session_start();
include("../config/database_functions.php");
include("inc/header.php");
$admin_id =$_SESSION['admin_id'];
$admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
//$get_users_employment = get_one_row_from_one_table_by_id('user_employment_details','user_id', $user_id, 'date_created');
//$get_loan_category = get_rows_from_one_table('loan_category','date_created');
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
          <h1 class="h3 mb-2 text-gray-800">Set Insurance Pricing Plan</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Insurance Pricing Plan</h6>
            </div>
            <div class="card-body">
              <form method="post" id="set_pricing_plan_form">
                <div class="row justify-content-center">
                  <div class="col-md-8 mt-3">
                    <label>Pricing Plan</label>
                    <input type="text" name="pricing_type" class="form-control">
                  </div>
                  <div class="col-md-8 mt-3">
                    <label>Plan Description</label>
                    <textarea class="form-control" name="plan_description" rows="5"></textarea>
                  </div>
                  <div class="col-md-8 mt-3">
                    <label>Plan Price</label>
                    <input type="number" name="plan_price" class="form-control">
                  </div>
                   <div class="col-md-8 mt-3">
                    <button type="button" class="btn btn-secondary" id="set_pricing_plan">Create Plan</button>
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
