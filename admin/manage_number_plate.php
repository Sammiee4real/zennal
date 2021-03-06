<?php
//session_start();
include("../config/functions.php");
include("inc/header.php");
$admin_id =$_SESSION['admin_id'];
$admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
$get_number_plate = get_rows_from_one_table('number_plate','date_created');
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
          <h1 class="h3 mb-2 text-gray-800">Manage Number Plate </h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                  <thead class="thead-light">
                 <?php if($get_number_plate == null){
                        echo "<tr><td>No record found...</td></tr>";
                      } else{ ?>
                  <tr>
                    <th scope="col">Vehicle Type</th>
                    <th scope="col">Number Plate Type</th>
                    <th scope="col">No 3rd Party Insurance</th>
                    <th scope="col">3rd Party Insurance</th>
                    <th scope="col">Personalized Number</th>
                    <th scope="col">Date Created</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                   foreach($get_number_plate as $value){
                    $get_vehicle_type = get_one_row_from_one_table_by_id('vehicles','unique_id', $value['vehicle_id'], 'date_created');
                     ?>
                    <tr>
                      <td><?php echo $get_vehicle_type['vehicle_type'];?></td>
                      <td class="text-capitalize">
                        <?php echo $value['type'];?>
                      </td>
                      <td>
                        &#8358;<?php echo number_format($value['no_third_party_amount']);?>
                      </td>
                      <td>
                        &#8358;<?php echo number_format($value['third_party_amount']);?>
                      </td>
                      <td>
                        &#8358;<?php echo number_format($value['personalized_number']);?>
                      </td>
                      <td>
                        <?php echo $value['date_created'];?>
                      </td>
                      <td>
                        <button type="button" class="btn btn-sm btn-primary edit_modal"
                        id="<?php echo $value['unique_id']?>"
                        data-vehicle_type="<?php echo $get_vehicle_type['vehicle_type']?>"
                        data-type="<?php echo $value['type']?>"
                        data-no_third_party_amount="<?php echo $value['no_third_party_amount']?>"
                        data-third_party_amount="<?php echo $value['third_party_amount']?>"
                        data-personalized_number="<?php echo $value['personalized_number']?>"
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
            <h5 class="modal-title">Edit Number Plate Price</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" id="edit_number_plate_form">
              <div class="row justify-content-center">
                <div class="col-md-8 mt-3">
                  <label>Vehicle Type</label>
                  <input type="text" name="vehicle_id" class="form-control" id="vehicle_type" readonly="" required>
                </div>
                <div class="col-md-8 mt-3">
                  <label>Number Plate Type</label>
                  <input type="text" name="type" class="form-control" id="type" readonly="" required>
                </div>
                <div class="col-md-8 mt-3">
                  <label>No 3rd Party Insurance</label>
                  <input type="text" name="no_third_party_amount" class="form-control" id="no_third_party_amount" required>
                </div>
                 <div class="col-md-8 mt-3">
                  <label>3rd Party Insurance</label>
                  <input type="text" name="third_party_amount" class="form-control" id="third_party_amount" required>
                </div>
                 <div class="col-md-8 mt-3">
                  <label>Personlized Number</label>
                  <input type="text" name="personalized_number" class="form-control" id="personalized_number" required>
                </div>
              </div>
              <input type="hidden" name="unique_id"  id="unique_id" value="">
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="edit_number_plate_btn">Edit</button>
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
        let type = $(this).data('type');
        let no_third_party_amount = $(this).data('no_third_party_amount');
        let third_party_amount = $(this).data('third_party_amount');
        let personalized_number = $(this).data('personalized_number');
        $("#unique_id").val(unique_id);
        $("#vehicle_type").val(vehicle_type);
        $("#type").val(type);
        $("#no_third_party_amount").val(no_third_party_amount);
        $("#third_party_amount").val(third_party_amount);
        $("#personalized_number").val(personalized_number);
      });
    });
  </script>
</body>

</html>
