
<?php
    include("includes/sidebar.php");
    include("includes/header.php");
    $quote_list = fetch_quote_list($user_id);
?>            
<div id="main">
<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Quote List</h3>
        <p class="text-subtitle text-muted">View quote list</p>
    </div>

    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-right">
                <li class="breadcrumb-item"><a href="select_action.php">Back</a></li>
                <li class="breadcrumb-item"><a href="">View quote list</a></li>
            </ol>
        </nav>
    </div>

<section class="section mt-5" id="multiple-column-form ">
        <div class="row match-height">
            <div class="col-10 mx-auto">
                <div class="card">
                    <div class="card-header">
                       <!--  <h4 class="card-title"></h4> -->
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                            <?php
                                if(!empty($quote_list)){
                            ?>
                                <table class="table">
                                    <thead>
                                        <th>Insurer</th>
                                        <th>Plan</th>
                                        <th>Vehicle Value</th>
                                    </thead>
                                    <tbody>
                                    <?php
                                        foreach($quote_list as $quote){
                                            $insurer_name = $quote['insurer_name'];
                                            $plan_name = $quote['plan_name'];
                                            $vehicle_value = $quote['vehicle_value'];
                                            $vehicle_amount = "#".number_format($vehicle_value);
                                    ?>
                                        <tr>
                                            <td><?=$insurer_name;?></td>
                                            <td><?=$plan_name;?></td>
                                            <td><?=$vehicle_amount;?></td>
                                        </tr>
                                    <?php
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            <?php
                                }else{
                            ?>
                                <div>
                                    <span>No quote available.</span>
                                </div>
                            <?php
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

 

</div>
<?php include("includes/footer.php");?>
            

