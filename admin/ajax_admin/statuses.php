<?php
	require_once('../../config/functions.php');
    extract($_POST);

    if(isset($page))
    {
        if($page == 'loan_packages'){
           $res = _changeStatus('loan_packages', 'is_active', $val, 'unique_id', $id);
        }
        if($page == 'statuses'){
            $val = '';

            if($status == 'inactive') $val = 0;
            else $val = 1;
            
            $res = _changeStatus($ref, 'is_active', $val, 'unique_id', $id);
        }
    }
    echo json_encode($res);
?>