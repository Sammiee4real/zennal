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
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-info btn-sm float-right mb-4" data-toggle="modal" data-target="#exampleModal">
                  Add New Installment Plan
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Installment Plan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form method="post" id="add_installment_form">
                          <div class="row justify-content-center">
                            <div class="col-md-8 mt-3">
                              <label>Number of Months</label>
                              <input type="number" name="no_of_month" class="form-control" required>
                            </div>
                            <div class="col-md-8 mt-3">
                              <label>Interest Rate (in %)</label>
                              <input type="number" name="interest_rate" class="form-control" required>
                            </div>
                            <div class="col-md-8 mt-3">
                              <label>Status</label>
                              <select name="status" id="status" class="form-control">
                                <option value="0">Hide</option>
                                <option value="1">Show</option>
                              </select>
                            </div>
                          </div>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="add_installment_btn">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>



                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                  <thead class="thead-light">
                 <?php if($get_interest == null){
                    echo "<tr><td>No record found...</td></tr>";
                  } else{ ?>
                  <tr>
                    <th scope="col">Number of Month</th>
                    <th scope="col">Interest Rate (in percentage)</th>
                    <th>Status</th>
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
                        <?php
                          if($value['status'] == 1){
                            echo "<small class='badge badge-success'>Visible</small>";
                          }
                          else if($value['status'] == 0){
                            echo "<small class='badge badge-danger'>Hidden</small>";
                          }
                        ?>
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

    <div class="modal" tabindex="-1" role="dialog" id="modal1">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Hide Installment Payment</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Are you sure you want to hide?
            <form method="post" id="hide_installment_interest_form">
              <input type="hidden" name="unique_id"  id="unique_id1" value="">
              <input type="hidden" name="status" id="status" value="0">
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" id="hide_installment_interest_btn">Hide</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="modal2">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Show Installment Payment</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Are you sure you want to show?
            <form method="post" id="show_installment_interest_form">
              <input type="hidden" name="unique_id"  id="unique_id2" value="">
              <input type="hidden" name="status" id="status" value="1">
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" id="show_installment_interest_btn">Show</button>
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
