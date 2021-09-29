<?php
//session_start();
include("../config/functions.php");
include("inc/header.php");
$admin_id = $_SESSION['admin_id'];
$admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
$get_insurers = get_rows_from_one_table('insurers','datetime');

$insurer_id = '';
if(isset($_GET['insurer'])){
    $insurer_id = base64_decode($_GET['insurer']);
}
$pkg_id = '';
if(isset($_GET['insurer'])){
    $pkg_id = base64_decode($_GET['pkg_id']);
}
// print_r($get_insurers);
// $pkg = get_one_row_from_one_table_by_id('insurance_packages','unique_id', $pkg_id, 'date_created');
// $get_benefits = get_rows_from_one_table_by_id('insurance_benefits', 'package_id', $pkg_id, "datetime");
// $get_benefits = get_rows_from_one_table('insurance_packages','date_created');
$insurer_name = '';
$bftsnum = 0;
$plansnum = 0;
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

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
          <h1 class="h3 mb-2 text-gray-800">Insurances</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Choose Insurer</h6>
              <select id="insurer" class="form-control">
                  <option value="">Select . . .</option>
                <?php 
                    $insurers = json_decode(json_encode($get_insurers, true));
                    foreach($insurers as $insurer) : 
                ?>
                  <option <?=$insurer_id == $insurer->unique_id?'selected':'';?> value="<?=base64_encode($insurer->unique_id)?>"><?=$insurer->name?></option>
                  <?php endforeach; ?>
              </select>
            </div>
            <div class="card-body">


            <!-- edit mode -->
              <div class="table-responsive edit_mode table_mode">
                
                <?php 
                    if(!empty($insurer_id) && !empty($pkg_id)) : 
                ?>
                <span class="float-right">
                    <button class="change_table_mode btn btn-primary btn-sm" id="to_print_mode">To Print Mode</button>
                </span>
                <?php
                        $insurer = get_one_row_from_one_table_by_id('insurers','unique_id', $insurer_id, 'datetime');
                        $package = get_one_row_from_one_table_by_id('insurance_packages','unique_id', $pkg_id, 'date_created');

                        if(!empty($insurer) && !empty($package)) :

                            $insurer_name = $insurer['name'];

                            echo $insurer_name;

                            $plans = get_rows_from_one_table('insurance_plans','datetime');
                            $benefits = get_rows_from_one_table_by_id('insurance_benefits', 'package_id', $pkg_id, "datetime");

                            $plansnum = get_number_of_rows('insurance_plans');
                            $bftsnum = get_number_of_rows_one_param('insurance_benefits', 'package_id', $pkg_id);

                            $cols = get_number_of_rows('insurance_plans')+2;
                            $rows = get_number_of_rows_one_param('insurance_benefits', 'package_id', $pkg_id)+2;
                            
                            $head = '<table class="table table-bordered">';

                            $body = '';
                            
                            $count = 1;
                            $head .= '<thead>';
                            for($i = 1; $i<=2; $i++) :
                                if($i == 1 or $i == 2) :
                                    if($i == 1) :
                                        $head .= '<tr>';
                                        for($j=1; $j<=$cols; $j++) : 
                                            if($j == 1){
                                                $head .= '<th width="5%">S/N</th>';
                                            }
                                            elseif($j == 2){
                                                $head .= '<th>BENEFITS</th>';
                                            }else{
                                                $head .= '<th>'.$plans[$j-3]['plan_name'].'</th>';
                                            }
                                        endfor;
                                        $head .= '</tr>';
                                    else : 
                                        $head .= '<tr>';
                                        for($j=1; $j<=$cols; $j++) : 
                                            if($j == 1 || $j == 2){
                                                $head .= '<td></td>';
                                            }else{
                                                $head .= '<th>'.$plans[$j-3]['plan_percentage'].'%</th>';
                                            }
                                        endfor;
                                        $head .= '</tr>';
                                    endif; 
                                endif;
                            endfor;
                            $head .= '</thead>';
                            
                            $body .= '<tbody>';
                            $count = 1;
                            for($i = 3; $i<=$rows; $i++) :
                                
                                $body .= '<tr>';
                                for($j=1; $j<=$cols; $j++) : 
                                    if($j == 1){
                                        $body .= '<th>'.$count.'</th>';
                                    }
                                    elseif($j == 2){
                                        $body .= '<th>'.$benefits[$count-1]['benefit'].'</th>';
                                    }else{
                                        $benefit_id = $benefits[$count-1]['unique_id'];
                                        $plans_id = $plans[$j-3]['unique_id'];

                                        $sql = "SELECT `value` from insurances where insurer_id = '".$insurer_id."' and benefit_id = '".$benefit_id."' and plan_id = '".$plans_id."'";

                                        $benefit = mysqli_fetch_object(
                                            mysqli_query($dbc, $sql)
                                        );

                                        $benefit_val = '';
                                        if(isset($benefit->value)){
                                            $benefit_val = $benefit->value;
                                        }

                                        $body .= '<td>
                                            <input 
                                                type="text" id="benefit_'.$count.($j-3).'" 
                                                data-plan_id="'.$plans_id.'" 
                                                data-benefit_id="'.$benefit_id.'" 
                                                class="form-control" 
                                                value="'.$benefit_val.'"
                                            />
                                        </td>';
                                    }
                                endfor;
                                $count+=1;
                                $body .= '</tr>';
                            endfor;
                            $body .= '</tbody>';

                            $foot = '
                                <tfoot>
                                    <tr>
                                        <td  colspan="'.$cols.'">
                                            <button 
                                                class="btn btn-primary btn-sm btn-block"
                                                data-plans="'.$plansnum.'"
                                                data-benefits="'.$bftsnum.'"
                                                id="addInsurerButton"
                                            >
                                                Add/Update Insurance Details
                                            </button>
                                        </td> 
                                    </tr>
                                </tfoot>
                            </table>
                            ';


                            $table = $head.$body.$foot;

                            echo $table;
                        endif;
                    endif; 
                ?>
              </div>
            <!-- end of edit mode -->


            <!-- to print/view mode -->

            <div class="table-responsive to_print_mode table_mode" id="insurances_table">
                <?php 
                    if(!empty($insurer_id) && !empty($pkg_id)) : 
                ?>
                <span class="float-right">
                    <button class="change_table_mode btn btn-primary btn-sm" id="edit_mode">To Edit Mode</button>
                </span>
                <?php
                        $insurer = get_one_row_from_one_table_by_id('insurers','unique_id', $insurer_id, 'datetime');
                        $package = get_one_row_from_one_table_by_id('insurance_packages','unique_id', $pkg_id, 'date_created');

                        if(!empty($insurer) && !empty($package)) :
                            $plans = get_rows_from_one_table('insurance_plans','datetime');
                            $benefits = get_rows_from_one_table_by_id('insurance_benefits', 'package_id', $pkg_id, "datetime");

                            $plansnum = get_number_of_rows('insurance_plans');
                            $bftsnum = get_number_of_rows_one_param('insurance_benefits', 'package_id', $pkg_id);

                            $cols = get_number_of_rows('insurance_plans')+2;
                            $rows = get_number_of_rows_one_param('insurance_benefits', 'package_id', $pkg_id)+2;
                            
                            $head = '<table class="table table-bordered" id="dataTable">';

                            $body = '';
                            
                            $count = 1;
                            $head .= '<thead>';
                            for($i = 1; $i<2; $i++) :
                                $head .= '<tr>';
                                for($j=1; $j<=$cols; $j++) : 
                                    if($j == 1){
                                        $head .= '<th width="5%">S/N</th>';
                                    }
                                    elseif($j == 2){
                                        $head .= '<th>BENEFITS</th>';
                                    }else{
                                        $head .= '<th>'.$plans[$j-3]['plan_name'].'</th>';
                                    }
                                endfor;
                                $head .= '</tr>';
                            endfor;
                            $head .= '</thead>';
                            
                            $body .= '<tbody>';
                            $count = 1;
                            for($i = 2; $i<=$rows; $i++) :
                                
                                if($i == 2){
                                    $body .= '<tr>';
                                        for($j=1; $j<=$cols; $j++) : 
                                            if($j == 1 || $j == 2){
                                                $body .= '<td></td>';
                                            }else{
                                                $body .= '<th>'.$plans[$j-3]['plan_percentage'].'%</th>';
                                            }
                                        endfor;
                                    $body .= '</tr>';
                                }else{
                                    $body .= '<tr>';
                                    for($j=1; $j<=$cols; $j++) : 
                                        if($j == 1){
                                            $body .= '<th>'.$count.'</th>';
                                        }
                                        elseif($j == 2){
                                            $body .= '<th>'.$benefits[$count-1]['benefit'].'</th>';
                                        }else{
                                            $benefit_id = $benefits[$count-1]['unique_id'];
                                            $plans_id = $plans[$j-3]['unique_id'];
    
                                            $sql = "SELECT `value` from insurances where insurer_id = '".$insurer_id."' and benefit_id = '".$benefit_id."' and plan_id = '".$plans_id."'";
    
                                            $benefit = mysqli_fetch_object(
                                                mysqli_query($dbc, $sql)
                                            );
    
                                            $benefit_val = '';
                                            if(isset($benefit->value)){
                                                $benefit_val = $benefit->value;
                                            }
    
                                            $body .= '<td>'.$benefit_val.'</td>';
                                        }
                                    endfor;
                                    $count+=1;
                                    $body .= '</tr>';
                                }
                            endfor;
                            $body .= '</tbody>';

                            $foot = '
                            </table>
                            ';


                            $table = $head.$body.$foot;

                            echo $table;
                        endif;
                    endif; 
                ?>
              </div>
            <!-- end of to print / view mode -->




            </div>
          </div>
        </div>
        
        <!-- /.container-fluid -->

      </div>
      
      

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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>

</html>

<script>
$(document).ready(function(){

    $('#insurer').change(function(){
        var value = $(this).val();
        var text = $(this).text();
        var pkg_id = "<?=$_GET['pkg_id']?>";
        window.location.href = `?pkg_id=${pkg_id}&insurer=${value}`;
        $('title').html(text);
    });

    let addInsurance = (plan_id, pkg_id, benefit_id, insurer, value, callback) => {
        $.ajax({
            url: 'ajax_admin/addInsuranceValues.php',
            type:'post',
            data: {
                plan_id: plan_id, 
                benefit_id:benefit_id, 
                package_id:pkg_id, 
                insurer_id: insurer,
                value: value,
                addInsurer: ''
            },
            // dataType:'json',
            success:function(data){
                console.log(data);
                data = JSON.parse(data);
                if(data.success){
                    toastr.success('Benefit added/updated, please wait for completion', 'Success!');
                }else{
                    toastr.error(`Unable to add one or more benefit(s) value`, 'Error!');
                }
            }
        }).then(function(){
            callback();
        })
    }

    var t_bft = "<?=$bftsnum?>";
    t_bft = parseInt(t_bft);
    var t_plan = "<?=$plansnum?>";
    t_plan = parseInt(t_plan);

    var executions = parseInt(t_bft * t_plan);
    var executed = 0;

    $('#addInsurerButton').click(function(){
        var bfts = parseInt($(this).data('benefits'));
        var plans = parseInt($(this).data('plans'));

        console.log(`${bfts}x${plans}`);

        for(i=1; i<=bfts; i++){
            for(j=0; j<plans; j++){
                var btnref = $(`#benefit_${i}${j}`);
                var bft_id = btnref.data('benefit_id');
                var plan_id = btnref.data('plan_id');
                var value = btnref.val();
                var insurer = "<?=$insurer_id?>";
                var pkg_id = "<?=$pkg_id?>";

                console.log(`Benefit ID: ${bft_id} \n Plan ID: ${plan_id}`);
                addInsurance(plan_id, pkg_id, bft_id, insurer, value, function(){
                    executed += 1;

                    if(executed === executions){
                        Swal.fire({
                            title: "Success",
                            text: 'All benefits has been added/updated successfully',
                            icon: "success",
                        });
                
                        setTimeout(function(){
                            location.reload(true);
                        }, 2000);
                    }
                });
            }
        }
    });


    $('#dataTable').DataTable({
        dom: 'lBfrtip',
        buttons: ['print']
    });


    $(document).on('click', '.change_table_mode', function(){
        var to_mode = $(this).attr('id');

        $('.table_mode').hide();
        $('.'+to_mode).show();
    })

    $(".to_print_mode").hide();

});
</script>
