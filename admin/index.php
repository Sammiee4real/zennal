<?php
//session_start();
  include("../config/functions.php");
  include("inc/header.php");
  $admin_id =$_SESSION['admin_id'];
  $admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
  //$interest_rate = get_one_row_from_one_table_by_id('insurance_interest_rate','id', '1', 'datetime');
  $get_num_users = get_number_of_rows('users');
  //$get_asset_loan = get_one_row_from_one_table_by_id('loan_category','type', 2, 'date_created');
  $get_num_approved_asset_loan = get_number_of_rows_one_param('asset_finance_application','approval_status',1);
  //$get_personal_loan = get_one_row_from_one_table_by_id('loan_category','type', 1, 'date_created');
  $get_num_approved_personal_loan = get_number_of_rows_one_param('personal_loan_application','approval_status',1);
  $total_personal_loan = get_total_loan(1);
  $total_asset_loan = get_total_loan(2);
  $get_num_ongoing_asset = get_number_of_rows_one_param('asset_finance_application','approval_status', 3);
  $get_num_ongoing_personal = get_number_of_rows_one_param('personal_loan_application','approval_status', 3);
  $get_num_loan_packages = get_number_of_rows('loan_packages');
  // $get_loan_packages = get_rows_from_one_table('','');


  // $int_rate = $interest_rate['interest_rate'];

  // if ($interest_rate['type'] == '1') {
  //   $icon = "fa-dollar-sign";
  //   $type = "Flat Rate";
  // }
  // elseif ($interest_rate['type'] == '2') {
  //   $icon = "fa-percent";
  //   $type = "Percentage Rate";
  // }
?>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <?php include("inc/sidebar.php");?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

       <?php include("inc/topnav.php");?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard </h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase">Total Users</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $get_num_users?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <!-- <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase">Loan Packages</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php //$get_num_loan_packages;?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-wallet fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase">Approved Personal Loan</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $get_num_approved_personal_loan?></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-coins fa-2x text-gray-300"></i></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase">Ongoing Personal Loan</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $get_num_ongoing_personal?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pending Requests Card Example -->
            <!-- <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase">Total Asset Loan Disbursed</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">&#8358;<?php //$total_asset_loan?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->
          </div>


                    <!-- Content Row -->
          <!-- <div class="row"> -->

            <!-- Earnings (Monthly) Card Example -->
          <!--   <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase">Total Personal Loan Disbursed</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">&#8358;<?php //$total_personal_loan?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-money-check fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->

            <!-- Earnings (Monthly) Card Example -->
            <!-- <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase">Number of Ongoing Asset Finance</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php //$get_num_ongoing_asset?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase">Number of Ongoing Personal Loan</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php //$get_num_ongoing_personal?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase">Insurance Interest <br />- <?= $type ?> </div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php // $int_rate ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas <?php // $icon ?> fa-2x text-gray-300"></i> -->
                      <!-- <i class="fas fa-percent"></i> -->
                    </div>
                  </div>
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

  <?php include("inc/scripts.php");?>

</body>

</html>