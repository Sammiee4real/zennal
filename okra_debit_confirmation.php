<?php include('inc/header.php');
include('config/database_functions.php');
$user_id =$_SESSION['uid'];
$loan_id = isset($_GET['loan_id']) ? $_GET['loan_id'] : '';
$get_loan_application = get_one_row_from_one_table_by_id('personal_loan_application', 'unique_id', $loan_id, 'approval_status', 1, 'date_created');
$amount = $get_loan_application['amount_to_repay'];
?>

<body>

    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader bg-primary text-light no-border">
      <!--   <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div> -->
        <div class="left" id="">
                <a href="javascript:;" class="headerButton ml-5" data-toggle="modal" data-target="#sidebarPanel">
                <div class="col">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
            </a>
        </div>
       
        <div class="pageTitle">Debit Confirmation</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->


    <!-- App Capsule -->
    <div id="appCapsule" class="extra-header-active">
        <div class="section mb-2 full" id="highform">
            <div class="wide-block pt-2 pb-2">
               Please click the button below to confirm that your account should be debited after one month<br><br>
               <button onclick="connectViaOptions2()" class="btn btn-primary btn-sm">Direct Debit Confirmation</button>
            </div>
        </div>



    </div>
    <!-- * App Capsule -->
 <!-- App Bottom Menu -->
     <?php include('inc/bottom_menu.php');?>
     <!-- *App Bottom Menu -->

     <!-- Footer -->
      <?php include("inc/footer.php");?>
      <!-- End of Footer -->
     
     <!-- App Sidebar -->
     <?php include('inc/sidebar.php');?>
     <!-- *App Sidebar -->
   <?php include('inc/scripts.php');?>

   <script type='text/javascript'>
         function connectViaOptions2() {
            Okra.buildWithOptions({
                name: 'Cloudware Technologies',
                env: 'production-sandbox',
                key: 'a804359f-0d7b-52d8-97ca-1fb902729f1a',
                token: '5f5a2e5f140a7a088fdeb0ac', 
                source: 'link',
                color: '#ffaa00',
                limit: '6',
                // amount: 5000,
                // currency: 'NGN',
                charge: {
                      type: 'recurring',
                      amount: <?php echo $amount * 100;?>,
                      note: '',
                      schedule: {
                        interval: 'monthly',
                        startDate: '2020-12-27',
                        endDate: '2020-12-30'
                        },
                      currency: 'NGN',
                      account: '5ecfd65b45006210350becce'
                    },
                corporate: null,
                connectMessage: 'Which account do you want to connect with?',
                products: ["auth", "transactions", "balance"],
                callback_url: 'http://getstarted.naicfund.ng/zennal_callback.php',
                redirect_url: 'http://getstarted.naicfund.ng/zennal_redirect.php',
                logo: 'https://cloudware.ng/wp-content/uploads/2019/12/CloudWare-Christmas-Logo.png',
                filter: {
                    banks: [],
                    industry_type: 'all',
                },
                widget_success: 'Your account was successfully linked to Cloudware Technologies',
                widget_failed: 'An unknown error occurred, please try again.',
                currency: 'NGN',
                exp: null,
                success_title: 'Cloudware Technologies!',
                success_message: 'You are doing well!',
                onSuccess: function (data) {
                    //console.log('success', data);
                    //window.location.href = "http://getstarted.naicfund.ng/zennal_redirect.php";
                },
                onClose: function () {
                    console.log('closed')
                }
            })
        }  
    </script>

</body>

</html>