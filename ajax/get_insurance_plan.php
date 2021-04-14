<?php
	require_once('../config/functions.php');
	$insurer = $_POST['insurer'];
	$get_insurance_plan = get_rows_from_table_with_one_params('insurance_plans','insurer_id',$insurer);
	echo '<option value="">Select Plan </option>';
	foreach ($get_insurance_plan as $insurance_plan) {
?>
<option value="<?= $insurance_plan['unique_id'];?>"><?= $insurance_plan['plan_name'];?></option>

<?php
	}
?>