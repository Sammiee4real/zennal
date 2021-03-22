<?php
//session_start();
include("../config/database_functions.php");
include("inc/header.php");
$admin_id =$_SESSION['admin_id'];
$admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
$get_users = get_rows_from_one_table('users','registered_on');
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
          <h1 class="h3 mb-2 text-gray-800">Users' Personal Details</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Fullname</th>
                      <th>Date of Birth</th>
                      <th>Email Address</th>
                      <th>Phone Number</th>
                      <th>Gender</th>
                      <th>Registration Date</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      if($get_users == null){
                        echo "No user available";
                      }else{
                        foreach ($get_users as $value) {
                    ?>
                    <tr>
                      <td><?php echo $value['first_name'].' '.$value['last_name'].' '.$value['other_names'];?></td>
                      <td class="text-capitalize"><?php echo $value['address'];?></td>
                      <td class="text-capitalize"><?php echo $value['dob'];?></td>
                      <td><?php echo $value['email'];?></td>
                      <td class="text-capitalize"><?php echo $value['phone'];?></td>
                      <td class="text-capitalize"><?php echo $value['gender'];?></td>
                      <td class="text-capitalize"><?php echo $value['marital_status'];?></td>
                      <td class="text-capitalize"><?php echo $value['employment_status'];?></td>
                      <td class="text-capitalize"><?php echo $value['registered_on'];?></td>
                      <td>
                        <div class="dropdown">
                          <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            View Details
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="view_employment_details.php?user_id=<?php echo $value['unique_id']?>">Employment Details</a>
                            <a class="dropdown-item" href="view_financial_details.php?user_id=<?php echo $value['unique_id']?>">Financial Details</a>
                          </div>
                        </div>
                      </td>
                    </tr>
                  <?php } }?>
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
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2020</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <?php include("inc/scripts.php");?>
</body>

</html>
