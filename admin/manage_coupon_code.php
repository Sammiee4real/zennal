<?php
  //session_start();
  include("../config/functions.php");
  include("inc/header.php");
  $admin_id =$_SESSION['admin_id'];
  $admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
  $get_coupon_code = get_rows_from_one_table('coupon_code','date_created');
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
          <h1 class="h3 mb-2 text-gray-800">Available Coupon Codes</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-info btn-sm float-right mb-4" data-toggle="modal" data-target="#exampleModal">
                  Add New Code
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Coupon Code</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form method="post" id="set_coupon_code_form">
                          <div class="row justify-content-center">
                            <div class="col-md-8 mt-3">
                              <label>Coupon Code</label>
                              <input type="text" name="coupon_code" class="form-control" required>
                            </div>
                            <div class="col-md-8 mt-3">
                              <label>Discount</label>
                              <input type="number" name="discount" class="form-control" required>
                            </div>
                            <div class="col-md-8 mt-3">
                              <label>Transaction Type</label>
                              <select name="insurance_type" id="insurance_type" class="form-control">
                                <option value="">Select . . .</option>
                                <option value="comprehensive_insurance">Comprehensive Insurance</option>
                                <option value="third_party_insurance">Third Party Insurance</option>
                              </select>
                            </div>
                            <div class="col-md-8 mt-3">
                              <label>Expiry Date</label>
                              <input type="date" name="expiry_date" class="form-control" required>
                            </div>
                          </div>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="set_coupon_code_btn">Add Coupon Code</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                  <thead class="thead-light">
                 <?php if($get_coupon_code == null){
                      echo "<tr><td>No record found...</td></tr>";
                    } else{ 
                  ?>
                  <tr>
                    
                    <th scope="col">Coupon Code</th>
                    <th scope="col">Discount</th>
                    <th>Date Created</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                   foreach($get_coupon_code as $value){
                     ?>
                     <tr>
                        <td><?php echo $value['coupon_code']?>
                        </td>
                        <td>
                          &#8358;<?php echo number_format($value['discount']);?>
                        </td>
                        <td><?php echo $value['date_created'];?></td>
                        <td>
                          <button type="button" class="btn btn-sm btn-primary edit_modal" 
                          id="<?php echo $value['unique_id']?>" 
                          data-coupon_code="<?php echo $value['coupon_code']?>" 
                          data-discount="<?php echo $value['discount']?>"
                          data-insurance="<?php echo $value['insurance_type']?>"
                          data-insurance_val="<?=ucwords(str_replace('_', ' ', $value['insurance_type']))?>"
                          data-expiry="<?php echo $value['expiry_date']?>"
                          >Edit</button>

                          <?php
                          if($value['is_active'] == 1){
                            $status = 'inactive';
                            $text = 'Hide';
                          }else{
                            $status = 'active';
                            $text = 'Show';
                          }
                        ?>

                          <button 
                            class="btn <?=$status=='inactive'?'btn-danger':'btn-success';?> btn-sm change_status" 
                            type="button" 
                            id="insurace_status<?=$value['unique_id']?>"
                            data-id="<?php echo $value['unique_id'];?>"
                            data-status = "<?=$status?>"
                            data-ref = "coupon_code"
                          ><?=$text?></button>

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
              <h5 class="modal-title">Edit Coupon Code</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="post" id="edit_coupon_code_form">
                <div class="row justify-content-center">
                  <div class="col-md-8 mt-3">
                    <label>Coupon Code</label>
                    <input type="text" name="coupon_code" class="form-control" id="coupon_code" required>
                  </div>
                  <div class="col-md-8 mt-3">
                    <label>Discount</label>
                    <input type="number" name="discount" class="form-control" id="discount" required>
                  </div>
                  <div class="col-md-8 mt-3">
                    <label>Transaction Type</label>
                    <select name="insurance_type" id="insurance_type" class="form-control">
                      <option value="" id="ins_val"></option>
                      <option value="comprehensive_insurance">Comprehensive Insurance</option>
                      <option value="third_party_insurance">Third Party Insurance</option>
                    </select>
                  </div>
                  <div class="col-md-8 mt-3">
                    <label>Expiry Date</label>
                    <input type="date" name="expiry_date" id="expiry_date" class="form-control" required>
                  </div>
                </div>
                <input type="hidden" name="unique_id"  id="unique_id" value="">
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" id="edit_coupon_code_btn">Edit</button>
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
        let coupon_code = $(this).data('coupon_code');
        let discount = $(this).data('discount');
        let ins_val = $(this).data('insurance_val');
        let insurance = $(this).data('insurance');
        let expiry = $(this).data('expiry');
        $("#unique_id").val(unique_id);
        $("#coupon_code").val(coupon_code);
        $("#discount").val(discount);
        $("#ins_val").val(insurance);
        $("#ins_val").text(ins_val);
        $("#expiry_date").val(expiry);
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
