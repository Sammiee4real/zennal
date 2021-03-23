<?php
//session_start();
include("../config/database_functions.php");
include("inc/header.php");
$admin_id =$_SESSION['admin_id'];
$admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
$get_loan_packages = get_rows_from_one_table('loan_packages','date_created');
$get_loan_categories = get_rows_from_one_table('loan_category','date_created');
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
          <h1 class="h3 mb-2 text-gray-800">Loan Packages</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                   <thead class="thead-light">
                 <?php if($get_loan_packages == null){
                        echo "<tr><td>No record found...</td></tr>";
                      } else{ ?>
                  <tr>
                    
                    <th scope="col">Loan Category</th>
                    <th scope="col">Number of Repayment Month</th>
                    <th scope="col">Interest per Month</th>
                    <th scope="col">Date Created</th>
                    <th>Action</th>

                  </tr>
                </thead>
                <tbody>
                  <?php

                   foreach($get_loan_packages as $value){
                    $get_loan_category = get_one_row_from_one_table_by_id('loan_category','unique_id',$value['loan_category'], 'date_created');
                     ?>
                     <tr>
                        <td><?php echo $get_loan_category['name'];?></td>
                        <td>
                            <?php echo $value['no_of_month'].' month (s)';?>
                        </td>
                        <td>
                            <?php echo $value['interest_per_month'].' %';?>
                        </td>
                        <td>
                          <?php echo $value['date_created'];?>
                        </td>
                        <td>
                          <button class="btn btn-primary btn-sm edit_package" type="button" id="<?php echo $value['unique_id'];?>" data-month="<?php echo $value['no_of_month'];?>" data-interest="<?php echo $value['interest_per_month'];?>">Edit</button>
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
                  <h5 class="modal-title">Edit Package</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="post" id="edit_package_form">
                    <div class="row justify-content-center">
                      <div class="col-md-10">
                        <label>Package Category</label>
                        <select name="loan_category" class="form-control">
                          <option value="">Select a package category</option>
                          <?php
                            foreach ($get_loan_categories as $value) {
                              if($value['type'] != 3){
                          ?>
                          <option value="<?php echo $value['unique_id'];?>"><?php echo $value['name'];?></option>
                              <?php }
                            }
                          ?>
                        </select>
                      </div>
                      <div class="col-md-10 mt-3">
                        <label>Number of Repayment Month</label>
                        <input type="number" name="no_of_month" id="no_of_month" class="form-control">
                      </div>
                      <div class="col-md-10 mt-3">
                        <label>Interest per Month (in percentage)</label>
                        <input type="number" name="interest_per_month" id="interest_per_month" class="form-control">
                      </div>
                    </div>
                    <input type="hidden" name="package_id"  id="package_id" value="">
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" id="edit_package_btn">Edit</button>
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
      $(".edit_package").click(function(){
        $("#modal").modal('show');
        let package_id = $(this).attr('id');
        let package_month = $(this).data('month');
        let package_interest = $(this).data('interest');
        //console.log(id);
        $("#package_id").val(package_id);
        $("#no_of_month").val(package_month);
        $("#interest_per_month").val(package_interest);
      });
      $(".enable_user_modal").click(function(){
        $("#modal2").modal('show');
        let package_id = $(this).attr('id');
        //console.log(id);
        $("#package_id2").val(package_id);
      });
    });
  </script>
</body>

</html>