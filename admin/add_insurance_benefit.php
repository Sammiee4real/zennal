<?php
//session_start();
include("../config/functions.php");
include("inc/header.php");
$admin_id =$_SESSION['admin_id'];
$admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
$get_insurers = get_rows_form_table('insurers');
//$get_users_employment = get_one_row_from_one_table_by_id('user_employment_details','user_id', $user_id, 'date_created');
//$get_loan_category = get_rows_from_one_table('loan_category','date_created');
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
          <h1 class="h3 mb-2 text-gray-800">Insurance Benefit</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Add Insurance Benefit</h6>
            </div>
            <div class="card-body">
              <form method="post" id="insurance_benefit_form">
                <div class="row justify-content-center">
                    <div class="col-md-8 mt-3">
                        <label>Benefit Name</label>
                        <input type="text" name="benefit_name" class="form-control" placeholder="Enter benefit" required>
                     </div>

                     <div class="col-md-8 mt-3">
                      <label>Insurer</label>
                      <select type="text" name="insurer_id" id="insurer_id" class="form-control" required>
                        <option value="">Select Insurer</option>
                        <?php
                          foreach($get_insurers as $insurer){
                            echo "<option value='".$insurer['unique_id']."'>".$insurer['name']."</option>";
                          }
                        ?>
                      </select>
                    </div>
                </div>
                <div class="row justify-content-center insurance-plans">
                  
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-8 mt-3">
                        <button type="type" class="btn btn-secondary" id="add_insurance_benefit">Add Benefit</button>
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
        const insurancePlan = {};
        let insurancePlansContainer = $(".insurance-plans");

        $("#insurer_id").change(function(){
          insurancePlansContainer.html("");
          const insurerId = $(this)[0]['value'];
          $.get("ajax_admin/get_insurance_plans.php", {insurerId}, function(data, status){
            let retData = JSON.parse(data);
            
            retData.map(arrayItem => {
                let planName = arrayItem.plan_name;
                let planId = arrayItem.unique_id;
                insurancePlan[planName]=planId;
                insurancePlansContainer.append(`
                    <div class="col-md-8 mt-3">
                        <label>${planName}</label>
                        <select type="text" name='status_${planId}' class="form-control" required>
                          <option>Select status</option>
                          <option value="1">Covered</option>
                          <option value="0">Unovered</option>
                        </select>
                      </div>
                      <div class="col-md-8 mt-3">
                        <label>Narration (optional)</label>
                        <input type="text" name='narr_${planId}' class="form-control" placeholder="Enter narration">
                      </div>
                `);
            });
        });
        })
    })
      
      
  </script>
</body>

</html>
