<?php
  //session_start();
  include("../config/functions.php");
  include("inc/header.php");
  $admin_id =$_SESSION['admin_id'];
  $admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
 
  $installment_months = get_rows_from_one_table('installment_months','date_created');
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
          <h1 class="h3 mb-2 text-gray-800">Manage Installment Months</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <!-- Button trigger modal -->
                <!-- <button type="button" class="btn btn-info btn-sm float-right mb-4" data-toggle="modal" data-target="#exampleModal">
                  Add Installmental Months
                </button> -->

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Installment Month</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form method="post" id="set_coupon_code_form">
                          <div class="row justify-content-center">
                            <div class="col-md-8 mt-3">
                              <label>Select Month</label>
                              <!-- <input type="text" name="coupon_code" class="form-control" required> -->
                              <select name="ins_month" class="form-control" required="">
                                <option value="">select a month</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                              </select>
                            </div>
                            <div class="col-md-8 mt-3">
                              <label>Interest</label>
                              <input type="number" name="ins_interest" id="ins_interest" class="form-control" required>
                            </div>
                            <div class="col-md-8 mt-3">
                              <label>Visibility</label>
                                <select class="form-control" required="">
                                <option value="">select visibility option</option>
                                <option value="0">hide</option>
                                <option value="1">show</option>
                              </select>
                            </div>
                          </div>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="set_coupon_code_btn">Add Installment Month</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                  <thead class="thead-light">
                 <?php if($installment_months == null){
                      echo "<tr><td>No record found...</td></tr>";
                    } else{ 
                  ?>
                  <tr>
                    
                    <th scope="col">Month</th>
                    <th scope="col">Interest per month</th>
                    <th>Added By</th>
                    <th>Date Created</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                   foreach($installment_months as $value){
                        $adminidd = $value['added_by'];
                        $get_admin_det = get_one_row_from_one_table('admin', 'unique_id', $adminidd);

                        $admin_fullname = $get_admin_det['fullname'];
                        
                     ?>
                     <tr>
                        <td><?php echo $value['month'] == 1 ? $value['month']. ' month': $value['month'] .' months';?>
                        </td>
                        <td>
                           <?php echo number_format($value['interest_per_month'],2).'%';?>
                        </td>
                        <td><?php echo $admin_fullname;?></td>
                        <td><?php echo $value['date_created'];?></td>
                        <td>
                          <button type="button" class="btn btn-sm btn-primary edit_modal" 
                          id="<?php echo $value['unique_id']?>" 
                          data-coupon_code="<?php echo $value['coupon_code']?>" 
                          data-discount="<?php echo $value['discount']?>">Edit</button>
                          <button type="button" class="btn btn-sm btn-danger delete_modal" 
                          id="<?php echo $value['unique_id']?>">Delete</button>
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

      <div class="modal" tabindex="-1" role="dialog" id="modal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Installment Months</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="post" id="edit_installment_months_form">
                <div class="row justify-content-center">
                  <div class="col-md-8 mt-3">
                    <label>Month</label>
                    <input type="number" name="month_title" class="form-control" id="month_title" required>
                  </div>
                  <div class="col-md-8 mt-3">
                    <label>Visibility</label>
                   
                    <select name="visibility" id="visibility" class="form-control">
                         <option value="">select an option</option>
                         <option value="0">hide</option>
                         <option value="1">show</option>
                    </select>
                  </div>
                  <div class="col-md-8 mt-3">
                    <label>Interest per Month</label>
                    <input type="number" name="interest_per_month" class="form-control" id="interest_per_month" required>
                  </div>
                </div>
                <input type="hidden" name="unique_id"  id="unique_id" value="">
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" id="edit_installment_month_btn">Edit</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal" tabindex="-1" role="dialog" id="modal2">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Delete Coupon Code</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Are you sure you want to delete?
            </div>
            <form method="post" id="delete_coupon_code_form">
              <input type="hidden" name="unique_id"  id="unique_id2" value="">
            </form>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" id="delete_coupon_code_btn">Yes</button>
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
        let month_title = $(this).data('month_title');
        let visibility = $(this).data('visibility');
        let interest_per_month = $(this).data('interest_per_month');
        $("#unique_id").val(unique_id);
        $("#month_title").val(month_title);
        $("#visibility").val(visibility);
        $("#interest_per_month").val(interest_per_month);
      });
      $(".delete_modal").click(function(){
        $("#modal2").modal('show');
        let unique_id = $(this).attr('id');
        $("#unique_id2").val(unique_id);
      });
    });
  </script>
</body>

</html>
