<?php

    require_once('../config/functions.php');

    $plan_name = $_POST['plan_name'];

    $insurers = get_rows_from_one_table("insurers");

    $plans = get_rows_from_one_table_by_id("insurance_plans","plan_name",$plan_name);

    $benefits = get_plan_benefits($plan_name);

    // var_dump($benefits)

?>



<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th><?php echo $plan_name;?></th>
                <?php
                    foreach ($insurers as $insurer) {
                        # code...
                        $insurance_id =  $insurer['unique_id'];
                        $insurer_img = $insurer['image'];
                ?>
                        <th>
                            <img src="assets/images/<?php echo $insurer_img;?>" width="52px">
                        </th>
                <?php
                    }
                ?>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach ($benefits as $benefit) {
                # code...
                $plan_id = $benefit['plan_id'];
                $plan_id = $benefit['plan_id'];

                // $benefit = get_one_row_from_one_table_by_id("insurance_benefits","plan_id",$plan_id);
        ?>

            <tr>

                <td><?php echo $benefit['benefit'];?></td>

        <?php
                foreach ($insurers as $insurer) {

                    $insurer_id =  $insurer['unique_id'];
                    
                    $insurer_benefit = get_one_row_from_one_table_by_two_params("insurance_benefits", "benefit", $benefit['benefit'], "insurer_id",$insurer_id);
        ?>

                    <td>
                        <?php if(empty($insurer_benefit)) continue;?>
                        <i data-feather="<?php echo $insurer_benefit['status'] == 1 ? 'check':'x'; ?>" width="32" height="32" style="<?php echo $insurer_benefit['status'] == 1 ? 'color: green':'color: red'; ?>;"></i><?php echo $insurer_benefit['description']?>
                    </td>

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