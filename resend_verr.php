<?php
include('config/functions.php');

if(!isset($_SESSION['user'])){
    header('location: login.php');
    end();
}

$user = $_SESSION['user'];

if(send_verification_link($user) === true){
    $_SESSION['success'] = 'Link sent';
    header('location: index.php');
    end();
}else{
    $_SESSION['error'] = 'Link not sent';
    header('location: index.php');
    end();
}

?>