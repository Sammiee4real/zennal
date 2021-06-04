<?php include("includes/sidebar.php");
    $get_wallet_balance = get_one_row_from_one_table_by_id('wallet','user_id', $user_id, 'date_created');
    $get_referral_log = get_rows_from_one_table_by_id('referral_log','referrer_id', $user_id, 'date_added');
?>
<div id="main">

<?php include("includes/header.php");?>            
<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Refer a Friend</h3>
        <p class="text-subtitle text-muted">Get a bonus for sharing Zennal</p>
    </div>

    <section class="section mt-5">
        <div class="row">
            <div class="col-xl-6 col-md-5 col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="row no-gutters">
                            <div class="col-lg-7 col-12">
                                <div class="card-body">
                                    <p class="card-text text-ellipsis">
                                       Copy your referral link to share with a friend.
                                    </p>
                                    <h6 id="referral_link"><?php 
                                    if(strval($_SERVER['HTTP_HOST']) === 'localhost'){
                                        echo $_SERVER['HTTP_HOST']."/zennal/register?referrerid=".$user['referral_code'];
                                    }else{
                                        echo $_SERVER['HTTP_HOST']."/register?referrerid=".$user['referral_code'];
                                    }
                                    ?> </h6>
                                    <button class="btn btn-info" onclick="copy_text(referral_link);">COPY LINK</button>
                                </div>
                            </div>
                            <div class="col-lg-5 col-12 mt-4">
                                <h6 class="font-weight-bold">TOTAL BONUS</h6>
                                <h4 class="text-success ">&#8358;<?php echo number_format($get_wallet_balance['balance']);?></h4>

                                <h6>Your approved bonus must be up to <span class="font-weight-bold">&#8358;<?php echo number_format(7000)?></span> to withdraw</h6>
                                <?php
                                    if($get_wallet_balance['balance'] >= 5000){
                                
                                ?>
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">WITHDRAW</button>
                                <?php
                                    }else{?>
<button type="button" class="btn btn-disabled btn-primary" data-toggle="modal" data-target="#exampleModal" disabled>WITHDRAW</button>
                                <?php }?>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-1 col-md-1 col-12">
                
            </div>
            <div class="col-xl-4 col-md-4 col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="row no-gutters">
                            <div class="col-12">
                                <div class="card-body">
                                    <p class="font-weight-bold">REFERRAL NOTIFICATION</p>
                                    <?php
                                        if($get_referral_log == null){
                                            echo "No notifications yet";
                                        }else{
                                            foreach ($get_referral_log as $value) {
                                                $get_user = get_one_row_from_one_table_by_id('users', 'unique_id', $value['referred_id'], 'registered_on');
                                            ?>
                                            <p class="card-text text-ellipsis">
                                                <i data-feather="bell" width="20"></i>
                                               <?php echo $value['description'].' via '.$get_user['first_name'].' '.$get_user['last_name'];?>
                                            </p>
                                            <?php
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>  
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Withdrawal Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="withdrawal_form">
            <label>Enter Withdrawal Amount</label>
            <input type="number" name="amount" class="form-control mt-2 mb-3">
            <button type="button" class="btn btn-primary" id="withdraw_button">Submit Withdrawal</button>
        </form>
        <div class="mt-3">
            <small class="text-danger font-weight-bold">**Please note your withdrawal will take 24 hours before it is approved</small>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php include("includes/footer.php");?>
<script type="text/javascript">
    function copy_text(element) {
      var $temp = $("<input>");
      $("body").append($temp);
      $temp.val($(element).text()).select();
      document.execCommand("copy");
      $temp.remove();
      alert("Link copied");
    }
</script>
            

