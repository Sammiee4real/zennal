<?php
//session_start();
include("../config/functions.php");
include("inc/header.php");
$admin_id =$_SESSION['admin_id'];
$admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
$get_insurance_pricing_plans = get_rows_from_one_table('insurance_pricing_plans','date_created');
// $get_loan_categories = get_rows_from_one_table('loan_category','date_created');
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
          <h1 class="h3 mb-2 text-gray-800">Insurance Pricing Plans</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                   <thead class="thead-light">
                 <?php if($get_insurance_pricing_plans == null){
                        echo "<tr><td>No record found...</td></tr>";
                      } else{ ?>
                  <tr>
                    
                    <th scope="col">Plan Name</th>
                    <th scope="col">Plan Price</th>
                    <th scope="col">Description</th>
                    <th>Date Created</th>
                    <th>Action</th>

                  </tr>
                </thead>
                <tbody>
                  <?php

                   foreach($get_insurance_pricing_plans as $value){
                     ?>
                     <tr>
                        <td><?php echo $value['pricing_type'];?></td>
                        <td>&#8358;<?php echo number_format($value['plan_price']);?></td>
                        <td><?php echo $value['plan_description'];?></td>
                        <td>
                          <?php echo $value['date_created'];?>
                        </td>
                        <td>
                          <button class="btn btn-primary btn-sm edit_insurance_princing_plan" type="button" id="<?php echo $value['unique_id'];?>" data-name="<?php echo $value['pricing_type'];?>" data-price="<?php echo $value['plan_price'];?>" data-desc="<?php echo $value['plan_description'];?>">Edit</button>
                        </td>
                        <!-- <td>
                          <button class="btn btn-danger btn-sm delete_insurance_princing_plan" type="button" id="<?php //echo $value['unique_id'];?>" data-name="<?php echo $value['pricing_type'];?>">Delete</button>
                        </td> -->
                      </tr>
                    <?php } } ?>
                </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="modal" tabindex="-1" role="dialog" id="modal">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Edit Insurance</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="post" id="edit_insurance_pricing_plan_form">
                    <div class="row justify-content-center">
                      <div class="col-md-10 mt-3">
                        <label>Plan Plan</label>
                        <input type="text" name="pricing_type" id="pricing_type" class="form-control">
                      </div>
                    </div>
                    <div class="row justify-content-center">
                      <div class="col-md-10 mt-3">
                        <label>Plan Price</label>
                        <input type="text" name="plan_price" id="plan_price" class="form-control">
                      </div>
                    </div>
                    <div class="row justify-content-center">
                      <div class="col-md-10 mt-3">
                        <label>Description</label>
                        <textarea row="5" name="plan_description" id="plan_description" class="form-control"></textarea>
                      </div>
                    </div>
                    <input type="hidden" name="plan_id"  id="plan_id" value="">
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" id="edit_insurance_pricing_plan_btn">Edit</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
        <!-- /.container-fluid -->
          
          <!-- Delete Modal -->

        <div class="modal" tabindex="-1" role="dialog" id="delete-dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <!-- <div class="modal-header">
                <h5 class="modal-title">Edit Insurance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div> -->
              <div class="modal-body">
                <h5 class="pricing-plan">Delete ?</h5>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="delete_insurance_pricing_plan_btn">Confirm</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>


      </div>
      <!-- End of Main Content -->

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
      $(".edit_insurance_princing_plan").click(function(){
        $("#modal").modal('show');
        let plan_id = $(this).attr('id');
        let plan_name = $(this).data('name');
        let plan_price = $(this).data('price');
        let plan_desc = $(this).data('desc');
        // console.log(package_name);
        $("#plan_id").val(plan_id);
        $("#pricing_type").val(plan_name);
        $("#plan_price").val(plan_price);
        $("#plan_description").val(plan_desc);
      });

      $(".delete_insurance_princing_plan").click(function(){
        // alert(1)
        let plan_id = $(this).attr('id');
        let plan_name = $(this).data('name');
        $("#delete_insurance_pricing_plan_btn").attr("data-planid", plan_id);
        $(".pricing-plan").html(`Delete ${plan_name} plan?`);
        $("#delete-dialog").modal("show");
      });
    });
  </script>
</body>

</html>
