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
                    if ($user['address'] == null || $user['dob'] == null || $user['gender'] == null || 
                        $user['marital_status'] == null || $user['employment_status'] == null || 
                        $user['occupation'] == null) 
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

                            <form class="form" id="update_profile_form" method="post">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="address">Contact address</label>
                                            <textarea name="address" class="form-control" id="address" cols="30" rows="3"><?php echo $user['address'] != null ? $user['address'] : 'Enter address';?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="dob">Date of Birth</label>
                                            <input type="date" id="dob" class="form-control" value="<?php echo $user['dob'] ?? null;?>" name="dob">
                                        </div>

                                        <div class="form-group">
                                            <label for="gender">Gender:&nbsp;</label>
                                            <input type="radio" id="male" class="form-check-input" name="gender" value="m" <?php echo $user['gender'] === 'm' ? 'checked' : null;?>>
                                            <label class="form-check-label" for="male">
                                                Male
                                            </label>
                                            <input type="radio" id="female" class="form-check-input" name="gender" value="f" <?php echo $user['gender'] === 'f' ? 'checked' : null;?>>
                                            <label class="form-check-label" for="female">
                                                Female
                                            </label>
                                        </div>

                                        <div class="form-group">
                                            <label for="marital_status">Marital Status</label>
                                            <select class="form-select" name="marital_status">
                                                <option>Select Status</option>
                                                <option <?php if($user['marital_status'] === 'single') echo 'selected';?> value="single">Single</option>
                                                <option <?php if($user['marital_status'] === 'engaged') echo 'selected';?> value="engaged">Engaged</option>
                                                <option <?php if($user['marital_status'] === 'married') echo 'selected';?> value="married">Married</option>
                                                <option <?php if($user['marital_status'] === 'divorced') echo 'selected';?> value="divorced">Divorced</option>
                                                <option <?php if($user['marital_status'] === 'widow') echo 'selected';?> value="widow">Widow</option>
                                                <option <?php if($user['marital_status'] === 'widower') echo 'selected';?> value="widower">Widower</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="employment_status">Employment Status</label>
                                            <select class="form-select" name="employment_status">
                                                <option>Select Status</option>
                                                <option <?php if($user['employment_status'] === 'employed') echo 'selected';?> value="employed">Employed</option>
                                                <option <?php if($user['employment_status'] === 'unemployed') echo 'selected';?> value="unemployed">Unemployed</option>
                                                <option <?php if($user['employment_status'] === 'nysc') echo 'selected';?> value="nysc">NYSC</option>
                                                <option <?php if($user['employment_status'] === 'self_employed') echo 'selected';?> value="self_employed">Self Employed</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="occupation">Occupation</label>
                                            <input type="text" id="occupation" class="form-control" placeholder="Occupation" name="occupation" value="<?php echo $user['occupation'] ?? null;?>">
                                        </div>
                                        
                                    </div>
                            </div>
                        <div class="col-12 d-flex justify-content-center">
                            <button type="submit" id="update_profile_btn" class="btn btn-primary mr-1 mb-1">Update Profile</button>
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