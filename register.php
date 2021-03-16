<!-- {% extends 'layouts/master-auth.html' %}
{%  set title = "Sign up" %}
{% block content %} -->
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
                    <form action="login.php">
                        <div class="row">
                            <div class="">
                                <div class="form-group">
                                    <label for="first-name-column">Phone Number</label>
                                    <input type="number" id="first-name-column" class="form-control"  name="fname-column" placeholder="Enter your phone number">
                                </div>

                                <div class="form-group">
                                    <label for="email-id-column">Email</label>
                                    <input type="email" id="email-id-column" class="form-control" name="email-id-column" placeholder="Enter your emial address">
                                </div>
                            </div>

                    <div class="card-body">
                        <div class="alert alert-light-primary color-primary"><i data-feather="star"></i>Ensure that the phone number supplied is linked to BVN</div>
                    </div>
                
                        </diV>

                    <a href="login.php">Have an account? Login</a>
                        
                    </form><br>
                    <div class="row">
                        <div class="col-sm-12">
                            <button class="btn btn-block mb-2 btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- {% endblock %} -->
<script src="assets/js/feather-icons/feather.min.js"></script>
    <script src="assets/js/app.js"></script>
    
    <script src="assets/js/main.js"></script>
    <script src="assets/vendors/sweetalert2/package/dist/sweetalert2.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    </body>

</html>