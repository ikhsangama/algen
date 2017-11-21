<?php

require './../config.php';
?>

<center><h2>DAFTAR ADMIN</h2></center><br><br>
<div class="table-responsive" >
	<table class="table table-striped green">
		<thead >
			<tr>
				<th>No</th>
				<th>Username</th>
				<th>Nama</th>
				<th>Tempat</th>
				<th>Hapus</th>
			</tr>
		</thead>
	<tr>

<?php 
$i=0; //inisialisasi untuk penomoran data
//perintah untuk menampilkan data, id_brg terbesar ke kecil
$tampil = "SELECT * FROM admin ORDER BY nama";
//perintah menampilkan data dikerjakan
$sql = mysqli_query($dbconnect, $tampil);

//tampilkan seluruh data yang ada pada tabel user
while($data = mysqli_fetch_array($sql))
 {
 $i++;
?>
 <td><?php echo $i ?></td>
 <td><?php echo $data['username']?></td>
 <td><?php echo $data['nama']?></td>
 <td><?php echo $data['tempat']?></td>
 <td><a href="hapusadmin.php?username=<?php echo $data['username'];?>" onclick="return confirm('Yakin mau hapus <?php echo $data['username']?>?');"> <button type='button' class='btn btn-danger'><i class='glyphicon glyphicon-trash'></i> Hapus</button></td></a> </tr>
 <?php
 }
 ?>
</table></div>


<a href='index.php?page=tambah_admin'><button type='button' class='btn btn-success'><i class='glyphicon glyphicon-plus'></i> Tambah</button></a>