<?php
include('./../config.php');
$id	= $_GET['id'];

$sql 	= 'delete from lokasi where id_lokasi="'.$id.'"';
$query	= mysqli_query($dbconnect,$sql);

$sql2 = 'delete from rute where asal="'.$id.'" OR tujuan="'.$id.'"';
$query2	= mysqli_query($dbconnect,$sql2);

header('location:index.php?page=lokasi');
?>