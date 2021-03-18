<?php
//session_start();
include("../config/database_functions.php");
include("inc/header.php");
$admin_id =$_SESSION['admin_id'];
$user_id = $_GET['user_id'];
$admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
$get_users_employment = get_one_row_from_one_table_by_id('user_employment_details','user_id', $user_id, 'date_created');
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
          <h1 class="h3 mb-2 text-gray-800">User's Employment Details</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Employment Details</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Name of Organization</th>
                      <th>Contact Address of Organization</th>
                      <th>Job Title</th>
                      <th>Employment Type</th>
                      <th>Employment Duration</th>
                      <th>Years of Experience</th>
                      <th>Industry Type</th>
                      <th>Monthly Salary</th>
                      <th>Salary Payday</th>
                      <th>Official Email Address</th>
                      <th>Date Created</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      if($get_users_employment == null){
                        echo "No employment details yet";
                      }else{
                    ?>
                    <tr>
                      <td><?php echo $get_users_employment['name_of_organization'];?></td>
                      <td class="text-capitalize"><?php echo $get_users_employment['contact_address_of_organization'];?></td>
                      <td class="text-capitalize"><?php echo $get_users_employment['job_title'];?></td>
                      <td class="text-capitalize"><?php echo $get_users_employment['employment_type'];?></td>
                      <td class="text-capitalize"><?php echo $get_users_employment['employment_duration'];?></td>
                      <td class="text-capitalize"><?php echo $get_users_employment['years_of_experience'].' years';?></td>
                      <td class="text-capitalize"><?php echo $get_users_employment['industry_type'];?></td>
                      <td>&#8358;<?php echo number_format($get_users_employment['monthly_salary']);?></td>
                      <td class="text-capitalize"><?php echo $get_users_employment['salary_payday'];?></td>
                     <td><?php echo $get_users_employment['official_email_address'];?></td>
                     <td><?php echo $get_users_employment['date_created'];?></td>
                    </tr>
                  <?php }?>
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
