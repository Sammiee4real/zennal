<?php 
    include("includes/sidebar.php");
    $user_id = $_SESSION['user']['unique_id'];
    //$user_id = '07bf739aba673b233f89d1a25821870d';
    $get_user_details = get_one_row_from_one_table_by_id('users','unique_id', $user_id, 'registered_on');
    $get_personal_loan = get_one_row_from_one_table_by_id('loan_category','type', 1, 'date_created');
    $get_num_personal_loan = get_number_of_rows_two_params('user_loan_details','user_id',$user_id,'loan_category_id',$get_personal_loan['unique_id']);
    $get_num_insurance = get_number_of_rows_one_param('insurance','user_id',$user_id);
    $get_num_vehicle_reg = get_number_of_rows_one_param('vehicle_registration','user_id',$user_id);
    $get_num_running_loan = get_number_of_rows_two_params('personal_loan_application','user_id',$user_id,'approval_status', 3);
    $get_recent_activities = get_user_recent_activities($user_id);
    $get_wallet_balance = get_one_row_from_one_table_by_id('wallet','user_id', $user_id, 'date_created');
    $balance = $get_wallet_balance != null ? $get_wallet_balance['balance']: 0;
    include("includes/header.php");
?>
<div id="main">
         
<div class="main-content container-fluid">
    
    <div class="page-title">
        <h3>Dashboard</h3>
        <p class="text-subtitle text-muted"><?= date("l, d, F, Y ")?></p>
    </div>
    
    <section class="section mt-5">
        <div class="row mb-2">

            <div class="col-12 col-md-4">
                <div class="card card-statistic">
                    <div class="card-body p-0 border-danger shadow h-300 " id="dan">
                        <div class="d-flex flex-column">
                            <div class='px-3 py-3 d-flex justify-content-between'>
                                <h3 class='card-title'>INSURANCE</h3>
                                <div class="card-right d-flex align-items-center">
                                    <p><?= $get_num_insurance;?></p>
                                </div>
                            </div>
                            <div class="px-3 py-3 d-flex justify-content-between">
                                <p>Every kind of Insurance that you have purchased</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card card-statistic">
                    <div class="card-body p-0 border-primary shadow h-300 " id="sec">
                        <div class="d-flex flex-column">
                            <div class='px-3 py-3 d-flex justify-content-between'>
                                <h3 class='card-title'>RUNNING LOAN</h3>
                                <div class="card-right d-flex align-items-center">
                                    <p><?= $get_num_running_loan;?></p>
                                </div>
                            </div>

                            <div class="px-3 py-3 d-flex justify-content-between">
                                <P>All loans that have been aproved and are running</P>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card card-statistic">
                    <div class="card-body p-0 border-success shadow h-300 " id="dan">
                        <div class="d-flex flex-column">
                            <div class='px-3 py-3 d-flex justify-content-between'>
                                <h3 class='card-title'>VEHICLE REGISTRATION</h3>
                                <div class="card-right d-flex align-items-center">
                                    <p><?= $get_num_vehicle_reg;?></p>
                                </div>
                            </div>
                            <div class="px-3 py-3 d-flex justify-content-between">
                                <p>The total number of vehicles you have registered or renewed their papers</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card card-statistic">
                    <div class="card-body p-0 border-warning shadow h-300 " id="dan">
                        <div class="d-flex flex-column">
                            <div class='px-3 py-3 d-flex justify-content-between'>
                                <h3 class='card-title'>WALLET</h3>
                                <div class="card-right d-flex align-items-center">
                                    <p>&#8358;<?= number_format($balance);?></p>
                                </div>
                            </div>
                            <div class="px-3 py-3 d-flex justify-content-between">
                                <p>Your total bonus for sharing Zennal with friends and family</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>

    <div class="page-title mt-5">
        <p class="text-subtitle text-muted">QUICK LINKS</p>
    </div>

    <section class="section">
        <div class="row mb-2">
            <div class="col-12 col-md-4">
                <a href="insurance.php"><div class="card card-statistic" style=" background: #eedcd5; border-radius: 8px;">
                    <div class="card-body p-0">
                        <div class="d-flex flex-column" >
                            <div class='px-3 py-3 d-flex justify-content-between'>
                                <h5 class=''>Insure with Zennal</h5>
                            </div>
                            <div class='px-3 py-3 d-flex justify-content-between'>
                                <P>Insure your car life and many more with Zennal</P>
                                <div class="card-right d-flex align-items-center">
                                    <img src="assets/images/vector.png" >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-12 col-md-4">
               <a href="loan.php"> <div class="card card-statistic" style="background: #d7d1f4;border-radius: 8px;">
                    <div class="card-body p-0">
                        <div class="d-flex flex-column">
                            <div class='px-3 py-3 d-flex justify-content-between'>
                                <h5 class=''>Apply for a Loan</h5>
                                </div>
                            </div>
                            <div class="px-3 py-3 d-flex justify-content-between">
                                <P>Seamlessly apply for quick loans with Zennal</P>
                                <div class="card-right d-flex align-items-center">
                                    <img src="assets/images/loan.png" >
                                </div>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-12 col-md-4">
                <a href="vehicle_reg.php"><div class="card card-statistic" style="background: #00DBC5; border-radius: 8px;">
                    <div class="card-body p-0">
                        <div class="d-flex flex-column">
                            <div class='px-3 py-3  justify-content-between'>
                                <h5 class=''>Vehicle Registration</h5>
                            </div>
                            <div class="px-3 py-3 d-flex justify-content-between">
                                <p>Obtain documents for your vehicles - renewal or fresh registration</p>
                                <div class="card-right d-flex align-items-center">
                                    <img src="assets/images/car.png" >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            </div>
            <div class="col-12 col-md-4">
               <a href="activities.php"> <div class="card card-statistic" style="background: #c6f4f3;border-radius: 8px;">
                    <div class="card-body p-0">
                        <div class="d-flex flex-column">
                            <div class='px-3 py-3  justify-content-between'>
                                <h5 class=''>Refer a Friend</h5>
                            </div>
                            <div class="px-3 py-3 d-flex justify-content-between">
                                <p>Share with your friends, let them enjoy Zennal</p>
                                <div class="card-right d-flex align-items-center">
                                    <img src="assets/images/refer.png" >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
            </div>
        </div>

    </section>

</div>
<?php include("includes/footer.php");?>
            