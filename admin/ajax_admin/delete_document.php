<?php
	require_once('../../config/database_functions.php');
	$document_id = $_POST['document_id'];
	$document_url = $_POST['document_url'];
	$delete_document = delete_a_row('admin_document','unique_id',$document_id);
	$delete_document_decode = json_decode($delete_document, true);
	if($delete_document_decode['status'] == 1){
		echo "success";
		unlink($document_url);
	}
	else{
		echo $delete_document_decode['msg'];
	}
?>