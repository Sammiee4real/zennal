<?php
//session_start();
include("../config/functions.php");
include("inc/header.php");
$admin_id =$_SESSION['admin_id'];
$admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
$get_vendors = get_rows_from_one_table('vendors','date_created');
$get_loan_categories = get_rows_from_one_table('loan_category','date_created');
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
          <h1 class="h3 mb-2 text-gray-800">Available Vendors</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                   <thead class="thead-light">
                 <?php if($get_vendors == null){
                        echo "<tr><td>No record found...</td></tr>";
                      } else{ ?>
                  <tr>
                    
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                     <th scope="col">Website URL</th>
                    <th scope="col">Created By</th>
                    <th scope="col">Date Created</th>
                    <th>Action</th>

                  </tr>
                </thead>
                <tbody>
                  <?php

                   foreach($get_vendors as $value){
                    $get_admin = get_one_row_from_one_table_by_id('admin','unique_id',$value['created_by'], 'date_created');
                     ?>
                     <tr>
                        <td><?php echo $value['name'];?></td>
                        <td>
                            <?php echo $value['description'];?>
                        </td>
                        <td>
                          <a href="<?php echo $value['website_url'];?>"><?php echo $value['website_url'];?></a>
                        </td>
                        <td>
                          <?php echo $get_admin['fullname'];?>
                        </td>
                        <td>
                          <?php echo $value['date_created'];?>
                        </td>
                        <td>
                          <a href="view_products.php?vendor_id=<?php echo $value['unique_id'];?>" class="btn btn-success btn-sm">View Products</a>
                          <?php
                            if($admin_id == $value['created_by']){
                          ?>
                          <button class="btn btn-primary btn-sm edit_vendor" type="button" id="<?php echo $value['unique_id'];?>" data-name="<?php echo $value['name'];?>" data-description="<?php echo $value['description'];?>" data-website = "<?php echo $value['website_url'];?>">Edit</button>
                          <button class="btn btn-danger btn-sm delete_vendor" type="button" id="<?php echo $value['unique_id'];?>">Delete</button>
                        <?php }?>
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
                  <h5 class="modal-title">Edit Vendor</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="post" id="edit_vendor_form">
                    <div class="row justify-content-center">
                      <div class="col-md-10 mt-3">
                        <label>Name</label>
                        <input type="text" name="name" id="name" class="form-control">
                      </div>
                      <div class="col-md-10 mt-3">
                        <label>Description</label>
                        <textarea class="form-control" rows="5" name="description" id="description"></textarea>
                      </div>
                      <div class="col-md-10 mt-3">
                        <label>Website Url</label>
                        <input type="text" name="website_url" id="website_url" class="form-control">
                      </div>
                    </div>
                    <input type="hidden" name="vendor_id"  id="vendor_id" value="">
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" id="edit_vendor_btn">Edit</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>


          <div class="modal" tabindex="-1" role="dialog" id="modal2">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Delete Vendor</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  Are you sure you want to delete this vendor?
                  <form method="post" id="delete_vendor_form">
                    <input type="hidden" name="vendor_id"  id="vendor_id2" value="">
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" id="delete_vendor_btn">Delete</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <?php include("inc/scripts.php");?>
  <script>
    $(document).ready(function(){
      $(".edit_vendor").click(function(){
        $("#modal").modal('show');
        let vendor_id = $(this).attr('id');
        let name = $(this).data('name');
        let description = $(this).data('description');
        let website = $(this).data('website');
        $("#vendor_id").val(vendor_id);
        $("#name").val(name);
        $("#description").val(description);
        $("#website_url").val(website);
      });
      $(".delete_vendor").click(function(){
        $("#modal2").modal('show');
        let vendor_id = $(this).attr('id');
        //console.log(id);
        $("#vendor_id2").val(vendor_id);
      });
    });
  </script>
</body>

</html>
