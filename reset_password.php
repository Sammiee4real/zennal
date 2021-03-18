<?php
include('config/functions.php');
// session_start();
if(!isset($_GET['unique_id'])){
    $_SESSION['error'] = 'Invalid password reset link';
    header('location: index.php');
    end();
}

$unique_id = base64_decode($_GET['unique_id']);

if (check_record_by_one_param('users','unique_id',$unique_id) === false) {
    $_SESSION['error'] = 'Invalid password reset link';
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
                        <h3>Reset Password</h3>
                        <p>Please enter your new password below.</p>
                    </div>
                    <form id="password_reset_form">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" class="form-control" name="password" placeholder="New password" required>
                        </div>

                        <div class="form-group">
                            <label for="cpassword">Confirm Password</label>
                            <input type="password" id="cpassword" class="form-control" name="cpassword" placeholder="Confirm password" required>
                            <input type="hidden" name="unique_id" value="<?php echo $unique_id ?? null ?>">
                        </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-block mb-2 btn-primary" id="password_reset_btn">Submit</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("includes/footer.php");?>
</body>

</html>
