<?php
//session_start();
  include("../config/functions.php");
  include("inc/header.php");

  $today = date('d-m-Y');
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

  $getNewSignUp = get_total('users', '	registered_on', [$today], 'like', 'count', '');
  $getTodayUsers = get_total('users', '	registered_on', [$today], 'like', 'count', '');

  $total_loan_requests = get_number_of_rows('personal_loan_application');
  $today_loan_requests = get_total('personal_loan_application', '	date_created', [$today], 'like', 'count', '');
  $total_rejected_loans = get_number_of_rows_one_param('personal_loan_application','approval_status',2);
  $total_to_approve_loans = get_number_of_rows_one_param('personal_loan_application','approval_status',0);


  $total_running_loans = get_number_of_rows_one_param('personal_loan_application','approval_status',3);
  $today_running_loans = get_total('personal_loan_application', 'date_created, approval_status', [$today, 3], 'like, =', 'count', '');

  $today_repayments = get_total('personal_loan_application', 'date_created, approval_status', [$today, 4], 'like, =', 'sum', 'amount_to_repay');
  $vol_disbursed = get_total('personal_loan_application', 'approval_status', [3], '', 'sum', 'user_approved_amount');
  $total_loans = get_total('personal_loan_application', '', [''], '', 'sum', 'user_approved_amount');


  $total_vh_ins_request = get_total('vehicle_insurance', '', [''], '', 'count', '');
  $total_vh_ins_sold = get_total('vehicle_insurance', 'paid', [0], '!=', 'count', '');
  $today_vh_ins_request = get_total('vehicle_insurance', 'datetime', [$today], 'like', 'count', '');
  $today_vh_ins_sold = get_total('vehicle_insurance', 'datetime, paid', [$today, 0], 'like, !=', 'count', '');


  $total_vh_reg_request = get_number_of_rows('vehicle_registration');
  $today_vh_reg_request = get_total('vehicle_registration', 'date_created', [$today], 'like', 'count', '');
  $total_vh_reg_sold = get_number_of_rows('vehicle_reg_payment');
  $today_vh_reg_sold = get_total('vehicle_reg_payment', 'date_created', [$today], 'like', 'count', '');


  $total_vh_part_request = get_number_of_rows('renew_vehicle_particulars');
  $today_vh_part_request = get_total('renew_vehicle_particulars', 'datetime', [$today], 'like', 'count', '');
  $total_vh_part_sold = get_total('renew_vehicle_particulars', 'paid', [0], '!=', 'count', '');
  $today_vh_part_sold = get_total('renew_vehicle_particulars', 'datetime, paid', [$today, 0], 'like, !=', 'count', '');


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
<style>
  .row button {
    margin: 2px;
    margin-bottom: 10px!important;
  }
</style>
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
            <a href="report.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
          </div>

          <div class="row">
            <button class="btn btn-primary btn-sm" id="showUsers">
              <i class="fa fa-eye"></i> View Users
            </button>

            <button class="btn btn-primary btn-sm" id="showLoans">
              <i class="fa fa-eye"></i> View Loans
            </button>

            <button class="btn btn-primary btn-sm" id="showVhRegs">
              <i class="fa fa-eye"></i> View Vehicle Registrations
            </button>

            <button class="btn btn-primary btn-sm" id="showVhIns">
              <i class="fa fa-eye"></i> View Vehicle Insurances
            </button>

            <button class="btn btn-primary btn-sm" id="showVhParts">
              <i class="fa fa-eye"></i> View Vehicle Particulars
            </button>
          </div>
          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4 dash-badge badge-users">
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
            <div class="col-xl-4 col-md-6 mb-4 dash-badge badge-users">
              <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase">New Sign Ups</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $getNewSignUp?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>




            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4 dash-badge badge-users">
              <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase">Today Users</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $getTodayUsers?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>



            <div class="col-xl-4 col-md-6 mb-4 dash-badge badge-loans">
              <div class="card border-left-warning shadow h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase">Total Loans</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">&#8358;<?= number_format($total_loans)?></div>
                    </div>
                    <div class="col-auto">
                      <!-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>



            <div class="col-xl-4 col-md-6 mb-4 dash-badge badge-loans">
              <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase">Total Volume Disbursed</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">&#8358;<?= number_format($vol_disbursed)?></div>
                    </div>
                    <div class="col-auto">
                      <!-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>


           

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4 dash-badge badge-loans">
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
                      <!-- <i class="fas fa-coins fa-2x text-gray-300"></i></i> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4 dash-badge badge-loans">
              <div class="card border-left-light shadow h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase">Ongoing Personal Loan</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $get_num_ongoing_personal?></div>
                    </div>
                    <div class="col-auto">
                      <!-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-4 col-md-6 mb-4 dash-badge badge-loans">
              <div class="card border-left-info shadow h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase">Total Loan Requests</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$total_loan_requests?></div>
                    </div>
                    <div class="col-auto">
                      <!-- <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <!-- </div> -->

            <div class="col-xl-4 col-md-6 mb-4 dash-badge badge-loans">
              <div class="card border-left-success shadow h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase">Today Loan Requests</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $today_loan_requests?></div>
                    </div>
                    <div class="col-auto">
                      <!-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4 dash-badge badge-loans">
              <div class="card border-left-warning shadow h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase">Total Awaiting Approval Loans</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$total_to_approve_loans?></div>
                    </div>
                    <div class="col-auto">
                      <!-- <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4 dash-badge badge-loans">
              <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase">Total Rejected Loans</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_rejected_loans?></div>
                    </div>
                    <div class="col-auto">
                      <!-- <i class="fas fa-users fa-2x text-gray-300"></i> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>



            <div class="col-xl-4 col-md-6 mb-4 dash-badge badge-loans">
              <div class="card border-left-info shadow h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase">Total Successful Loans</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $total_running_loans?></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <!-- <i class="fas fa-coins fa-2x text-gray-300"></i></i> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4 dash-badge badge-loans">
              <div class="card border-left-success shadow h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase">Today Successful Loans</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $today_running_loans?></div>
                    </div>
                    <div class="col-auto">
                      <!-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <div class="col-xl-4 col-md-6 mb-4 dash-badge badge-loans">
              <div class="card border-left-success shadow h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase">Today Repayments</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($today_repayments)?></div>
                    </div>
                    <div class="col-auto">
                      <!-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>



            

    <!-- vehicle insurance  -->
            <div class="col-xl-4 col-md-6 mb-4 dash-badge badge-vh-ins">
              <div class="card border-left-info shadow h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase">Total Vehicle Insurance Requested</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($total_vh_ins_request)?></div>
                    </div>
                    <div class="col-auto">
                      <!-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4 dash-badge badge-vh-ins">
              <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase">Total Vehicle Insurance Sold</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($total_vh_ins_sold)?></div>
                    </div>
                    <div class="col-auto">
                      <!-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>


<div class="col-xl-4 col-md-6 mb-4 dash-badge badge-vh-ins">
  <div class="card border-left-secondary shadow h-100">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div class="text-xs font-weight-bold text-success text-uppercase">Today Vehicle Insurance Requested</div>
          <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($today_vh_ins_request)?></div>
        </div>
        <div class="col-auto">
          <!-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> -->
        </div>
      </div>
    </div>
  </div>
</div>

<div class="col-xl-4 col-md-6 mb-4 dash-badge badge-vh-ins">
  <div class="card border-left-success shadow h-100">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div class="text-xs font-weight-bold text-success text-uppercase">Today Vehicle Insurance Sold</div>
          <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($today_vh_ins_sold)?></div>
        </div>
        <div class="col-auto">
          <!-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> -->
        </div>
      </div>
    </div>
  </div>
</div>



<!-- vehicle registrations  -->
<div class="col-xl-4 col-md-6 mb-4 dash-badge badge-vh-reg">
              <div class="card  shadow h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase">Total Vehicle Registration Requested</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($total_vh_reg_request)?></div>
                    </div>
                    <div class="col-auto">
                      <!-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4 dash-badge badge-vh-reg">
              <div class="card border-left-dark shadow h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase">Total Vehicle Registration Sold</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($total_vh_reg_sold)?></div>
                    </div>
                    <div class="col-auto">
                      <!-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>


<div class="col-xl-4 col-md-6 mb-4 dash-badge badge-vh-reg">
  <div class="card border-left-warning shadow h-100">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div class="text-xs font-weight-bold text-success text-uppercase">Today Vehicle Registration Requested</div>
          <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($today_vh_reg_request)?></div>
        </div>
        <div class="col-auto">
          <!-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> -->
        </div>
      </div>
    </div>
  </div>
</div>

<div class="col-xl-4 col-md-6 mb-4 dash-badge badge-vh-reg">
  <div class="card border-left-primary shadow h-100">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div class="text-xs font-weight-bold text-success text-uppercase">Today Vehicle Registration Sold</div>
          <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($today_vh_reg_sold)?></div>
        </div>
        <div class="col-auto">
          <!-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> -->
        </div>
      </div>
    </div>
  </div>
</div>




<!-- vehicle Particulars  -->
<div class="col-xl-4 col-md-6 mb-4 dash-badge badge-vh-part">
              <div class="card border-left-info shadow h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase">Total Vehicle Particulars Requested</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($total_vh_part_request)?></div>
                    </div>
                    <div class="col-auto">
                      <!-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4 dash-badge badge-vh-part">
              <div class="card border-left-secondary shadow h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase">Total Vehicle Particulars Sold</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($total_vh_part_sold)?></div>
                    </div>
                    <div class="col-auto">
                      <!-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>


<div class="col-xl-4 col-md-6 mb-4 dash-badge badge-vh-part">
  <div class="card border-left-secondary shadow h-100">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div class="text-xs font-weight-bold text-success text-uppercase">Today Vehicle Particulars Requested</div>
          <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($today_vh_part_request)?></div>
        </div>
        <div class="col-auto">
          <!-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> -->
        </div>
      </div>
    </div>
  </div>
</div>

<div class="col-xl-4 col-md-6 mb-4 dash-badge badge-vh-part">
  <div class="card border-left-warning shadow h-100">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div class="text-xs font-weight-bold text-success text-uppercase">Today Vehicle Particulars Sold</div>
          <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($today_vh_part_sold)?></div>
        </div>
        <div class="col-auto">
          <!-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> -->
        </div>
      </div>
    </div>
  </div>
</div>


      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php include("inc/footer.php");?>

  <?php include("inc/scripts.php");?>

</body>

</html>

<script>
  $(document).ready(function(){
    show_badge('users');

    $('#showUsers').click(function(){
      show_badge('users');
    })

    $('#showLoans').click(function(){
      show_badge('loans');
    })

    $('#showVhRegs').click(function(){
      show_badge('vh-reg');
    })

    $('#showVhIns').click(function(){
      show_badge('vh-ins');
    })

    $('#showVhParts').click(function(){
      show_badge('vh-part');
    })
  })

  function show_badge(ref = ''){
    $('.dash-badge').hide();

    $('.badge-'+ref).fadeIn();
  }
</script>