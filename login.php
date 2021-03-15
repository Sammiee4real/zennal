<?php
include('config/functions.php');
// session_start();
if(isset($_SESSION['user'])){
    header('location: index.php');
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
    
    <link rel="shortcut icon" href="assets/images/logozennal.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/app.css">
</head>

<body>

<div id="success_toast" class="toast-box toast-center">
    <div class="in">
        <ion-icon name="checkmark-circle" class="text-success"></ion-icon>
        <div class="text" id="success_message">
            
        </div>
    </div>
    <button type="button" class="btn btn-sm btn-text-light close-button">CLOSE</button>
</div>

<div id="error_toast" class="toast-box toast-center bg-danger">
    <div class="in">
        <ion-icon name="close-circle" class="text-white"></ion-icon>
        <div class="text" id="error_message">
            
        </div>
    </div>
    <button type="button" class="btn btn-sm btn-text-light close-button">OK</button>
</div>

<div id="auth">
        
<div class="container">
    <div class="row">
        <div class="col-md-5 col-sm-12 mx-auto">
            <div class="card pt-4">
                <div class="card-body">
                    <div class="text-center mb-5">
                        <img src="assets/images/logozennal.png" height="48" class='mb-4'>
                        <h3>Sign In</h3>
                    </div>
                    <form id="login_form" method="post">
                        <div class="form-group position-relative has-icon-left">
                            <label for="email">Email</label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email address">
                                <div class="form-control-icon">
                                    <i data-feather="mail"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left">
                            <div class="clearfix">
                                <label for="password">Password</label>
                                <a href="forgot_password.php" class='float-right'>
                                    <small>Forgot password?</small>
                                </a>
                            </div>
                            <div class="position-relative">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                <div class="form-control-icon">
                                    <i data-feather="lock"></i>
                                </div>
                            </div>
                        </div>

                        <div class='form-check clearfix my-4'>
                            <div class="checkbox float-left">
                                <input type="checkbox" id="checkbox1" class='form-check-input' >
                                <label for="checkbox1">Remember me</label>
                            </div>
                            <div class="float-right">
                                <a href="register.php">Don't have an account?</a>
                            </div>
                        </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <button id="login_submit_btn" class="btn btn-block mb-2 btn-primary">Submit</button>
                        </div>
                    </div>
                    </form>
                   
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php include("footer.php");?>
</body>

</html>
