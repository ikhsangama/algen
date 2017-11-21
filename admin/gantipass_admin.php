
<h2>
<p align="center">GANTI PASSWORD
<?php
	include('./../config.php');
	if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
	}
?>


</p></h2><br><br>
<form method="post" class="form-horizontal" action="prosesgantipass.php">
<div class="form-group">
    <label class="control-label col-sm-4 col-md-5" for="username">Username:</label>
    <div class="col-sm-8 col-md-4"> 
      <input type="text" class="form-control" name="username" id="username" value="<?php echo $username ?>" readonly>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-4 col-md-5" for="passlama">Password Lama:</label>
    <div class="col-sm-8 col-md-4"> 
      <input type="password" class="form-control" name="passlama" id="passlama">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-4 col-md-5" for="passbaru">Password Baru:</label>
    <div class="col-sm-8 col-md-4"> 
      <input type="password" class="form-control" name="passbaru" id="passbaru">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-4 col-md-5" for="passkonfirm">Konfirmasi Password Baru:</label>
    <div class="col-sm-8 col-md-4"> 
      <input type="password" class="form-control" name="passkonfirm" id="passkonfirm">
    </div>
</div>
<div class="form-group"> 
    <div class="col-sm-offset-5 col-sm-5">
      <button type="submit" class="btn btn-default" name="gantipassadmin">Simpan</button>
    </div>
  </div>
</form>