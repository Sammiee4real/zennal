<?php
//session_start();
include("../config/database_functions.php");
include("inc/header.php");
$admin_id =$_SESSION['admin_id'];
$admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
//$get_users_employment = get_one_row_from_one_table_by_id('user_employment_details','user_id', $user_id, 'date_created');
$get_vendors = get_rows_from_one_table('vendors','date_created');
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
          <h1 class="h3 mb-2 text-gray-800">Add Product</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Product</h6>
            </div>
            <div class="card-body">
              <form method="post" id="add_product_form">
                <div class="row justify-content-center">
                  <div class="col-md-8">
                    <label>Select Vendor</label>
                    <select name="vendor_id" class="form-control">
                      <option value="">Select a vendor</option>
                      <?php
                        foreach ($get_vendors as $value) {
                      ?>
                      <option value="<?php echo $value['unique_id'];?>"><?php echo $value['name'];?></option>
                          <?php
                        }
                      ?>
                    </select>
                  </div>
                  <div class="col-md-8 mt-3">
                    <label>Product Name</label>
                    <input type="text" name="product_name" class="form-control">
                  </div>
                  <div class="col-md-8 mt-3">
                    <label>Description</label>
                    <textarea class="form-control" rows="5" name="description"></textarea>
                  </div>
                  <div class="col-md-8 mt-3">
                    <label>Price (in naira)</label>
                    <input type="number" name="price" class="form-control">
                  </div>
                  <div class="col-md-8 mt-3">
                    <label>Product Image</label>
                    <input type="file" id="file" name="file" class="form-control">
                    <span id="uploaded_image"></span>
                  </div>
                  <input type="hidden" name="image" id="image">
                  <div class="col-md-8 mt-3">
                    <button type="button" class="btn btn-secondary" id="add_product">Add Product</button>
                  </div>
                </div>
              </form>
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
      $(document).on('change', '#file', function(){
            var property = document.getElementById("file").files[0];
            var image_name = property.name;
            var image_size = property.size;
            var image_extension = image_name.split(".").pop().toLowerCase();
            if(jQuery.inArray(image_extension, ['png', 'jpg', 'jpeg']) == -1){
              alert("Invalid Image File");
              $('#uploaded_image').html("<label class='text_primary'><b>Image Upload failed, please try again</b></label>");
            }
            else if(image_size > 5000000){
              alert("Image File size is very big");
              $('#uploaded_image').html("<label class='text_primary'><b>Image Upload failed, please try again</b></label>");
            }else{
              var form_data = new FormData();
              form_data.append("file", property);
              $.ajax({
                url: "ajax_admin/upload_image.php",
                method: "POST",
                data: form_data,
                contentType:false,
                cache:false,
                processData:false,
                beforeSend:function(){
                  $('#uploaded_image').html("<label class='text_primary'><b>Image Uploading, please wait...</b></label>");
                },
                success: function(data){
                  $('#uploaded_image').html("<label class='text_success'><b>Image Uploaded</b></label>");
                  $('#image').val(data);
                }
              })
            }
        });
    });
  </script>
</body>

</html>
