<?php
//session_start();
include("../config/functions.php");
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
                      <th>Address</th>
                      <th>Date of Birth</th>
                      <th>Email Address</th>
                      <th>Phone Number</th>
                      <th>Gender</th>
                      <th>Marital Status</th>
                      <th>Employment Status</th>
                      <th>Registration Date</th>
                      <th scope="col">Action</th>
                      <th></th>
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
                            <i class="fas fa-eye"></i> View Details
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="view_employment_details.php?user_id=<?php echo $value['unique_id']?>">Employment Details</a>
                            <a class="dropdown-item" href="view_financial_details.php?user_id=<?php echo $value['unique_id']?>">Financial Details</a>
                          </div>
                        </div>
                      </td>
                      <td>
                        <?php if($value['status'] == 1){?>
                        <button class="btn btn-danger btn-sm disable_user_modal" type="button" id="<?php echo $value['unique_id'];?>">Disable</button>
                      <?php } else if($value['status'] == 0){?>
                        <button class="btn btn-primary btn-sm enable_user_modal" type="button" id="<?php echo $value['unique_id'];?>">Enable</button>
                      <?php }?>
                      </td>
                    </tr>
                  <?php } }?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="modal" tabindex="-1" role="dialog" id="modal">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Disable User</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Are you sure you want to disable this user?</p>
                  <form method="post" id="disable_user_form">
                    <input type="hidden" name="user_id"  id="user_id" value="">
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" id="disable_user">Yes</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

          <div class="modal" tabindex="-1" role="dialog" id="modal2">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Enable User</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Are you sure you want to enable this user?</p>
                  <form method="post" id="enable_user_form">
                    <input type="hidden" name="user_id"  id="user_id2" value="">
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" id="enable_user">Yes</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
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
