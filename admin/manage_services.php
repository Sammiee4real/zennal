<?php
//session_start();
include("../config/functions.php");
include("inc/header.php");
$admin_id =$_SESSION['admin_id'];
$admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
$get_services = get_rows_from_one_table('services','date_created');
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
          <h1 class="h3 mb-2 text-gray-800">Manage Services</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
            </div>
            <div class="card-body">
              <button class="btn btn-secondary btn-sm float-right add_service mb-3" type="button">Add Service</button>
              <div class="table-responsive">
                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                  <thead class="thead-light">
                 <?php if($get_services == null){
                    echo "<tr><td>No record found...</td></tr>";
                  } else{ ?>
                  <tr>
                    <th scope="col">Services</th>
                    <th scope="col">License</th>
                    <th scope="col">Date Created</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach($get_services as $value){
                     ?>
                    <tr>
                      <td><?php echo $value['service'];?></td>
                      <td>
                        &#8358;<?php echo number_format($value['cost']);?>
                      </td>
                      <td>
                        <?php echo $value['date_created'];?>
                      </td>
                      <td>
                        <button type="button" class="btn btn-sm btn-primary edit_modal"
                        id="<?php echo $value['unique_id']?>"
                        data-service="<?php echo $value['service']?>"
                        data-cost="<?php echo $value['cost']?>"
                        >
                          Edit
                        </button>
                        <button type="button" class="btn btn-sm btn-danger delete_modal"
                        id="<?php echo $value['unique_id']?>">
                          Delete
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
            <h5 class="modal-title">Edit Service</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" id="edit_service_form">
              <div class="row justify-content-center">
                <div class="col-md-8 mt-3">
                  <label>Service</label>
                  <input type="text" name="service" class="form-control" id="service" required>
                </div>
                <div class="col-md-8 mt-3">
                  <label>Cost</label>
                  <input type="text" name="cost" class="form-control" id="cost" required>
                </div>
              </div>
              <input type="hidden" name="unique_id"  id="unique_id" value="">
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="edit_service_btn">Edit</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="modal2">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add Service</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" id="add_service_form">
              <div class="row justify-content-center">
                <div class="col-md-8 mt-3">
                  <label>Service</label>
                  <input type="text" name="service" class="form-control" id="service" required>
                </div>
                <div class="col-md-8 mt-3">
                  <label>Cost</label>
                  <input type="text" name="cost" class="form-control" id="cost" required>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="add_service_btn">Add</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="modal3">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Delete Service</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Are you sure you want to delete this service?
            <form method="post" id="delete_service_form">
              <input type="hidden" name="unique_id"  id="unique_id2" value="">
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" id="delete_service_btn">Delete</button>
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
        let service = $(this).data('service');
        let cost = $(this).data('cost');
        $("#unique_id").val(unique_id);
        $("#service").val(service);
        $("#cost").val(cost);
      });
      $(".add_service").click(function(){
        $("#modal2").modal('show');
      });
      $(".delete_modal").click(function(){
        $("#modal3").modal('show');
        let unique_id = $(this).attr('id');
        $("#unique_id2").val(unique_id);
      });
    });
  </script>
</body>

</html>
