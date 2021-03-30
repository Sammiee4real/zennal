<?php
	require_once('../../config/functions.php');
	if($_SERVER["REQUEST_METHOD"] == "GET"){

		$insurer_id = $_GET['insurerId'];

	    $table = "insurance_plans";
	    $get_insurance_plans = get_rows_from_table_with_one_params($table, 'insurer_id', $insurer_id);
    	$get_insurance_plans = json_encode($get_insurance_plans);
    	echo $get_insurance_plans;
	}
	
?>