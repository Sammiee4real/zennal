<?php include("sidebar.php");
  // $user_id =$_SESSION['uid'];
  $user_id = '07bf739aba673b233f89d1a25821870d';
  $get_recent_activities = get_rows_from_one_table_by_id('user_logs_tbl','user_id',$user_id, 'date_created');
?>
<div id="main">

<?php include("header.php");?>            
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
                foreach ($get_recent_activities as $value) {
              ?>
              <tr>
                <td class="text-bold-500"><?= $count;?></td>
                <td><?= $value['type'];?></td>
                <td class="text-bold-500"><?= $value['description'];?></td>
                <td><?= $value['date_created'];?></td>
              </tr>
              <?php $count++;} ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</section>

    

</div>
<?php include("footer.php");?>
            

