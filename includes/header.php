<?php
    $user_id = $_SESSION['user']['unique_id'];
    $get_recent_activities = get_user_recent_activities($user_id, 5);
    $unviewed_activities = [];
    $num_unviewed_notifications = 0;
    if(!empty($get_recent_activities)){
        $view_statuses = array_column($get_recent_activities, 'view_status');
        $count_view_statuses = array_count_values($view_statuses);
        if(isset($count_view_statuses['0'])){
            $num_unviewed_notifications = $count_view_statuses['0'];
        }

    }
?>
            <nav class="navbar navbar-header navbar-expand navbar-light">
                <a class="sidebar-toggler" href="#"><span class="navbar-toggler-icon"></span></a>
                <button class="btn navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    
                    <ul class="navbar-nav d-flex align-items-center navbar-light ml-auto">
                        
                        <li class="dropdown">
                            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                <div class="avatar mr-1">
                                    <img src="assets/images/profile.png" alt="" srcset="">
                                </div>
                                <div class="d-none d-md-block d-lg-inline-block"><?php echo $user['first_name']." ".$user['last_name']; ?></div>
                                <span><i data-feather="arrow-down" width="20"></i> </span>
                                <?php
                                    if($num_unviewed_notifications > 0){
                                ?>
                                <span class="float-right badge"
                                style="background:red;border-radius:50%;width:20px;
                                height:20px;">
                                    <?=$num_unviewed_notifications;?>
                                </span>
                                <?php
                                    }
                                ?>
                            </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="">
                        
                    <div class="card-header border-bottom text-center">
                        <div class="avatar avatar-lg ">
                           <img src="assets/images/logozennal.png" alt="" srcset="">
                        </div>
                        <h4 class="card-title "><?php echo $user['first_name']." ".$user['last_name']; ?></h4>
                        <p><?php echo $user['email'];?></p>
                        <a href="profile">View Profile</a>
                    </div>
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">

            <span class="">Recent Activities</span>
            <a href="activities.php">View more<i data-feather="arrow-right" width="20"></i></a>
        </div>
        <div class="card-body px-0 py-1">
            <table class='table table-borderless'>
                <?php
                    if($get_recent_activities == null){
                        echo "<div class='text-center'>No activities yet</div>";
                    }else{
                        
                        foreach($get_recent_activities as $activity) {

                            $activity_id = $activity['unique_id'];
                            $date = date_create($activity['date_created']);
                            $view_status = $activity['view_status'];
                            $activity_type = $activity['type'];
                            $activity_description = $activity['description'];


                            $background_style = "";
                            if($view_status == 0){
                                $background_style = "background:#F9EBEA";
                                update_activity_view_status($activity_id);
                            }
                        
                ?>
                    <tr style="<?php echo $background_style;?>">
                        <td class='col-3'>
                            <h6 class="text-primary"><?= $activity_type;?></h6>
                            <p><?= $activity_description;?></p>
                        </td>
                        <td class='col-6'>
                            <div class="progress progress-info">
                                <div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="0"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                        <td class='col-3 text-center'>
                            <p><?= date_format($date,"d/m/Y h:i a");?></p>
                        </td>
                    </tr>
                <?php
                        }
                    } 
                ?>
            </table>
            <div class="col-12 d-flex justify-content-end ">
                <a href="#" class="btn btn-primary round mr-4">
                <i data-feather="help-circle" width="20"></i><span> Help</span> </a>
            </div>
            
        </div>
    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>