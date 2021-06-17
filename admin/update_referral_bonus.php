<?php
//session_start();
include("../config/functions.php");
include("inc/header.php");
$admin_id =$_SESSION['admin_id'];
$admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
$get_referral_bonus = get_rows_from_one_table('referral_tbl','date_created');
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
          <h1 class="h3 mb-2 text-gray-800">Referral Bonus</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Update Referral Bonus</h6>
            </div>
            <div class="card-body">
              <form method="post" id="update_referral_form">
                <div class="row justify-content-center">
                  <div class="col-md-8 mt-3">
                    <label>Referral Bonus</label>
                    <select name="referral_for" class="form-control">
                      <?php
                        foreach ($get_referral_bonus as $value) {
                          ?>
                          <option class="text-capitalize" value="<?= $value['referral_for'];?>"><?= $value['referral_for'];?></option>
                        <?php
                        }
                      ?>
                    </select>
                  </div>
                  <div class="col-md-8 mt-3">
                    <label>Referral Bonus (in percentage)</label>
                    <input type="number" name="referral_bonus" class="form-control">
                  </div>
                </div>
                <div class="row justify-content-center">
                  <div class="col-md-8 mt-3">
                    <button type="button" class="btn btn-secondary" id="update_referral_btn">Update</button>
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
