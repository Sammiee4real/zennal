<?php
//session_start();
include("../config/functions.php");
include("inc/header.php");
$admin_id =$_SESSION['admin_id'];
$admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
$get_loan_requests = get_rows_from_one_table_by_id('personal_loan_application','approval_status', 0 , 'date_created');
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
          <h1 class="h3 mb-2 text-gray-800">Loan Applications</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                  <thead class="thead-light">
                 <?php if($get_loan_requests == null){
                        echo "<tr><td>No record found...</td></tr>";
                      } else{ ?>
                  <tr>
                    
                    <th scope="col">Fullname</th>
                    <th scope="col">Amount Requested for</th>
                    <th scope="col">Loan Purpose</th>
                    <th scope="col">Bank Statement</th>
                    <th scope="col">Date of Application</th>
                    <th>Action</th>

                  </tr>
                </thead>
                <tbody>
                  <?php

                   foreach($get_loan_requests as $value){
                    $get_user = get_one_row_from_one_table_by_id('users','unique_id', $value['user_id'], 'registered_on');
                     ?>
                     <tr>
                        <td><?php echo $get_user['first_name'].' '.$get_user['last_name'];?></td>
                        <td>
                            &#8358; <?php echo number_format($value['user_selection_amount']);?>
                        </td>
                        <td>
                            <?php echo $value['loan_purpose']; ?>
                        </td>
                        <td>
                          <?php
                           //if($value['bank_statement'] == ''){
                              //$bank_statement = beautify_statement($value['unique_id']);
                          ?>
                             <!--  <a  class="thumbnail fancybox" rel="ligthbox" href="../bank_statement/<?php //echo $value['unique_id'].'.pdf';?>">Bank Statement <small>(click to view)</small></a> -->
                           <?php //}else{ 
                          ?>
                           <a  class="thumbnail fancybox" rel="ligthbox" href="<?php echo $value['bank_statement']?>">Bank Statement <small>(click to view)</small></a>
                         <?php //} ?>
                        </td>
                        <td>
                          <?php echo $value['date_created'];?>
                        </td>
                        <td>
                          <?php $loan_interest = $value['loan_interest'];?>
                          <button type="button" class="btn btn-success btn-sm accept_app_modal" type="button" id="<?php echo $value['unique_id'];?>" data-interest="<?php echo $loan_interest;?>">Approve</button>
                          <button type="button" class="btn btn-danger btn-sm decline_app_modal" type="button" id="<?php echo $value['unique_id'];?>">Reject</button>
                        </td>
                      </tr>
                    <?php } } ?>
                </tbody>
                </table>
              </div>
            </div>
            <div class="modal" tabindex="-1" role="dialog" id="modal">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Approve Loan Application</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="post" id="accept_loan_application_form">
                    <div class="row justify-content-center">
                      <div class="col-md-10">
                        <label>Minimum Approval Amount</label>
                        <input type="number" name="admin_selection_amount_min" id="admin_selection_amount_min" class="form-control">
                      </div>
                      <div class="col-md-10">
                        <label>Maximum Approval Amount</label>
                        <input type="number" name="admin_selection_amount_max" id="admin_selection_amount_max" class="form-control">
                      </div>
                      <div class="col-md-10 mt-3">
                        <label>Interest per Month (in percentage)</label>
                        <input type="text" name="loan_interest" id="loan_interest" class="form-control">
                      </div>
                    </div>
                    <input type="hidden" name="unique_id"  id="unique_id" value="">
                    <input type="hidden" name="approval_status"  id="approval_status" value="1">
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" id="accept_loan_application_btn">Approve</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

          <div class="modal" tabindex="-1" role="dialog" id="modal2">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Reject Loan Application</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Are you sure you want to reject this loan application?</p>
                  <form method="post" id="reject_loan_application_form">
                    <input type="hidden" name="unique_id"  id="unique_id2" value="">
                    <input type="hidden" name="approval_status"  id="approval_status" value="2">
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" id="reject_loan_application_btn">Yes</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
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
       $(".fancybox").fancybox({
          openEffect: "none",
          closeEffect: "none"
      });
      $(".accept_app_modal").click(function(){
        $("#modal").modal('show');
        let unique_id = $(this).attr('id');
        let loan_interest = $(this).data('interest');
        //console.log(id);
        $("#unique_id").val(unique_id);
        $("#loan_interest").val(loan_interest);
      });
      $(".decline_app_modal").click(function(){
        $("#modal2").modal('show');
        let unique_id = $(this).attr('id');
        //console.log(id);
        $("#unique_id2").val(unique_id);
      });
    });
  </script>
</body>

</html>
