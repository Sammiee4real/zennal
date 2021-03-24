<?php
	require_once('../../config/functions.php');

	$insurer_name = $_POST['insurer_name'];
	$file = $_FILES['insurer_image'];

	if ($insurer_name == null) {
		echo "Please provide insurer name";
		die;
	}
	
	if ($file['name'] == null) {
		echo "Please upload insurer image";
		die;
	}
	
	/* Getting file name */
	$filename = $file['name'];

	/* Location */
	$location = $_SERVER['DOCUMENT_ROOT']."admin/uploads/".$filename;
	$imageFileType = pathinfo($location,PATHINFO_EXTENSION);
	$imageFileType = strtolower($imageFileType);
	/* Valid extensions */
	$valid_extensions = array("jpg","jpeg","png");

	/* Check file extension */
	if(in_array(strtolower($imageFileType), $valid_extensions)) {
		/* Upload file */
		if(!move_uploaded_file($file['tmp_name'], $location)){
			echo "Insurer image not uploaded";
			die;
		}else{
			$add_insurer = add_insurer($insurer_name, $filename);
			$add_insurer_decode = json_decode($add_insurer, true);
			if($add_insurer_decode['status'] == "1"){
				echo "success";
			}
			else{
				echo $add_insurer_decode['msg'];	
			}	
		}
	}
	else{
		echo "Invalid image type";
		die;
	}
	
?>