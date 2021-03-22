<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zennal Dashboard</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    
    <link rel="shortcut icon" href="assets/images/logozennal.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="stylesheet" type="text/css" href="assets/vendors/sweetalert2/package/dist/sweetalert2.min.css">
</head>

<body>
    <div id="auth">
<div class="container">
    <div class="row">
        <div class="col-md-5 col-sm-12 mx-auto">
            <div class="card py-4">
                <div class="card-body">
                    <div class="text-center mb-5">
                        <img src="assets/images/logozennal.png" height="48" class='mb-4'>
                        <h3>Forgot Password</h3>
                        <p>Please enter your registered email address.</p>
                    </div>
                    <form id="forgot_password_form">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" class="form-control" name="email" placeholder="Email address" required>
                        </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-block mb-2 btn-primary" id="forgot_password_btn">Submit</button>
                        </div>
                    </div>
                    <a href="login">Go to login</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("includes/footer.php");?>
</body>
</html>