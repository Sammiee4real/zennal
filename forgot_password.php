<!-- {% extends 'layouts/master-auth.html' %}
{%  set title = "Forgot Password" %}
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
                        <p>Please enter your email to receive password reset link.</p>
                    </div>
                    <form action="login.php">
                        <div class="form-group">
                            <label for="first-name-column">Email</label>
                            <input type="email" id="first-name-column" class="form-control" name="fname-column" placeholder="Enter your email">
                        </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <button class="btn btn-block mb-2 btn-primary">Submit</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- {% endblock %} -->
<script src="assets/js/feather-icons/feather.min.js"></script>
    <script src="assets/js/app.js"></script>
    
    <script src="assets/js/main.js"></script>
</body>

</html>
