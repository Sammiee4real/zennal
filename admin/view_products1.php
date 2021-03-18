<?php
    include('inc/header.php');
    include('config/database_functions.php');
    //echo md5(uniqid());
    $vendor_id = isset($_GET['vendor_id']) ? $_GET['vendor_id'] : "";
    $get_products = get_rows_from_one_table_by_id('products','vendor_id', $vendor_id, 'date_created');
    $get_vendor = get_one_row_from_one_table_by_id('vendors', 'unique_id', $vendor_id, 'date_created');
?>


<body>

    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <!-- <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div> -->
        <div class="left" id="">
                <a href="javascript:;" class="headerButton ml-5" data-toggle="modal" data-target="#sidebarPanel">
                <div class="col">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
            </a>
        </div>
        <div class="pageTitle">Products Page</div>
        <div class="right">
            <a href="#" class="headerButton">
                <ion-icon name="star-outline"></ion-icon>
            </a>
        </div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">

        
        <div class="container">
            <div class="section full mt-2 mb-3">
                <div class="section-title mb-1 text-secondary">Available Products for <?php echo $get_vendor['name'];?></div>
                <div class="row">
                    <?php
                        if($get_products == null){
                            echo "<h6 class='text-primary'>No Product Available for this vendor, please check back later</h6>";
                        }else{
                            foreach ($get_products as $product) {
                    ?>
                    <div class="col-md-3">
                        <div class="item">
                            <div class="card product-card  card-stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <img src="<?php echo $product['image'];?>" class="image" alt="product image">
                                    <h2 class="title"><?php echo $product['product_name'];?></h2>
                                    <p class="text"><?php echo $product['description'];?></p>
                                    <div class="price">&#8358;<?php echo number_format($product['price'], 2);?></div>
                                    <div class="d-flex">
                                        <button class="btn btn-primary btn-sm edit_vendor" type="button" id="<?php echo $value['unique_id'];?>" data-name="<?php echo $value['name'];?>" data-description="<?php echo $value['description'];?>" data-website = "<?php echo $value['website_url'];?>">Edit</button>
                                        <button class="btn btn-danger btn-sm delete_vendor" type="button" id="<?php echo $value['unique_id'];?>">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } }?>
                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

   <!-- App Bottom Menu -->
     <?php include('inc/bottom_menu.php');?>
     <!-- *App Bottom Menu -->

      <!-- Footer -->
      <?php include("inc/footer.php");?>
      <!-- End of Footer -->

     <!-- App Sidebar -->
     <?php include('inc/sidebar.php');?>
     <!-- *App Sidebar -->
   <?php include('inc/scripts.php');?>   
</body>


</body>

</html>