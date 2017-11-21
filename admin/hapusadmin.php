<?php
include('./../config.php');
$username	= $_GET['username'];

$sql 	= 'delete from admin where username="'.$username.'"';
$query	= mysqli_query($dbconnect,$sql);
header('location:index.php?page=daftar_admin');
?>