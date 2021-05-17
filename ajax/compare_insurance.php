<?php
    $plan_id = $_POST['plan_id'];
    $benefit_id = $_POST['benefit_id'];
    if( empty($plan_id) || empty($benefit_id) ){
        exit("Empty fields found");
    }

    $plan = get_one_row_from_one_table('insurance_plans', 'unique_id', $plan_id);
    $benefit = get_one_row_from_one_table('insurance_benefits', 'unique_id', $benefit_id);

    if(empty($plan) || empty($benefit)){
        exit("Details not available");
    }

    
?>

<div class="table-responsive">
    <table class="table table-bordered mb-0">
        <thead>
            <tr>
                <th>
                    <?php echo $plan["plan_name"]." (".$plan["plan_percentage"];?>
                </th>
                
                <?php
                    foreach($get_insurers as $insurer){
                ?>
                <th>
                    <div class="col-md-4">
                        <img src="assets/images/<?php echo $insurer['image'];?>" width="52px">
                    </div>
                </th>
                <?php
                    }
                ?>
            </tr>
        </thead>
        <tbody>
            <pre>
            <?php 
            // print_r($get_benefits); 
            foreach($get_benefits as $benefit){
            ?>
            <tr>
                <td><?php echo $benefit['benefit'] ?></td>
                <?php 
                foreach($benefit['details'] as $benefit_plan){
                ?>
                  <td><i data-feather="<?php echo $benefit_plan['status'] == 1 ? 'check':'x'; ?>" width="32" height="32" style="<?php echo $benefit_plan['status'] == 1 ? 'color: green':'color: red'; ?>;"></i><?php echo $benefit_plan['description']?></td>
                <?php
                }
                ?>
              </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

