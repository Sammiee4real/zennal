
<?php
include("includes/sidebar.php");
include("includes/header.php");

$get_insurers = get_rows_form_table('insurers');
?>

<div id="main">

<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Price Information</h3>
        <p class="text-subtitle text-muted"> Insurance Provider</p>
    </div>

    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-right">
                <li class="breadcrumb-item"><a href="select_action.php">Home</a></li>
                <li class="breadcrumb-item"><a href="">Insurance Provider</a></li>
            </ol>
        </nav>
    </div>
   

<section id="bg-variants">
        <div class="row">
            <div class="col-12 mt-3 mb-1">
                <h6 class="section-title ">Select Insurance Provider</h6>
            </div>
        </div>
        <div class="row">
        <!-- <pre> -->
            <?php
                foreach($get_insurers as $insurer){
            ?>
            <div class="col-xl-4 col-sm-6 col-12">
                <div class="card text-center ">
                    <div class="card-content text-white">
                        <div class="card-body mb-3">
                            <a href="plans_and_benefits.php?insurer_id=<?php echo $insurer['unique_id']?>"><img src="assets/images/<?php echo $insurer['image']?>" width="80px" height="50px"></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php }
            ?>
           
            <!-- <div class="col-xl-4 col-sm-6 col-12">
                <div class="card text-center">
                    <div class="card-content d-flex">
                        <div class="card-body">
                            <a href="mutual_benefits.php"><img src="assets/images/mutual.png" width="72px"></a>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </section>

</div>
<?php include("includes/footer.php");?>
            