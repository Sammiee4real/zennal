<?php
//session_start();
include("../config/functions.php");
include("inc/header.php");
$admin_id =$_SESSION['admin_id'];
$user_id = $_GET['user_id'];
$admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
$get_users_financial = get_one_row_from_one_table_by_id('user_financial_details','user_id', $user_id, 'date_created');
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
          <h1 class="h3 mb-2 text-gray-800">User's Financial Details</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Financial Details</h6>
              <span class="float-right">
                <a href="view_personal_details" role="button" class="btn btn-sm btn-primary">
                  <i class="fa fa-arrow-left"></i> Go Back
                </a>
              </span>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Bank Name</th>
                      <th>Account Number</th>
                      <th>Account Name</th>
                      <th>Account Type</th>
                      <th>BVN</th>
                      <th>Existing Loan</th>
                      <th>Monthly Repayment</th>
                      <th>Date Created</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      if($get_users_financial == null){
                        echo "No employment details yet";
                      }else{
                        $get_bank_name = get_bank_name($get_users_financial['bank_name']);
                        $get_bank_name_decode = json_decode($get_bank_name, true);
                        $bank_name = $get_bank_name_decode['bankname'];
                        if($get_users_financial['existing_loan'] == 1){
                          $existing_loan = 'Yes';
                        }else{
                          $existing_loan = 'No';
                        }
                    ?>
                    <tr>
                      <td><?php echo $bank_name;?></td>
                      <td class="text-capitalize"><?php echo $get_users_financial['account_number'];?></td>
                      <td class="text-capitalize"><?php echo $get_users_financial['account_name'];?></td>
                      <td class="text-capitalize"><?php echo $get_users_financial['account_type'];?></td>
                      <td class="text-capitalize"><?php echo $get_users_financial['bvn'];?></td>
                      <td class="text-capitalize"><?php echo $existing_loan;?></td>
                      <td>&#8358;<?php echo ($get_users_financial['monthly_repayment'] == '') ? 0 : number_format($get_users_financial['monthly_repayment']);?></td>
                     <td><?php echo $get_users_financial['date_created'];?></td>
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
