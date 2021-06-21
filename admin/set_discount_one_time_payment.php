<?php
//session_start();
include("../config/functions.php");
include("inc/header.php");
$admin_id =$_SESSION['admin_id'];
$admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
$get_one_time_discount = get_rows_from_one_table('one_time_discount','date_created');
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
          <h1 class="h3 mb-2 text-gray-800">Set One Time Payment Discount</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                  <thead class="thead-light">
                 <?php if($get_one_time_discount == null){
                    echo "<tr><td>No record found...</td></tr>";
                  } else{ ?>
                  <tr>
                    <th scope="col">Current Discount(Flat-rate)</th>
                    <th scope="col">Activation Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach($get_one_time_discount as $value){
                     ?>
                    <tr>
                      <td><?php echo '&#8358;'.number_format($value['discount_rate']);?></td>           
                      <td><?php echo $value['status'] == 1 ? "<small class='badge badge-success'>Active</small>": "<small class='badge badge-danger'>Disabled</small>";?></td>           
                      <td>
                        <button type="button" class="btn btn-sm btn-primary edit_modal"
                        id="<?php echo $value['unique_id']?>"
                        data-discount_rate="<?php echo $value['discount_rate']?>"
                        >
                          Edit
                        </button>
                        <?php
                          if($value['status'] == 1){
                          ?>
                          <button type="button" class="btn btn-sm btn-danger hide_modal"
                        id="<?php echo $value['unique_id']?>"
                        >
                          Hide
                        </button>
                          <?php }
                          else if($value['status'] == 0){
                            ?>
                            <button type="button" class="btn btn-sm btn-success show_modal"
                        id="<?php echo $value['unique_id']?>"
                        >
                          Show
                        </button>
                         <?php }
                        ?>
                      </td>
                    </tr>
                    <?php } } ?>
                </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
        <?php include("inc/footer.php");?>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

    <div class="modal" tabindex="-1" role="dialog" id="modal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Discount Value</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" id="edit_one_time_discount_form">
              <div class="row justify-content-center">
                <div class="col-md-8 mt-3">
                  <label>Current Discount</label>
                  <input type="text" name="discount_rate" class="form-control" id="discount_rate"  required>
                </div>
              
              </div>
              <input type="hidden" name="unique_id"  id="unique_id" value="">
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="edit_one_time_payment_btn">Edit</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="modal1">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Hide One-time Payment</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Are you sure you want to hide?
            <form method="post" id="hide_one_time_discount_form">
              <input type="hidden" name="unique_id"  id="unique_id1" value="">
              <input type="hidden" name="status" id="status" value="0">
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" id="hide_one_time_discount_btn">Hide</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="modal2">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Activate One-time Payment</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Are you sure you want to show?
            <form method="post" id="show_one_time_discount_form">
              <input type="hidden" name="unique_id"  id="unique_id2" value="">
              <input type="hidden" name="status" id="status" value="1">
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" id="show_one_time_discount_btn">Show</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

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
        let discount_rate = $(this).data('discount_rate');
        $("#unique_id").val(unique_id);
        $("#discount_rate").val(discount_rate);
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
