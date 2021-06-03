<?php include("includes/sidebar.php");
?>
<div id="main">

<?php include("includes/header.php");?> 

<style type="text/css">



.colors {
  /*padding: 2em;
  color: #fff;*/
  display: none;
}

a {
 /* color: #c04;
  text-decoration: none;*/
}

a:hover {
 /* color: #903;
  text-decoration: underline;*/
}

#bar, #cus {display:none;}

</style>

      
<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Error</h3>
        <p class="text-subtitle text-muted">Oops</p>
    </div>


    <section class="section mt-5">
        <div class="col-md-8 col-sm-12 mx-auto">
            <div class="card">
                <div class="card-body">
                    <center>
                      <div><i class="fas fa-exclamation-circle text-danger fa-5x"></i></div>
                      Sorry, Please verify your otp before you continue. Thanks <br>
                      <a href="verify_otp" class="btn btn-secondary mt-3">Verify Otp</a>
                    </center>
                </div>
            </div>
        </div>
    </section>   

</div>
<?php include("includes/footer.php");?>
