<?php
session_start();
include('./../config.php');
if(isset($_POST['editvariabelalgen'])){ 
	$crossover	= $_POST['crossover'];
	$mutasi		= $_POST['mutasi'];
	$generasi	= $_POST['generasi'];
	$kromawal	= $_POST['kromawal'];
	
	date_default_timezone_set('Asia/Jakarta');
	$now = date('Y-m-d H:i:s');
	$username = $_SESSION['username'];

	$sql1	= 'UPDATE variabel_algen SET prob_crossover= "'.$crossover.'", prob_mutasi="'.$mutasi.'", jml_generasi="'.$generasi.'", jml_krom_awal="'.$kromawal.'", update_by="'.$username.'", waktu_update="'.$now.'" WHERE id_variabel=1';
	$query1 = mysqli_query($dbconnect,$sql1);
		if($query1){
			header('location:index.php?page=variabel_algen'); //kode ini supaya jika data setelah ditambahkan form kembali menuju edit admin
			}
		else{
			echo 'Gagal';
		}
	
}
?>