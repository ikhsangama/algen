<?php
include('./../config.php');
$id	= $_GET['id'];
?>

<center><h2>TAMBAH RUTE</h2></center><br><br>
<div class="table-responsive">
	<form method="" ="POST" action="prosestambahrute.php">
	<table class="table table-striped green">
		<thead >
			<tr>
				<th>No</th>
				<th>Asal</th>
				<th>Tujuan</th>
				<th>Jarak</th>
				<th>Rute</th>
			</tr>
		</thead>
	<tr>

<?php 

$namalokasi = "SELECT nama FROM lokasi WHERE id_lokasi='".$id."'";
$cek = mysqli_query($dbconnect, $namalokasi);

while($data = mysqli_fetch_array($cek))
 {
 	$lokasi = $data['nama'];
 }

$i=0; //inisialisasi untuk penomoran data
//perintah untuk menampilkan data
$tampil = "SELECT f.nama, r.jarak, r.tujuan FROM rute r, lokasi f WHERE r.tujuan=f.id_lokasi AND r.asal='".$id."'";
//perintah menampilkan data dikerjakan
$sql = mysqli_query($dbconnect, $tampil);

//tampilkan seluruh data yang ada pada tabel user
while($data = mysqli_fetch_array($sql))
 {
 $i++;
?>
 <td><?php echo $i ?></td>
 <td><span title="<?php echo $lokasi?>"><?php echo $id?></td>
 <td><span title="<?php echo $data['nama']?>"><?php echo $data['tujuan']?></span></td>
 <td><?php echo $data['jarak']?></td>
 <td><a href="index.php?page=rute_peta&asal=<?php echo $id?>&tujuan=<?php echo $data['tujuan']?>" > <button type='button' class='btn btn-info'>Rute</button></td></a>
 
 </tr>
 
 <?php 
 }
 $tampil = "SELECT f.nama, r.jarak, r.asal FROM rute r, lokasi f WHERE r.asal=f.id_lokasi AND r.tujuan='".$id."'";
//perintah menampilkan data dikerjakan
$sql = mysqli_query($dbconnect, $tampil);

//tampilkan seluruh data yang ada pada tabel user
while($data = mysqli_fetch_array($sql))
 {
 $i++;
 	
?>
<tr>
 <td><?php echo $i ?></td>
 <td><span title="<?php echo $data['nama']?>"><?php echo $data['asal']?></span></td>
 <td><span title="<?php echo $lokasi?>"><?php echo $id?></span></td>
 <td><?php echo $data['jarak']?></td>
 <td><a href="index.php?page=rute_peta&asal=<?php echo $data['asal']?>&tujuan=<?php echo $id?>"> <button type='button' class='btn btn-info'>Rute</button></td></a>
 <?php
}
 ?>
 
 </tr>

 </form>
</table>
 </div>
 <!--jquery-->
<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
