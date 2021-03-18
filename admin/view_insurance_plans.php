<?php
//session_start();
include("../config/database_functions.php");
include("inc/header.php");
$admin_id =$_SESSION['admin_id'];
$admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
$get_insurance_plans = get_rows_from_one_table('insurance_packages','date_created');
// $get_loan_categories = get_rows_from_one_table('loan_category','date_created');
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
          <h1 class="h3 mb-2 text-gray-800">Insurance Packages</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                   <thead class="thead-light">
                 <?php if($get_insurance_plans == null){
                        echo "<tr><td>No record found...</td></tr>";
                      } else{ ?>
                  <tr>
                    
                    <th scope="col">Package Name</th>
                    <th scope="col">Date Created</th>
                    <th>Action</th>

                  </tr>
                </thead>
                <tbody>
                  <?php

                   foreach($get_insurance_plans as $value){
                     ?>
                     <tr>
                        <td><?php echo $value['package_name'];?></td>
                        <td>
                          <?php echo $value['date_created'];?>
                        </td>
                        <td>
                          <button class="btn btn-primary btn-sm edit_insurance_plan" type="button" id="<?php echo $value['unique_id'];?>" data-name="<?php echo $value['package_name'];?>">Edit</button>
                        </td>
                      </tr>
                    <?php } } ?>
                </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="modal" tabindex="-1" role="dialog" id="modal">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Edit Insurance</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="post" id="edit_insurance_plan_form">
                    <div class="row justify-content-center">
                      <div class="col-md-10 mt-3">
                        <label>Package Name</label>
                        <input type="text" name="package_name" id="package_name" class="form-control">
                      </div>
                    </div>
                    <input type="hidden" name="package_id"  id="package_id" value="">
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" id="edit_insurance_plan_btn">Edit</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
      $(".edit_insurance_plan").click(function(){
        $("#modal").modal('show');
        let package_id = $(this).attr('id');
        let package_name = $(this).data('name');
        // console.log(package_name);
        $("#package_id").val(package_id);
        $("#package_name").val(package_name);
      });
    });
  </script>
</body>

</html>
