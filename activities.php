<?php include("includes/sidebar.php");
  // $user_id =$_SESSION['uid'];
  $get_recent_activities = get_user_recent_activities($user_id);
?>
<div id="main">

<?php include("includes/header.php");?>            
<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Activities</h3>
        <p class="text-subtitle text-muted"></p>
    </div>

    <section class="section mt-5">
        <div class="row" id="table-head">
            <div class="col-10 mx-auto">
                <div class="card">
                    <div class="card-content">
                        <!--  -->
                        <!-- table head dark -->
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>S/N</th>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>Date Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    if($get_recent_activities != null){
                                        foreach ($get_recent_activities as $activity) {

                                            $view_status = $activity['view_status'];
                                            $activity_id = $activity['unique_id'];
                                            $activity_type = $activity['type'];
                                            $activity_description = $activity['description'];

                                            $background_style = "";
                                            if($view_status == 0){
                                                $background_style = "background:#F9EBEA";
                                                update_activity_view_status($activity_id);
                                            }
                                    ?>
                                    <tr style="<?php echo $background_style;?>">
                                        <td class="text-bold-500"><?= $count;?></td>
                                        <td><?= $activity_type;?></td>
                                        <td class="text-bold-500"><?= $activity_description;?></td>
                                        <td><?= $activity['date_created'];?></td>
                                    </tr>
                                    <?php
                                            $count++;
                                        } 
                                    }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include("includes/footer.php");?>
            

