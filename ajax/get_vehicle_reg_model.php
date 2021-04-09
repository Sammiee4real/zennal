<?php
	require_once('../config/functions.php');
	$vehicle_make = $_POST['vehicle_make'];
	$get_vehicle_model = get_rows_from_table_with_one_params('vehicle_models','brand_id',$vehicle_make);
	echo '<option value="">Select vehicle model </option>';
	foreach ($get_vehicle_model as $model) {
?>
<option value="<?= $model['unique_id'];?>"><?= $model['model_name'];?></option>

<?php
	}
?>
<option value="others">Others</option>