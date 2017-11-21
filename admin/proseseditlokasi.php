<?php
session_start();
include('./../config.php');
if(isset($_POST['editlokasi'])){ 
	$id	= $_POST['id'];
	$nama	= $_POST['lokasi'];
	$lat	= $_POST['latitude'];
	$lng	= $_POST['longitude'];
	
	date_default_timezone_set('Asia/Jakarta');
	$now = date('Y-m-d H:i:s');
	$username = $_SESSION['username'];
	

	$sql1	= 'UPDATE lokasi SET nama= "'.$nama.'", lat="'.$lat.'", lng="'.$lng.'", update_by="'.$username.'", waktu_update="'.$now.'" WHERE id_lokasi="'.$id.'"';
	$query1 = mysqli_query($dbconnect,$sql1);
		if($query1){
			header('location:index.php?page=lokasi'); //kode ini supaya jika data setelah ditambahkan form kembali menuju edit admin
			}
		else{
			echo 'Gagal';
		}
	
}
?>