<?php
include('config/functions.php');
// session_start();
if(!isset($_SESSION['user'])){
    header('location: login.php');
    end();
}
?>
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
    <body>
        <div class="container">
            <div class="row mt-5">
                <div class="col-md-6 mx-auto">
                    <?php
                    if (isset($_SESSION['error'])) {
                    ?>
                        <div class="alert alert-warning" role="alert">
                            <?php 
                            echo $_SESSION['error']; 
                            unset($_SESSION['error']);
                            ?>
                        </div>  
                   <?php
                   }
                   elseif (isset($_SESSION['success'])) {
                    ?>
                        <div class="alert alert-success" role="alert">
                            <?php 
                            echo $_SESSION['success']; 
                            unset($_SESSION['success']);
                            ?>
                        </div>  
                    <?php
                   }
                    ?>
                    <div class="row alert alert-info" role="alert">
                        <p>Please check your email to verify your account <a class='mr-auto btn btn-light' href='resend_verr.php'>Resend link</a></p>
                        
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>