<?php
include('./../config.php');
if(isset($_POST['tambahadmin'])){ //['tambahadmin'] merupakan name dari button di form tambah
	$username	= $_POST['username'];
	$nama	= $_POST['nama'];
	$passwordasli = $_POST['password'];
	$password = md5($_POST['password']);
	$konfirmpassword = $_POST['konfirmpassword'];
	$tempat = $_POST['tempat'];


	$sql1	= 'SELECT username FROM admin WHERE username="'.$username.'"';
	$query1 = mysqli_num_rows(mysqli_query($dbconnect,$sql1));
	
	if ($passwordasli!=$konfirmpassword){
		echo 'Konfirmasi Password Salah';
	}
	else{
		if ($query1>0){
			echo 'Username sudah ada!';
		}
		else{
			$sql	= 'insert into admin (username,nama,tempat,password) values ("'.$username.'","'.$nama.'","'.$tempat.'","'.$password.'")';
			$query	= mysqli_query($dbconnect,$sql);
			if($query){
			header('location:index.php?page=daftar_admin'); //kode ini supaya jika data setelah ditambahkan form kembali menuju daftar admin
			}
			else{
				echo 'Gagal';
			}
		}
	}
	
}
?>