<?php
//session_start();
include("../config/functions.php");
include("inc/header.php");
$admin_id = $_SESSION['admin_id'];
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
          <h1 class="h3 mb-2 text-gray-800">Time Frame</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Add Time Frame</h6>
            </div>
            <div class="card-body">
              <form method="post" id="add_time_frame_form" enctype="multipart/form-data">
                <div class="row justify-content-center">
                  <div class="col-md-8 mt-3">
                    <label>Time Frame (in hours)</label>
                    <input type="text" name="time_frame" class="form-control">
                  </div>
                   <div class="col-md-8 mt-3">
                    <button type="button" class="btn btn-secondary" id="add_time_frame">Submit</button>
                  </div>
                </div>
              </form>
            </div>
          </div>

        </div>

      </div>
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
