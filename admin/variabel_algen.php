<?php
    include('./../config.php'); 
    $tampil = "SELECT * FROM variabel_algen WHERE id_variabel=1";
    //perintah menampilkan data dikerjakan
    $sql = mysqli_query($dbconnect, $tampil);

    //tampilkan seluruh data yang ada pada tabel user
    while($data = mysqli_fetch_array($sql))
    {
        $krom_awal = $data['jml_krom_awal'];
        $generasi = $data['jml_generasi'];
        $mutasi = $data['prob_mutasi'];
        $crossover = $data['prob_crossover'];
        $updateby = $data['update_by'];
        $waktu_update = $data['waktu_update'];
    }
  ?>
<center><h2>VARIABEL ALGEN</h2></center><br>
<form class="form-horizontal" method="post" action="proseseditvaralgen.php">
      <div class="form-group">
        <label class="control-label col-sm-4 col-md-6" for="crossover">Probabilitas Crossover:</label>
        <div class="col-sm-3 col-md-3">
          <select class="form-control" name="crossover" id="crossover">
            <option value="10" <?php if($crossover == 10){ echo "selected"; } ?>>10</option>
            <option value="20" <?php if($crossover == 20){ echo "selected"; } ?>>20</option>
            <option value="30" <?php if($crossover == 30){ echo "selected"; } ?>>30</option>
            <option value="40" <?php if($crossover == 40){ echo "selected"; } ?>>40</option>
            <option value="50" <?php if($crossover == 50){ echo "selected"; } ?>>50</option>
            <option value="60" <?php if($crossover == 60){ echo "selected"; } ?>>60</option>
            <option value="70" <?php if($crossover == 70){ echo "selected"; } ?>>70</option>
            <option value="80" <?php if($crossover == 80){ echo "selected"; } ?>>80</option>
            <option value="90" <?php if($crossover == 90){ echo "selected"; } ?>>90</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-4 col-md-6" for="mutasi">Probabilitas Mutasi:</label>
        <div class="col-sm-3 col-md-3"> 
          <select class="form-control" name="mutasi" id="mutasi" >
            <option value="10" <?php if($mutasi == 10){ echo "selected"; } ?>>10</option>
            <option value="20" <?php if($mutasi == 20){ echo "selected"; } ?>>20</option>
            <option value="30" <?php if($mutasi == 30){ echo "selected"; } ?>>30</option>
            <option value="40" <?php if($mutasi == 40){ echo "selected"; } ?>>40</option>
            <option value="50" <?php if($mutasi == 50){ echo "selected"; } ?>>50</option>
            <option value="60" <?php if($mutasi == 60){ echo "selected"; } ?>>60</option>
            <option value="70" <?php if($mutasi == 70){ echo "selected"; } ?>>70</option>
            <option value="80" <?php if($mutasi == 80){ echo "selected"; } ?>>80</option>
            <option value="90" <?php if($mutasi == 90){ echo "selected"; } ?>>90</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-4 col-md-6" for="generasi">Jumlah Generasi:</label>
        <div class="col-sm-3 col-md-3"> 
          <select class="form-control" name="generasi" id="generasi">
            <option value="5" <?php if($generasi == 5){ echo "selected"; } ?>>5</option>
            <option value="10" <?php if($generasi == 10){ echo "selected"; } ?>>10</option>
            <option value="15" <?php if($generasi == 15){ echo "selected"; } ?>>15</option>
            <option value="20" <?php if($generasi == 20){ echo "selected"; } ?>>20</option>
            <option value="25" <?php if($generasi == 25){ echo "selected"; } ?>>25</option>
            <option value="50" <?php if($generasi == 50){ echo "selected"; } ?>>50</option>
            <option value="75" <?php if($generasi == 75){ echo "selected"; } ?>>75</option>
            <option value="100" <?php if($generasi == 100){ echo "selected"; } ?>>100</option>
            <option value="125" <?php if($generasi == 125){ echo "selected"; } ?>>125</option>
            <option value="150" <?php if($generasi == 150){ echo "selected"; } ?>>150</option>
          </select> 
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-4 col-md-6" for="kromawal">Jumlah Kromosom Awal:</label>
        <div class="col-sm-3 col-md-3"> 
          <select class="form-control" name="kromawal" id="kromawal">
            <option value="5" <?php if($krom_awal == 5){ echo "selected"; } ?>>5</option>
            <option value="10" <?php if($krom_awal == 10){ echo "selected"; } ?>>10</option>
            <option value="15" <?php if($krom_awal == 15){ echo "selected"; } ?>>15</option>
            <option value="20" <?php if($krom_awal == 20){ echo "selected"; } ?>>20</option>
            <option value="25" <?php if($krom_awal == 25){ echo "selected"; } ?>>25</option>
            <option value="30" <?php if($krom_awal == 30){ echo "selected"; } ?>>30</option>
            <option value="35" <?php if($krom_awal == 35){ echo "selected"; } ?>>35</option>
            <option value="40" <?php if($krom_awal == 40){ echo "selected"; } ?>>40</option>
            <option value="45" <?php if($krom_awal == 45){ echo "selected"; } ?>>45</option>
            <option value="50" <?php if($krom_awal == 50){ echo "selected"; } ?>>50</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-4 col-md-6" for="lastupdate">Terakhir Update:</label>
        <div class="col-sm-8 col-md-3"> 
          <input type="text" class="form-control" name="lastupdate" id="lastupdate" value = "<?php echo $waktu_update?>" readonly>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-4 col-md-6" for="updateby">Update Oleh:</label>
        <div class="col-sm-8 col-md-3"> 
          <input type="text" class="form-control" name="updateby" id="updateby" value = "<?php echo $updateby?>" readonly>
        </div>
      </div>
      <div class="form-group"> 
        <div class="col-sm-offset-4 col-sm-6 col-md-5">
          <button type="submit" class="btn btn-block btn-info" name="editvariabelalgen">Simpan</button>
        </div>
      </div>
    </form>