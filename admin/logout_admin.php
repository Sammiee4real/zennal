<?php
	session_start();
    if(isset($_SESSION['admin_id'])){
    	unset($_SESSION['admin_id']);
    	session_destroy();
        echo "<script>window.location.href = 'login_admin.php'</script>";
    }
?>