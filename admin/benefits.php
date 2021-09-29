<?php
//session_start();
include("../config/functions.php");
include("inc/header.php");
$admin_id = $_SESSION['admin_id'];
$pkg_id = base64_decode($_GET['pkg_id']);
$admin_details = get_one_row_from_one_table_by_id('admin','unique_id', $admin_id, 'date_created');
// $get_benefits = get_rows_from_one_table('insurance_benefits','datetime');
$pkg = get_one_row_from_one_table_by_id('insurance_packages','unique_id', $pkg_id, 'date_created');
$get_benefits = get_rows_from_one_table_by_id('insurance_benefits', 'package_id', $pkg_id, "datetime");
// $get_benefits = get_rows_from_one_table('insurance_packages','date_created');

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
          <h1 class="h3 mb-2 text-gray-800">Insurance Benefits</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
              <span class="float-right">
                <a role="button" href="view_insurance_packages" class="btn btn-primary btn-sm" id="add_benefit">
                    <i class="fa fa-chevron-left"></i> Loan Packages    
                </a>
                <button class="btn btn-primary btn-sm" id="add_benefit">Add New Benefit</button>
              </span>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <form id="benefits_form">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                       <thead class="thead-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Package Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="benefits_table">
                            <?php
                                $last_id = 0;
                                if(!empty($get_benefits)) :
                                    $i = 0;
                                    foreach($get_benefits as $bft) :
                                        $i++;
                                        $last_id = $i;
                            ?>
                            <tr id="benefit_<?=$i?>_view" class="benefit_view" data-id="<?=$i?>">
                                <td><?=$i?></td>
                                <td scope="col">
                                    <?=$bft['benefit']?>
                                </td>
                                <td scope="col">
                                    <?=$pkg['package_name']?>
                                </td>
                                <td scope="col">
                                <?php
                                    if($bft['is_active'] == 1){
                                        $status = 'inactive';
                                        $text = 'Hide';
                                    }else{
                                        $status = 'active';
                                        $text = 'Show';
                                    }
                                ?>
                                <button
                                    class="btn <?=$status=='inactive'?'btn-danger':'btn-success';?> btn-sm change_status"
                                    type="button"
                                    id="insurace_status<?=$bft['unique_id']?>"
                                    data-id="<?php echo $bft['unique_id'];?>"
                                    data-status = "<?=$status?>"
                                    data-ref = "insurance_benefits"
                                ><?=$text?></button>
                                </td>
                            </tr>
                            <tr id="benefit_<?=$i?>_edit" class="benefit_edit">
                                <td><?=$i?></td>
                                <td scope="col">
                                    <input type="text" name="benefit_<?=$i?>" class="benefit form-control" value="<?=$bft['benefit']?>">
                                    <input type="hidden" name="benefit_id_<?=$i?>" class="benefit form-control" value="<?=$bft['unique_id']?>">
                                </td>
                                <td scope="col">
                                    <select name="package_id_<?=$i?>" class="form-control">
                                        <option value="<?=$pkg['unique_id']?>"><?=$pkg['package_name']?></option>
                                    </select>
                                </td>
                                <td scope="col">
                                </td>
                            </tr>
                            <?php
                                    endforeach;
                                endif;
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">
                                    <button 
                                        type="submit" 
                                        name="benefits_button" 
                                        id="benefits_button"
                                        class="btn btn-sm btn-block btn-outline-primary"
                                        disabled
                                    >Add Benefits</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </form>
              </div>
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
</body>

</html>

<script>
$(document).ready(function(){
    let last_id = parseInt("<?php echo $last_id?>");
    let package = { name: "<?=$pkg['package_name']?>", id: "<?=$pkg_id?>" };
    let newBenefit = () => {
        var new_id = last_id+=1;
        let benefits_table = $('#benefits_table').html();

        $('#benefits_table').append(`
        <tr>
            <td>${new_id}</td>
            <td scope="col">
                <input type="text" name="benefit_${new_id}" class="benefit form-control">
            </td>
            <td scope="col">
                <select name="package_id_${new_id}" class="form-control">
                    <option value="${package.id}">${package.name}</option>
                </select>
            </td>
            <td scope="col">
            </td>
        </tr>
        `);

        // output = benefits_table + output;
        // $(output).appendTo('#benefits_table');
        // $('#benefits_table').append($(output));
    }

    $('#add_benefit').click(function(){
        newBenefit();
        $('#benefits_button').show();
    });

    if(last_id === 0){
        $('#benefits_button').hide();
    }

    $(document).on('input', '.benefit', function(){
        $("#benefits_button").attr('disabled', false);
    })

    $(".benefit_edit").hide();

    $(document).on('dblclick','.benefit_view', function(){
        var id = $(this).attr('data-id');
        if(confirm('Are you sure to edit this benefit?')){
            $(`#benefit_${id}_view`).hide();
            $(`#benefit_${id}_edit`).show();
            $('#benefits_button').html('Update Benefits');
            $('#benefits_button').show();
        }
    })

    $(document).on('submit', "#benefits_form", function(e){
        e.preventDefault();

        var formData = new FormData(this);
        formData.append('benefits_actions', 1);
        formData.append('id', last_id);

        $.ajax({
            url: 'ajax_admin/benefits_actions.php',
            type: 'post',
            data: formData,
            cache: false, 
            contentType: false,
            processData: false,
            beforeSend:function(){
                $('#benefits_button').attr('disabled', 'disabled');
                $("#benefits_button").html('Adding benefits, please wait...!');
            },
            success:function(data){
                $("#benefits_button").html('Add Benefits');
                $('#benefits_button').attr('disabled', 'disabled');
                console.log(data);
                data = JSON.parse(data);
                if(data.success){
                    Swal.fire({
						title: "Success",
						text: data.message,
						icon: "success",
					});
                }else{
                    Swal.fire({
						title: "Error",
						text: data.message,
						icon: "error",
					});
                }

                setTimeout(function(){
                    location.reload(true);
                }, 2000);
            }
        })
    });
});
</script>
