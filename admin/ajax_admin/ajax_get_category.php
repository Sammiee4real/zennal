<?php
	require_once('../../config/functions.php');
	if($_SERVER["REQUEST_METHOD"] == "GET"){
	    $table = "insurance_categories";
	    $get_insurance_categories = get_rows_form_table($table);
    	$get_insurance_categories = json_encode($get_insurance_categories);
    	echo $get_insurance_categories;
	}
	
?>