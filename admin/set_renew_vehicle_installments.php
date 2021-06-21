<?php
//session_start();
include("../config/functions.php");
include("inc/header.php");
$admin_id =$_SESSION['admin_id'];
$admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
$renew_vehicle_installment_settings = get_rows_from_one_table('renew_vehicle_installment_setting','id',1);

?>  

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Sidebar -->
    <?php include("inc/sidebar.php");?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
        <?php include("inc/topnav.php");?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800"> Renew Vehicle Installment Setting </h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                  <thead class="thead-light">
                
                  <tr>
                    <th scope="col">Settings Type</th>
                    <th scope="col">Description</th>
                    <th>Status</th>
                    <!-- <th scope="col">Last Updated</th> -->
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                
                 <?php foreach($renew_vehicle_installment_settings as $renew_vehicle_installment_setting){?> 
                  <tr>
                    <td scope="col"><?php echo $renew_vehicle_installment_setting['settings_name']; ?></td>
                    <td scope="col"><?php echo $renew_vehicle_installment_setting['settings_description']; ?></td>
                    <td scope="col"><?php echo $renew_vehicle_installment_setting['status'] == 1 ? "<small class='badge badge-success'>Visible</small>": "<small class='badge badge-danger'>Hidden</small>";?></td> 
            
                    <!-- <td scope="col">Last Updated</td> -->
                    <td>
                         <?php
                          if($renew_vehicle_installment_setting['status'] == 1){
                          ?>
                          <button type="button" class="btn btn-sm btn-danger hide_modal"
                        id="<?php echo $renew_vehicle_installment_setting['unique_id']?>"
                        >
                          Hide
                        </button>
                          <?php }
                          else if($renew_vehicle_installment_setting['status'] == 0){
                            ?>
                            <button type="button" class="btn btn-sm btn-success show_modal"
                        id="<?php echo $renew_vehicle_installment_setting['unique_id']?>"
                        >
                          Show
                        </button>
                         <?php }
                        ?>

                    </td>
                  </tr>
                      <?php }
                        ?>

                 

                   
                </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->



   <div class="modal" tabindex="-1" role="dialog" id="modal1">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Hide Renew Vehicle Installment Setting</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Are you sure you want to hide?
            <form method="post" id="hide_renew_vehicle_installment_settings_form">
              <input type="hidden" name="unique_id"  id="unique_id1" value="">
              <input type="hidden" name="status" id="status" value="0">
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" id="hide_renew_vehicle_installment_settings_btn">Hide</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="modal2">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Show Renew Vehicle Installment Setting</h5>
            
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Are you sure you want to show?
            <form method="post" id="show_renew_vehicle_installment_settings_form">
              <input type="hidden" name="unique_id"  id="unique_id2" value="">
              <input type="hidden" name="status" id="status" value="1">
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" id="show_renew_vehicle_installment_settings_btn">Show</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    

    <!-- Footer -->
        <?php include("inc/footer.php");?>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->



  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <?php include("inc/scripts.php");?>
  <script>
    $(document).ready(function(){
      $(".edit_modal").click(function(){
        $("#modal").modal('show');
        let unique_id = $(this).attr('id');
        let no_of_month = $(this).data('no_of_month');
        let interest_rate = $(this).data('interest_rate');
        $("#unique_id").val(unique_id);
        $("#no_of_month").val(no_of_month);
        $("#interest_rate").val(interest_rate);
      });
      $(".hide_modal").click(function(){
        $("#modal1").modal('show');
        let unique_id = $(this).attr('id');
        $("#unique_id1").val(unique_id);
      });
      $(".show_modal").click(function(){
        $("#modal2").modal('show');
        let unique_id = $(this).attr('id');
        $("#unique_id2").val(unique_id);
      });
    });
  </script>
</body>

</html>
