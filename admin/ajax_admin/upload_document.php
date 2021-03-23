<?php
	require_once('../../config/functions.php');
	$document_name = $_POST['document_name'];
	$document_url = $_POST['document_url'];
	$admin_id = $_SESSION['admin_id'];
	$upload_document = upload_document($document_name, $document_url, $admin_id);
	$upload_document_decode = json_decode($upload_document, true);
	if($upload_document_decode['status'] == "1"){
		echo "success";
	}
	else{
		echo $upload_document_decode['msg'];
	}
?>