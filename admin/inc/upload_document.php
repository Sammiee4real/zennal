<?php
//session_start();
include("../config/database_functions.php");
include("inc/header.php");
$admin_id =$_SESSION['admin_id'];
$admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
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
          <h1 class="h3 mb-2 text-gray-800">Upload Document</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Documents</h6>
            </div>
            <div class="card-body">
              <form method="post" id="set_pricing_plan_form">
                <div class="row justify-content-center">
                  <div class="col-md-8 mt-3">
                    <label>Document Name</label>
                    <input type="text" name="document_name" id="document_name" class="form-control">
                     <span id="uploaded_image"></span>
                  </div>
                  <div class="col-md-8 mt-3">
                    <label>Document</label>
                    <input type="file" name="file" id="file" class="form-control">
                     <span id="uploaded_image"></span>
                  </div>
                  <input type="hidden" name="image" id="image">
                   <div class="col-md-8 mt-3">
                    <button type="button" class="btn btn-secondary" id="upload_document">Upload Document</button>
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
      $(document).on('click', '#upload_document', function(){
            var property = document.getElementById("file").files[0];
            var image_name = property.name;
            var image_size = property.size;
            var image_extension = image_name.split(".").pop().toLowerCase();
            if(jQuery.inArray(image_extension, ['png', 'jpg', 'jpeg', 'pdf', 'doc', 'docs', 'xls', 'csv']) == -1){
              alert("Invalid File");
              $('#uploaded_image').html("<label class='text_primary'><b>Image Upload failed, please try again</b></label>");
            }
            else if(image_size > 5000000){
              alert("Image File size is very big");
              $('#uploaded_image').html("<label class='text_primary'><b>Image Upload failed, please try again</b></label>");
            }else{
              var form_data = new FormData();
              form_data.append("file", property);
              $.ajax({
                url: "ajax_admin/upload_image2.php",
                method: "POST",
                data: form_data,
                contentType:false,
                cache:false,
                processData:false,
                beforeSend:function(){
                  $('#uploaded_image').html("<label class='text_primary'><b>Image Uploading, please wait...</b></label>");
                },
                success: function(data){
                  // $('#uploaded_image').html("<label class='text_success'><b>Image Uploaded</b></label>");
                  $('#image').val(data);
                  toastbox('success_toast', 5000);
                  setTimeout( function(){ window.location.href = "upload_document.php";}, 5000);
                }
              })
            }
        });
    });
  </script>
</body>

</html>
