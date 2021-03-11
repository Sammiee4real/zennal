<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zennal Dashboard</title>
    
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    
    <link rel="stylesheet" href="assets/vendors/chartjs/Chart.min.css">
    <link rel="stylesheet" href="assets/vendors/simple-datatables/style.css">
    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <!-- <link rel="stylesheet" href="assets/css/appp.css"> -->
    <link rel="stylesheet" type="text/css" href="assets/css/wizard.css">
    <link rel="shortcut icon" href="assets/images/logozennal.png" type="image/x-icon">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">  -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
</head>

<style type="text/css">
    .sidebar-item.active{
    /*background-color:#e8f3ff;*/
    /*color:white;*/
   /* display: block;*/
}

</style>
<body>
   
    <div id="app">

<div id="sidebar" class='active'>
            <div class="sidebar-wrapper active ps ps--active-y">
    <div class="sidebar-header">
        <img src="assets/images/logozennal.png" alt="" srcset="">
    </div>
    <div class="sidebar-menu">
        <ul class="menu" id="navMenus">
            
                <li class="sidebar-item active">
                    <a href="index.php" class='sidebar-link'>
                        <i data-feather="home" width="20"></i> 
                        <span>Dashboard</span>
                    </a>
                </li>

            
            
                <li class="sidebar-item ">
                    <a href="loan.php" class='sidebar-link'>
                        <i data-feather="twitch" width="20"></i> 
                        <span>Loan</span>
                    </a>
                </li>
            
            
                <li class="sidebar-item ">
                    <a href="insurance.php" class='sidebar-link'>
                        <i data-feather="shield" width="20"></i> 
                        <span>Insurance</span>
                    </a>
                </li>

                <li class="sidebar-item has-sub">
                    <a href="#" class='sidebar-link'>
                        <i data-feather="truck" width="20"></i> 
                        <span>Vehicle Registration</span>
                    </a>
                    
                    <ul class="submenu">
                        <li>
                            <a href="vehicle_reg.php">Register your New Vehicle</a>
                        </li>
                        <li>
                            <a href="particulars.php">Renew your Vehicle Particulars</a>
                        </li>
                        <li>
                            <a href="vehicle_permit.php">Other Vehicle Permit</a>
                        </li>
                        
                        <li>
                            <a href="change_ownership.php">Change Vehicle Ownership</a>
                        </li>

                        <li>
                            <a href="pricing.php">Get Quote</a>
                        </li>
                        
                    </ul>
                    
                </li>

                <!-- <li class="sidebar-item  ">
                    <a href="pricing.php" class='sidebar-link'>
                        <i data-feather="truck" width="20"></i> 
                        <span>Vehicle Registration</span>
                    </a>
                    
                </li> -->

            
                <li class="sidebar-item">
                    <a href="vehicle_registration.php" class='sidebar-link'>
                        <i data-feather="activity" width="20"></i> 
                        <span>Activities</span>
                    </a>
                    
                </li>

                <li class="sidebar-item">
                    <a href="activities.php" class='sidebar-link'>
                        <i data-feather="credit-card" width="20"></i> 
                        <span>Wallet</span>
                    </a>
                    
                </li>

                <li class="sidebar-item">
                    <a href="login.php" class='sidebar-link'>
                        <i data-feather="log-out" width="20"></i> 
                        <span>logout</span>
                    </a>
                    
                </li>
        </ul>
    </div>
    <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
</div>
</div>
<!-- <script> 
    $(document).ready(function(){
  $('ul li a').click(function(){
    $('li a').removeClass("active");
    $(this).addClass("active");
});
});
</script>  -->



<script>
/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
var dropdown = document.getElementsByClassName("sidebar-item");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
  this.classList.toggle("active");
  var dropdownContent = this.nextElementSibling;
  if (dropdownContent.style.display === "block") {
  dropdownContent.style.display = "none";
  } else {
  dropdownContent.style.display = "block";
  }
  });
}
</script>

