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
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="stylesheet" type="text/css" href="assets/vendors/sweetalert2/package/dist/sweetalert2.min.css">
</head>

<body>
    <div id="auth">
<div class="container">
    <div class="row">
        <div class="col-md-5 col-sm-12 mx-auto">
            <div class="card pt-4">
                <div class="card-body">
                    <div class="text-center mb-5">
                        <img src="assets/images/logozennal.png" height="48" class='mb-4'>
                        <h3>Register</h3>
                        <p>Please fill the form to join us.</p>
                    </div>
                    <form id='register_form' method='post'>
                        <div class="row">
                            <div class="">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <!-- <input type="text" id="first_name" class="form-control"  name="first_name" required placeholder="Enter first name"> -->
                                    <select name="title" id="title" class="form-control">
                                        <option value="mr">Mr</option>
                                        <option value="mrs">Mrs</option>
                                        <option value="miss">Miss</option>
                                        <option value="dr">Dr</option>
                                        <option value="prof">Prof</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="first_name">First name</label>
                                    <input type="text" id="first_name" class="form-control"  name="first_name" required placeholder="Enter first name">
                                </div>

                                <div class="form-group">
                                    <label for="last_name">Last name</label>
                                    <input type="text" id="last_name" class="form-control"  name="last_name" required placeholder="Enter last name">
                                </div>
                                <div class="form-group">
                                    <label for="other_name">Other name</label>
                                    <input type="text" id="other_name" class="form-control"  name="other_name" placeholder="Enter other names">
                                </div>

                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input type="email" id="email" class="form-control"  name="email" required placeholder="Enter email address">
                                </div>

                                <div class="form-group">
                                    <label for="phone_no">Phone Number</label>
                                    <input type="number" id="phone_no" class="form-control"  name="phone_no" required placeholder="Enter phone number">
                                </div>
                                <div class="card-body" id="phone_alert" style="display:none;">
                                    <div class="alert alert-light-primary color-primary"><i data-feather="star"></i>Ensure that the phone number supplied is linked to BVN</div>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" class="form-control" name="password" required placeholder="Enter password">
                                </div>
                                <div class="form-group">
                                    <label for="cpassword">Confirm Password</label>
                                    <input type="password" id="cpassword" class="form-control" name="cpassword" required placeholder="Confirm password">
                                </div>
                                <?php
                                if(isset($_GET['referrerid'])){
                                ?>
                                <!-- <div class="form-group">
                                    <label for="referrerid">Referrer Id</label> -->
                                    <input type="hidden" id="referrerid" class="form-control" name="referrerid" value="<?php echo $_GET['referrerid'] ?>" readonly>
                                <!-- </div> -->
                                <?php
                                }
                                ?>
                            </div>

                
                        </diV>

                    <a href="login">Have an account? Login</a>
                        
                    <br>
                    <div class="row mt-3">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-block mb-2 btn-primary" id="register_submit_btn">Submit</button>
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