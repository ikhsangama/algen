<?php
include('./../config.php');	
		
		$asal=$_POST['asal'];
		$tujuan = $_POST['tujuan'];
		$editval=$_POST['editval'];

		$sql = "UPDATE rute set jarak = '".$editval."' WHERE  asal='".$asal."' AND tujuan='".$tujuan."'";
		$hasil = mysqli_query($dbconnect,$sql);
		if($hasil){
			echo'
				<div class="alert alert-success alert-dismissable fade in">
				    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
				    <strong><i class="glyphicon glyphicon-ok"></i></strong> Data berhasil diupdate.
			  	</div>
			';
		}
		else{
			echo'
				<div class="alert alert-danger alert-dismissable fade in">
				    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
				    <strong><i class="glyphicon glyphicon-remove"></i></strong> Data gagal diupdate.
			  	</div>
			';
		}

		
?>