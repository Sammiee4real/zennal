<?php
//session_start();
include("../config/functions.php");
include("inc/header.php");
$admin_id =$_SESSION['admin_id'];
$admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
$get_vehicle_particulars = get_rows_from_one_table('vehicle_particulars','date_created');
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
          <h1 class="h3 mb-2 text-gray-800">Manage Vehicle Particulars </h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                  <thead class="thead-light">
                 <?php if($get_vehicle_particulars == null){
                        echo "<tr><td>No record found...</td></tr>";
                      } else{ ?>
                  <tr>
                    <th scope="col">Vehicle Type</th>
                    <th scope="col">License</th>
                    <th scope="col">Road Worthiness</th>
                    <th scope="col">3rd Party Insurance</th>
                    <th scope="col">Hackney Permit</th>
                    <th scope="col">Date Created</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach($get_vehicle_particulars as $value){
                    $get_vehicle_type = get_one_row_from_one_table_by_id('vehicles','unique_id', $value['vehicle_id'], 'date_created');
                     ?>
                    <tr>
                      <td><?php echo $get_vehicle_type['vehicle_type'];?></td>
                      <td>
                        &#8358;<?php echo number_format($value['license_amount']);?>
                      </td>
                      <td>
                        &#8358;<?php echo number_format($value['road_worthiness_amount']);?>
                      </td>
                      <td>
                        &#8358;<?php echo number_format($value['third_party_amount']);?>
                      </td>
                      <td>
                        &#8358;<?php echo number_format($value['hackney_permit_amount']);?>
                      </td>
                      <td>
                        <?php echo $value['date_created'];?>
                      </td>
                      <td>
                        <button type="button" class="btn btn-sm btn-primary edit_modal"
                        id="<?php echo $value['unique_id']?>"
                        data-vehicle_type="<?php echo $get_vehicle_type['vehicle_type']?>"
                        data-license_amount="<?php echo $value['license_amount']?>"
                        data-road_worthiness_amount="<?php echo $value['road_worthiness_amount']?>"
                        data-hackney_permit_amount="<?php echo $value['hackney_permit_amount']?>"
                        data-third_party_amount="<?php echo $value['third_party_amount']?>"
                        >
                          Edit
                        </button>
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
            <h5 class="modal-title">Edit Vehicle Particular Price</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" id="edit_particulars_form">
              <div class="row justify-content-center">
                <div class="col-md-8 mt-3">
                  <label>Vehicle Type</label>
                  <input type="text" name="vehicle_id" class="form-control" id="vehicle_type" readonly="" required>
                </div>
                <div class="col-md-8 mt-3">
                  <label>License</label>
                  <input type="text" name="license_amount" class="form-control" id="license_amount"required>
                </div>
                <div class="col-md-8 mt-3">
                  <label>Road Worthiness</label>
                  <input type="text" name="road_worthiness_amount" class="form-control" id="road_worthiness_amount" required>
                </div>
                 <div class="col-md-8 mt-3">
                  <label>3rd Party Insurance</label>
                  <input type="text" name="third_party_amount" class="form-control" id="third_party_amount" required>
                </div>
                 <div class="col-md-8 mt-3">
                  <label>Hackney Permit</label>
                  <input type="text" name="hackney_permit_amount" class="form-control" id="hackney_permit_amount" required>
                </div>
              </div>
              <input type="hidden" name="unique_id"  id="unique_id" value="">
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="edit_particulars_btn">Edit</button>
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
        let vehicle_type = $(this).data('vehicle_type');
        let license_amount = $(this).data('license_amount');
        let road_worthiness_amount = $(this).data('road_worthiness_amount');
        let third_party_amount = $(this).data('third_party_amount');
        let hackney_permit_amount = $(this).data('hackney_permit_amount');
        $("#unique_id").val(unique_id);
        $("#vehicle_type").val(vehicle_type);
        $("#license_amount").val(license_amount);
        $("#road_worthiness_amount").val(road_worthiness_amount);
        $("#third_party_amount").val(third_party_amount);
        $("#hackney_permit_amount").val(hackney_permit_amount);
      });
    });
  </script>
</body>

</html>
