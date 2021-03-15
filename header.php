<?php
    // session_start();
    // $user_id = $_SESSION['user_id'];
    $user_id = '07bf739aba673b233f89d1a25821870d';
    $get_recent_activities = get_user_recent_activities($user_id);
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
                    <div class="d-none d-md-block d-lg-inline-block">Jane Doe</div>
                    <span><i data-feather="arrow-down" width="20"></i> </span>
                </a>
    <div class="dropdown-menu dropdown-menu-right">
        <div class="">
            
        <div class="card-header border-bottom text-center">
            <div class="avatar avatar-lg ">
               <img src="assets/images/logozennal.png" alt="" srcset="">
            </div>
            <h4 class="card-title ">Jane Doe</h4>
            <p>janedoe@gmail.com</p>
        </div>
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">

            <span class="">Recent Activities</span>
            <a href="activities.php">View more<i data-feather="arrow-right" width="20"></i></a>
        </div>
        <div class="card-body px-0 py-1">
            <table class='table table-borderless'>
                <?php
                    foreach ($get_recent_activities as $value) {
                        $date=date_create($value['date_created']);
                        
                ?>
                <tr>
                    <td class='col-3'>
                        <h6 class="text-primary"><?= $value['type'];?></h6>
                        <p><?= $value['description'];?></p>
                     </td>
                    <td class='col-6'>
                        <div class="progress progress-info">
                            <div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="0"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </td>
                    <td class='col-3 text-center'>
                        <!-- <small class="text-success">₦0.00</small> -->
                        <p><?= date_format($date,"d/m/Y h:i a");?></p>
                    </td>
                </tr>
                <?php } ?>
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