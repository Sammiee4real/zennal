<?php
//session_start();
include("../config/functions.php");
include("inc/header.php");
$admin_id =$_SESSION['admin_id'];
$admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
$get_interest = get_rows_from_one_table('installment_payment_interest','date_created');
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
          <h1 class="h3 mb-2 text-gray-800">Set Installment Payment Interest</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                  <thead class="thead-light">
                 <?php if($get_interest == null){
                    echo "<tr><td>No record found...</td></tr>";
                  } else{ ?>
                  <tr>
                    <th scope="col">Number of Month</th>
                    <th scope="col">Interest Rate (in percentage)</th>
                    <th scope="col">Date Created</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach($get_interest as $value){
                     ?>
                    <tr>
                      <td><?php echo $value['no_of_month'];?></td>
                      <td>
                        <?php echo $value['interest_rate'].'%';?>
                      </td>
                      <td>
                        <?php echo $value['date_created'];?>
                      </td>
                      <td>
                        <button type="button" class="btn btn-sm btn-primary edit_modal"
                        id="<?php echo $value['unique_id']?>"
                        data-no_of_month="<?php echo $value['no_of_month']?>"
                        data-interest_rate="<?php echo $value['interest_rate']?>"
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
            <h5 class="modal-title">Edit Percentage</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" id="edit_installment_interest_form">
              <div class="row justify-content-center">
                <div class="col-md-8 mt-3">
                  <label>Number of Month</label>
                  <input type="text" name="no_of_month" class="form-control" id="no_of_month" readonly="" required>
                </div>
                <div class="col-md-8 mt-3">
                  <label>Interest Rate (in percentage)</label>
                  <input type="text" name="interest_rate" class="form-control" id="interest_rate" required>
                </div>
              </div>
              <input type="hidden" name="unique_id"  id="unique_id" value="">
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="edit_installment_interest_btn">Edit</button>
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
        let no_of_month = $(this).data('no_of_month');
        let interest_rate = $(this).data('interest_rate');
        $("#unique_id").val(unique_id);
        $("#no_of_month").val(no_of_month);
        $("#interest_rate").val(interest_rate);
      });
    });
  </script>
</body>

</html>
