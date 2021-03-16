<?php include("includes/sidebar.php");?>
<div id="main">

<?php include("includes/header.php");?> 
<style type="text/css">
/* #bar, #cus {display:none;} */
</style>
<script>
// function show(el, txt){
//     var elem1 = document.getElementById('bar');
//     var elem2 = document.getElementById('cus');

//     elem1.style.display = (txt == 'Comprehensive Insurance') ? 'block' : 'none';
//     elem2.style.display = (txt == 'Custom number plate') ? 'block' : 'none';
//     }
</script>           
<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Profile</h3>
        <!-- <p class="text-subtitle text-muted">Select type of vehicle and permit below</p> -->
    </div>


<section class="section mt-5" id="multiple-column-form ">
        <div class="row match-height">
            <div class="col-6 mx-auto">
                <div class="card">
                    <div class="d-flex justify-content-center pt-3">
                        <img class="profile-pic" src="<?php echo 'assets/images/'.$user['profile_pic']?>" alt="" srcset="">
                    </div>
                    <div class="row mx-auto py-2">
                        <p><?php echo $user['first_name']." ".$user['last_name'];?></p>
                    </div>
                    <div class="row mx-auto">
                        <p><?php echo $user['email'];?></p>
                    </div>
                    <?php 
                    if ($user['address'] === null || $user['dob'] === null || $user['gender'] === null || 
                        $user['marital_status'] === null || $user['employment_status'] === null || 
                        $user['occupation'] === null) 
                    {
                    ?>
                    <div class="container">
                        <div class="alert alert-info text-center" role="alert">
                            Your profile is not complete
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                    <div class="card-content">
                        <div class="card-body">

                            <form class="form" action="complete_order.php">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="address">Contact address</label>
                                            <textarea name="address" class="form-control" id="address" cols="30" rows="3"><?php echo $user['address'];?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <select class="form-select">
                                                <option>Select vehicle type</option>
                                                <option>Motorcycle/Tricycle</option>
                                                <option>Saloon Car - Med (1.4-1.9L) e.g. Picanto, Corolla, Almera</option>
                                                <option>Saloon Car - Maxi (1.4-1.9L) e.g. Camry, Benz, Accord</option>
                                                <option>SUV/Jeep/Bus/Pick-up</option>
                                                <option>Coaster Bus</option>
                                                <option>Mini Trucks/ Trucks 15 Tons (Tippers)</option>
                                                <option>Trucks 20 Tons (6-10 Tyres)</option>
                                                <option>Trucks 30 Tons (10+ Tyres)</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-select">
                                                <option>Vehicle make</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-select">
                                                <option>Select Vehicle  model</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-select">
                                                <option>Select  year of make</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="Vehicle" class="form-control" placeholder="Enter Registration number/Plate number" name="column">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="Vehicle" class="form-control" placeholder="Enter Engine number (optional)" name="Vehicle-column">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="chasis" class="form-control" placeholder="Enter Chasis number" name="Vehicle">
                                        </div>
                                        
                                         <div class="form-group">
                                            <input type="text" id="chasis" class="form-control" placeholder="Name on Vehicle License" name="Vehicle">
                                        </div>
                               
                                        <div class="form-group">
                                            <select name="thename" class="form-select" onChange="show('bar', this.options[this.selectedIndex].firstChild.nodeValue)">
                                                <option>Insurance type</option>
                                                <option>3rd Party Insurance</option>
                                                <option>Comprehensive Insurance</option>
                                                <option>(No Insurance)</option>
                                            </select>
                                        </div>
                            <div id="bar">
                                 <div class="form-group">
                                   <select class="form-select">
                                                <option>Select Plan</option>
                                                <option> Bronze</option>
                                                <option> Silver</option>
                                            </select>
                                </div>
                            </div>
                 </div>
           </div>
                        <div class="col-12 d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary mr-1 mb-1">Update Profile</button>
                        </div>
                        
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</div>
<?php include("includes/footer.php");?>