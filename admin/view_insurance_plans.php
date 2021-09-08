<?php
//session_start();
include("../config/functions.php");
include("inc/header.php");
$admin_id =$_SESSION['admin_id'];
$admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
$get_insurance_plans = get_rows_from_one_table('insurance_plans','datetime');
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
          <h1 class="h3 mb-2 text-gray-800">Insurance Plans</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
              <span class="float-right">
                <button class="btn btn-primary btn-sm" id="add_insurance_plan">Add New Plan</button>
              </span>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                   <thead class="thead-light">
                 <?php if($get_insurance_plans == null){
                        echo "<tr><td>No record found...</td></tr>";
                      } else{ ?>
                  <tr>
                    
                    <th scope="col">Plan Name</th>
                    <th scope="col">Plan Value</th>
                    <th scope="col">Date Created</th>
                    <th>Action</th>

                  </tr>
                </thead>
                <tbody>
                  <?php

                   foreach($get_insurance_plans as $value){
                     ?>
                     <tr>
                        <td><?php echo $value['plan_name'];?></td>
                        <td><?php echo $value['plan_percentage'].'%';?></td>
                        <td>
                          <?php echo $value['datetime'];?>
                        </td>
                        <td>
                          <button 
                            class="btn btn-primary btn-sm edit_insurance_plan" 
                            type="button" id="<?php echo $value['unique_id'];?>" 
                            data-name="<?php echo $value['plan_name'];?>"
                            data-value="<?php echo $value['plan_percentage'];?>"
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
                            data-ref = "insurance_plans"
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
                <form method="post" id="edit_insurance_plan_form">
                  <div class="row justify-content-center">
                    <div class="col-md-10 mt-3">
                      <label>Plan Name</label>
                      <input type="text" name="plan_name" id="plan_name" class="form-control">
                    </div>
                    
                    <div class="col-md-10 mt-3">
                      <label>Plan Value <small>(In percentage)</small></label>
                      <input type="number" name="plan_percentage" id="plan_percentage" class="form-control">
                    </div>
                  </div>
                  <input type="hidden" name="plan_id"  id="plan_id" value="">
                  <input type="hidden" name="action"  id="action" value="update"/>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="edit_insurance_plan_btn">Edit</button>
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
                <h5 class="plan-plan">Delete ?</h5>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="delete_insurance_plan_btn">Confirm</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
              </div>
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
      $(".edit_insurance_plan").click(function(){
        $("#modal").modal('show');
        let plan_id = $(this).attr('id');
        let plan_name = $(this).data('name');
        let plan_value = $(this).data('value');

        $('#modal .modal-title').html('Edit Insurance plan');
        $('#edit_insurance_plan_btn').text('Edit');
        $('#action').val('update');
        // console.log(plan_name);
        $("#plan_id").val(plan_id);
        $("#plan_name").val(plan_name);
        $("#plan_percentage").val(plan_value);

      });

      $(".delete_insurance_plan").click(function(){
        let plan_id = $(this).attr('id');
        let plan_name = $(this).data('name');
        $("#delete_insurance_plan_btn").attr("data-planid", plan_id);
        $(".plan-plan").html(`Delete ${plan_name} plan?`);
        $("#delete-dialog").modal("show");
      });

      $('#add_insurance_plan').click(function(){
        $("#plan_id").val('');
        $("#plan_name").val('');
        $("#plan_percentage").val('');

        $('#modal .modal-title').html('Add Insurance plan');
        $('#edit_insurance_plan_btn').text('Add');
        $('#action').val('add');

        $('#modal').modal('show');
      })
    });
  </script>
</body>

</html>
