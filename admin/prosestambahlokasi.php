<?php
include('./../config.php');
session_start();
if(isset($_POST['tambahlokasi'])){ 
	$id	= $_POST['id'];
	$lokasi	= $_POST['lokasi'];
	$lat	= $_POST['latitude'];
	$lng	= $_POST['longitude'];
	
	
	

	$sql1	= 'SELECT * FROM lokasi WHERE id_lokasi="'.$id.'"';
	$query1 = mysqli_num_rows(mysqli_query($dbconnect,$sql1));
	
		if ($query1>0){
			echo 'ID sudah ada!';
		}
		else{
			$sql	= 'insert into lokasi (id_lokasi,nama, lat, lng, update_by) values ("'.$id.'","'.$lokasi.'","'.$lat.'","'.$lng.'", "'.$_SESSION['username'].'")';
			$query	= mysqli_query($dbconnect,$sql);
			if($query){
				$tampil = "SELECT * FROM lokasi ORDER BY nama";
				$query0 = mysqli_query($dbconnect, $tampil);
				while($data = mysqli_fetch_array($query0))
				{
					if($data['id_lokasi']<>$id){
						$sql2	= 'insert into rute (asal,tujuan, jarak, update_by) values ("'.$id.'","'.$data['id_lokasi'].'",0,"'.$_SESSION['username'].'")';
						$query2	= mysqli_query($dbconnect,$sql2);	
					}
				}
				$query0 = mysqli_query($dbconnect, $tampil);
				while($data = mysqli_fetch_array($query0))
				{
					if($data['id_lokasi']<>$id){
						$sql2	= 'insert into rute (asal,tujuan,jarak, update_by) values ("'.$data['id_lokasi'].'","'.$id.'",0, "'.$_SESSION['username'].'")';
						$query2	= mysqli_query($dbconnect,$sql2);	
					}
				}
						
			header('location:index.php?page=tambah_rute&id='.$id.'');
			}
			else{
				echo 'Gagal';
			}
		}
	
	
}
?>