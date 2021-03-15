<?php
include('config/functions.php');

if(!isset($_SESSION['user'])){
    header('location: login.php');
    end();
}

$user_id = md5($_SESSION['user']['unique_id']);
$verify_id = $_GET['id'];

if($user_id !== $verify_id) {
    $_SESSION['error'] = 'Invalid verification link';
    header('location: index.php');
    end();
}

if(verify_user_email($user_id) === true){
    $_SESSION['success'] = 'Email verified successfully';
    header('location: index.php');
    end();
}

?>