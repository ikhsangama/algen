
<h2>
<p align="center">EDIT DATA
<?php
	include('./../config.php');
	if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
		$query	= mysqli_query($dbconnect,'select * from admin where username = "'.$username.'"');
		$data  	= mysqli_fetch_array($query);
		$nama	= $data['nama'];
		$tempat	= $data['tempat'];
	}
	else{
	$nama = '';
	$alamat = '';
	$kelas = '';
	}
?>


</p></h2><br><br>
<form method="post" class="form-horizontal" action="prosesedit.php">
<div class="form-group">
    <label class="control-label col-sm-4 col-md-5" for="username">Username:</label>
    <div class="col-sm-8 col-md-4"> 
      <input type="text" class="form-control" name="username" id="username" value="<?php echo $username ?>" readonly>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-4 col-md-5" for="nama">Nama:</label>
    <div class="col-sm-8 col-md-4"> 
      <input type="text" class="form-control" name="nama" id="nama" value="<?php echo $nama ?>">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-4 col-md-5" for="tempat">Tempat:</label>
    <div class="col-sm-8 col-md-4"> 
      <input type="text" class="form-control" name="tempat" id="tempat" value="<?php echo $tempat ?>">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-4 col-md-5" for="password">Password:</label>
    <div class="col-sm-8 col-md-4"> 
      <input type="password" class="form-control" name="password" id="password">
    </div>
</div>
<div class="form-group"> 
    <div class="col-sm-offset-5 col-sm-5">
      <button type="submit" class="btn btn-default" name="editadmin">Simpan</button>
    </div>
  </div>
</form>