<?php
//session_start();
include("../config/functions.php");
include("inc/header.php");
$admin_id =$_SESSION['admin_id'];
$admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
$get_insurance = get_rows_from_one_table('insurance','datetime');
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
          <h1 class="h3 mb-2 text-gray-800">Insurance Purchased</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                   <thead class="thead-light">
                 <?php if($get_insurance == null){
                        echo "<tr><td>No record found...</td></tr>";
                      } else{ ?>
                  <tr>
                    
                    <th scope="col">Fullname</th>
                    <th scope="col">Insurance Package</th>
                    <th scope="col">Insurance Pricing Plan</th>
                    <!-- <th scope="col">Insurance Payment Plan</th> -->
                    <th scope="col">Date of Application</th>

                  </tr>
                </thead>
                <tbody>
                  <?php

                   foreach($get_insurance as $value){
                    $get_user = get_one_row_from_one_table_by_id('users','unique_id', $value['user_id'], 'registered_on');
                    $get_insurance_package = get_one_row_from_one_table_by_id('insurance_packages','unique_id',$value['insurance_package'], 'date_created');
                    $get_insurance_pricing = get_one_row_from_one_table_by_id('insurance_pricing_plans','unique_id', $value['insurance_pricing_plan'], 'date_created');
                     ?>
                     <tr>
                        <td><?php echo $get_user['first_name'].' '.$get_user['last_name'];?></td>
                        <td>
                            <?php echo $get_insurance_package['package_name'];?>
                        </td>
                        <td>
                            <?php echo $get_insurance_pricing['pricing_type'];?>
                        </td>
                        <!-- <td>
                          <?php //echo $value['insurance_payment_plan']." Months";?>
                        </td> -->
                        <td>
                          <?php echo $value['datetime'];?>
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
      $(".disable_user_modal").click(function(){
        $("#modal").modal('show');
        let user_id = $(this).attr('id');
        //console.log(id);
        $("#user_id").val(user_id);
      });
      $(".enable_user_modal").click(function(){
        $("#modal2").modal('show');
        let user_id = $(this).attr('id');
        //console.log(id);
        $("#user_id2").val(user_id);
      });
    });
  </script>
</body>

</html>
