<?php
	require_once('../../config/functions.php');
	$benefit_name = mysqli_real_escape_string($_POST['benefit_name']);
	
	$add_insurance_benefit = add_insurance_benefit($benefit_name, $_POST);
	$add_insurance_benefit_decode = json_decode($add_insurance_benefit, true);
	if($add_insurance_benefit_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $add_insurance_benefit_decode['msg'];
	}
?>