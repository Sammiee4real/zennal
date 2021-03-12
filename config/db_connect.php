<?php
$db_host='localhost';
$db_user='root';
$db_password='';
$database='zennal_db';
$dbc = mysqli_connect("$db_host","$db_user","$db_password","$database")
or die ('Error connecting to Database');
?>