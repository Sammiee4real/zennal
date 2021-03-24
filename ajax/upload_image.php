<?php
	session_start();
	$user_id =$_SESSION['user']['unique_id'];
	if($_FILES["file"]["name"] != ''){
		$test = explode(".", $_FILES['file']['name']);
		$extension = end($test);
		$alt_name = $user_id.'_'.date("Y_m_d_H.i.s");
		$name = $alt_name.'.'.$extension;
		$location = '../bank_statement/'.$name;
		move_uploaded_file($_FILES['file']['tmp_name'], $location);
		echo $location;
	}
?>