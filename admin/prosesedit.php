<?php
include('./../config.php');
if(isset($_POST['editadmin'])){
	$username	= $_POST['username'];
	$nama	= $_POST['nama'];
	$passwordasli = $_POST['password'];
	$password = md5($passwordasli);
	$tempat = $_POST['tempat'];

	$sql1	= 'UPDATE admin SET nama= "'.$nama.'", tempat="'.$tempat.'" WHERE username="'.$username.'"';
	$query1 = mysqli_query($dbconnect,$sql1);

	$sql2	= 'SELECT * FROM admin WHERE username="'.$username.'" AND password="'.$password.'"';
	$query = mysqli_query($dbconnect,$sql2);
	$query2 = mysqli_num_rows($query);
	
	if($query2>0){
		if($query1){
			
			header('location:index.php?page=edit_admin'); //kode ini supaya jika data setelah ditambahkan form kembali menuju edit admin
			}
		else{
			echo 'Gagal';
		}
	}
	//else{
	//	echo 'Password Salah!';
	//}
}
?>