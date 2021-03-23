<?php
//session_start();
include("../config/functions.php");
include("inc/header.php");
$admin_id =$_SESSION['admin_id'];
$admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
$get_documents = get_rows_from_one_table_by_id('admin_document','admin_id', $admin_id, 'date_created');
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
          <h1 class="h3 mb-2 text-gray-800">Your Uploaded Document</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                   <thead class="thead-light">
                 <?php if($get_documents == null){
                        echo "<tr><td>No record found...</td></tr>";
                      } else{ ?>
                  <tr>
                    
                    <th scope="col">Document Name</th>
                    <th scope="col">Document URL</th>
                    <th scope="col">Date Created</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                   foreach($get_documents as $value){
                     ?>
                     <tr>
                        <td><?php echo $value['document_name'];?></td>
                        <td>
                          <a class="thumbnail fancybox" rel="ligthbox" href="<?php echo 'admin/'.$value['document_url'];?>"><?php echo $value['document_url'];?></a>
                        </td>
                        <td>
                          <?php echo $value['date_created'];?>
                        </td>
                        <td>
                          <button type="button" class="btn btn-danger btn-sm delete_document_modal" id="<?php echo $value['unique_id'];?>" data-document = "<?php echo $value['document_url'];?>"><i class="fa fa-trash"></i></button>
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
                  <h5 class="modal-title">Delete Document</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Are you sure you want to delete this document?</p>
                  <form method="post" id="delete_document_form">
                    <input type="hidden" name="document_id"  id="document_id" value="">
                    <input type="hidden" name="document_url"  id="document_url" value="">
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" id="delete_document">Yes</button>
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
    //FANCYBOX
    //https://github.com/fancyapps/fancyBox
    $(".fancybox").fancybox({
        openEffect: "none",
        closeEffect: "none"
    });

    $(".delete_document_modal").click(function(){
      $("#modal").modal('show');
      let document_id = $(this).attr('id');
      let document_url = $(this).data('document');
      //console.log(id);
      $("#document_id").val(document_id);
      $("#document_url").val(document_url);
    });
});
  </script>
</body>

</html>
