<?php
//session_start();
include("../config/functions.php");
include("inc/header.php");
$admin_id =$_SESSION['admin_id'];
$admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
$vendor_id = isset($_GET['vendor_id']) ? $_GET['vendor_id'] : "";
$get_products = get_rows_from_one_table_by_id('products','vendor_id', $vendor_id, 'date_created');
$get_vendor = get_one_row_from_one_table_by_id('vendors', 'unique_id', $vendor_id, 'date_created');
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
          <h1 class="h3 mb-2 text-gray-800">Available Products for <?php echo $get_vendor['name'];?></h1>

          <div class="row">
                    <?php
                        if($get_products == null){
                            echo "<h5 class='text-primary'>No Product Available for this vendor, please check back later</h5>";
                        }else{
                            foreach ($get_products as $product) {
                    ?>
                    <div class="col-md-3">
                        <div class="item">
                            <div class="card product-card  card-stats mb-4 mb-xl-0" style="min-height: 441px;">
                                <div class="card-body">
                                    <img src="<?php echo "admin/".$product['image'];?>" class="image" alt="product image">
                                    <h2 class="title"><?php echo $product['product_name'];?></h2>
                                    <p class="text"><?php echo $product['description'];?></p>
                                    <div class="price">&#8358;<?php echo number_format($product['price'], 2);?></div>
                                    <div class="d-flex">
                                        <button class="btn btn-primary btn-sm edit_product" type="button" id="<?php echo $product['unique_id'];?>" data-name="<?php echo $product['product_name'];?>" data-description="<?php echo $product['description'];?>" data-price = "<?php echo $product['price'];?>"> Edit </button>
                                         | <button class="btn btn-danger btn-sm delete_product" type="button" id="<?php echo $product['unique_id'];?>"> Delete </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } }?>
                </div>
        </div>
        <div class="modal" tabindex="-1" role="dialog" id="modal">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Edit Product</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="post" id="edit_product_form">
                    <div class="row justify-content-center">
                      <div class="col-md-10 mt-3">
                        <label>Product Name</label>
                        <input type="text" name="product_name" id="product_name" class="form-control">
                      </div>
                      <div class="col-md-10 mt-3">
                        <label>Description</label>
                        <textarea class="form-control" rows="4" name="description" id="description"></textarea>
                      </div>
                      <div class="col-md-10 mt-3">
                        <label>Price</label>
                        <input type="number" name="price" id="price" class="form-control">
                      </div>
                    </div>
                    <input type="hidden" name="product_id"  id="product_id" value="">
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" id="edit_product_btn">Edit</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>


          <div class="modal" tabindex="-1" role="dialog" id="modal2">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Delete Product</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  Are you sure you want to delete this product?
                  <form method="post" id="delete_product_form">
                    <input type="hidden" name="product_id2"  id="product_id2" value="">
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" id="delete_product_btn">Delete</button>
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
      $(".edit_product").click(function(){
        $("#modal").modal('show');
        let product_id = $(this).attr('id');
        let name = $(this).data('name');
        let description = $(this).data('description');
        let price = $(this).data('price');
        $("#product_id").val(product_id);
        $("#product_name").val(name);
        $("#description").val(description);
        $("#price").val(price);
      });
      $(".delete_product").click(function(){
        $("#modal2").modal('show');
        let product_id = $(this).attr('id');
        //console.log(id);
        $("#product_id2").val(product_id);
      });
    });
  </script>
</body>

</html>
