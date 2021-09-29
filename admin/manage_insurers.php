<?php
//session_start();
include("../config/functions.php");
include("inc/header.php");
$admin_id =$_SESSION['admin_id'];
$admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
$get_insurers = get_rows_from_one_table('insurers', 'datetime');
// $get_loan_categories = get_rows_from_one_table('loan_category','datetime');
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
          <h1 class="h3 mb-2 text-gray-800">Insurers</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
              <span class="float-right">
                <button class="btn btn-primary btn-sm" id="add_insurer">Add New Insurer</button>
              </span>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                   <thead class="thead-light">
                 <?php if($get_insurers == null){
                        echo "<tr><td>No record found...</td></tr>";
                      } else{ ?>
                  <tr>
                    
                    <th scope="col">Insurer Name</th>
                    <th scope="col">Date Created</th>
                    <th>Action</th>

                  </tr>
                </thead>
                <tbody>
                  <?php

                   foreach($get_insurers as $value){
                     ?>
                     <tr>
                        <td><?php echo $value['name'];?></td>
                        <td>
                          <?php echo $value['datetime'];?>
                        </td>
                        <td>
                          <button class="btn btn-primary btn-sm edit_insurer" type="button" id="<?php echo $value['unique_id'];?>" data-name="<?php echo $value['name'];?>">Edit</button>
                          
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
                            data-ref = "insurers"
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
                <form method="post" id="edit_insurer_form">
                  <div class="row justify-content-center">
                    <div class="col-md-10 mt-3">
                      <label>Insurer Name</label>
                      <input type="text" name="name" id="name" class="form-control">
                    </div>
                  </div>
                  <input type="hidden" name="insurer_id"  id="insurer_id" value="">
                  <input type="hidden" name="action"  id="action" value="update"/>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="edit_insurer_btn">Edit</button>
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
                <h5 class="insurer-plan">Delete ?</h5>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="delete_insurer_btn">Confirm</button>
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
      $(".edit_insurer").click(function(){
        $("#modal").modal('show');
        let insurer_id = $(this).attr('id');
        let name = $(this).data('name');

        $('#modal .modal-title').html('Edit Insurer');
        $('#edit_insurer_btn').text('Edit');
        $('#action').val('update');
        // console.log(name);
        $("#insurer_id").val(insurer_id);
        $("#name").val(name);
      });

      $(".delete_insurer").click(function(){
        let insurer_id = $(this).attr('id');
        let name = $(this).data('name');
        $("#delete_insurer_btn").attr("data-insurerid", insurer_id);
        $(".insurer-plan").html(`Delete ${name} insurer?`);
        $("#delete-dialog").modal("show");
      });

      $('#add_insurer').click(function(){
        $("#insurer_id").val('');
        $("#name").val('');

        $('#modal .modal-title').html('Add Insurer');
        $('#edit_insurer_btn').text('Add');
        $('#action').val('add');

        $('#modal').modal('show');
      })
    });
  </script>
</body>

</html>
