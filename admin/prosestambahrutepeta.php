<?php
include('./../config.php');
session_start();
date_default_timezone_set('Asia/Jakarta');
$now = date('Y-m-d H:i:s');
$username = $_SESSION['username'];

if(isset($_POST['asal'])){ 
	$asal	= $_POST['asal'];
	$tujuan	= $_POST['tujuan'];
	$rute	= $_POST['rute'];
	$jarak	= $_POST['jarak'];	
	
	$sql1	= 'UPDATE rute SET jarak="'.$jarak.'", rute="'.$rute.'", update_by = "'.$username.'", waktu_update="'.$now.'" WHERE asal="'.$asal.'" AND tujuan="'.$tujuan.'"';
	$query1 = mysqli_query($dbconnect,$sql1);
	
		if ($query1){
			echo 'Berhasil Update';
			//header('location:index.php?page=tambah_rute&id='.$asal.'');
		}
		else{
			echo 'Gagal Update';
		}
}
?>