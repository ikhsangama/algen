<?php
include('./../config.php');
if(isset($_POST['gantipassadmin'])){
	$username	= $_POST['username'];
	$passlama= md5($_POST['passlama']);
	$passbaru = md5($_POST['passbaru']);
	$konfirmpass = md5($_POST['passkonfirm']);

	$sql2	= 'SELECT * FROM admin WHERE username="'.$username.'" AND password="'.$passlama.'"';
	$query1 = mysqli_query($dbconnect,$sql2);
	$query2 = mysqli_num_rows($query1);

	$sql1	= 'UPDATE admin SET password="'.$passbaru.'" WHERE username="'.$username.'"';
	
	
	if($passbaru==$konfirmpass){
		if($query2>0){
			$query = mysqli_query($dbconnect,$sql1);
				if($query){ ?>

					<script>
						alert("Password Berhasil Diupdate!");
					</script>


		<?php
			header('location:index.php?page=gantipass_admin');
					}
				else{?>

					<script>
						alert("Gagal");
					</script>
		<?php	}
			}
			else{?>
					<script>
						alert("Password Lama Salah!");
					</script>
		<?php }
	}	
	else{?>
					<script>
						alert("Konfirmasi Password Tidak Sama");
					</script>
		<?php }
	 //kode ini supaya jika data setelah ditambahkan form kembali menuju daftar admin
}
?>