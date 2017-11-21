<?php
	include('./../config.php');	
	if(isset($_POST['tempat'])){
		$tempat=$_POST['tempat'];
	}
	
?>

	<table class="table table-responsive table-striped green">
		<thead>
			<tr>
				<th>No</th>
				<th>Titik Tujuan</th>
				<th>Jarak (m)</th>
				<th>Rute</th>
				<th colspan="2" align="centre">Terakhir Updatee </th>
			</tr>
		</thead>
			<tr><form method="post" action="proseupdatejarak.php">
<?php
			$i=0; //inisialisasi untuk penomoran data
//perintah untuk menampilkan data
$tampil = "SELECT f.nama, r.jarak, r.tujuan, r.update_by, r.waktu_update FROM rute r, lokasi f WHERE asal='".$tempat."' AND r.tujuan=f.id_lokasi ORDER BY f.nama";
//perintah menampilkan data dikerjakan
$sql = mysqli_query($dbconnect, $tampil);

//tampilkan seluruh data yang ada pada tabel user
while($data = mysqli_fetch_array($sql))
 {
 $i++;
?>
 <td><?php echo $i ?></td>
 <td><?php echo $data['nama']?></td>
 <td><?php echo $data["jarak"]; ?></td>
 <td><a href="index.php?page=rute_peta&asal=<?php echo $tempat?>&tujuan=<?php echo $data["tujuan"]; ?>" onclick=""> <button type='button' class='btn btn-info'>Rutee</button></td></a> 
 <td><?php echo $data['update_by']?></td>
 <td><?php echo $data['waktu_update']?></td>
 </tr>
 <?php
 }
 ?>
	</table>

<!--jquery-->
<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
<p id="cetak1"></p>

