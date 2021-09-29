<?php
//session_start();
include("../config/functions.php");
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
          <h1 class="h3 mb-2 text-gray-800">Reports Viewer</h1>

          <!-- DataTales Example -->
          <form id="search_reports_form">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Search Reports</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="keyword">Keywords</label>
                                <select name="keyword" id="keyword" class="form-control" style="text-transform: capitalize;" required>
                                    <option value="">Search keyword . . .</option>
                                    <option value="1">overdue loans</option>
                                    <option value="2">Disbursement log-loans</option>
                                    <option value="3">repaid loans</option>
                                    <option value="4">loans approved but not disbursed</option>
                                    <option selected value="5">Vehicle Registration processed</option>
                                    <option value="6">Vehicle particulars processed</option>
                                    <option value="7">Vehicle Insurance processed</option>
                                    <!-- <option value="8">Disbursement log-instalments-insurance/vehicle</option> -->
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="start_date">Start Date</label>
                                <input type="date" value="<?=date('Y-m-d', strtotime(date('Y-m-d').' - 2 years'));?>" name="start_date" class="form-control" placeholder="Start Date" required/>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="end_date">End Date</label>
                                <input type="date" value="<?=date('Y-m-d', strtotime(date('Y-m-d').' + 1 year'));?>" name="end_date" class="form-control" placeholder="End Date" required/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" name="search" id="search_reports_button" class="btn btn-primary btn-sm btn-block">
                        <i class="fa fa-file-alt"></i> Search Report
                    </button>
                </div>
            </div>
          </form>


            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Search Result</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="dataTable"></table>
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
</body>

</html>
<script>
    $(document).ready(function(){
        $('#search_reports_form').submit(function(e){
            e.preventDefault();

            var keyword = $('#keyword').val();

            ref = getRef(keyword);

            $.ajax({
                url: 'reports/'+ref+'.php',
                method:'post',
                data:$(this).serialize(),
                beforeSend: function(){
                    $('title').html('Zenal App');
                    $('.table-responsive').html('<table class="table" id="dataTable"></table>');
                },
                success:function(data){
                    $('.table').html(data);

                    var header = '';
                    
                    for(i = 1; i<=10; i++) ref = ref.replace('_', ' ').toUpperCase();

                    header = ref;

                    $('title').html(header);

                    $('#dataTable').dataTable({
                        dom: 'lBfrtip',
                        buttons: [
                            'csv', 'excel', 'print'
                        ]
                    });
                }
            })
        })

        $('.table').change(function(){
            console.log('table changed');
            $('#dataTable').dataTable();
        })
    })

    function getRef(keyword){
        switch(keyword){
            case '1' :
                return 'overdue_loans';
            case '2' :
                return 'disbursed_loans';
            case '3' :
                return 'repaid_loans';
            case '4' :
                return 'approved_not_disbursed_loans';
            case '5' :
                return 'vehicle_registrations';
            case '6' :
                return 'vehicle_particulars';
            case '7' :
                return 'vehicle_insurance';
            case '8' :
                return 'vehicle_installment_insurance';
            default :
                return alert('Please select a valid search keyword');
        }
    }
</script>