<h2>
<p align="center">Rutee
</p></h2>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/jquery/jquery.min.js"></script>
<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/css/style.css" rel="stylesheet">

<?php
	include('./../config.php');	
?>
<div class="form-horizontal">
	<div class="form-group">
	    <label class="control-label col-sm-2 col-md-4" for="tempat">Titik Asal:</label>
	    <div class="col-sm-10 col-md-5">
			  	<select id="tempat" name="tempat" class="form-control" onchange="loadtabel()">
			  		<option></option>
				    <?php

				    $sql	= 'SELECT * FROM lokasi ORDER BY nama';
				    $query = mysqli_query($dbconnect,$sql);
				    if(mysqli_num_rows($query) <> 0){
				        while($data = mysqli_fetch_array($query)){ ?>			        
				            <option value="<?php echo $data['id_lokasi'] ?>"> <?php echo $data['nama'] ?> </option>
				        <?php }
				    }
				    ?>
				</select>
	    </div>
	</div>

</div>

<script>
	function loadtabel(){
		var tempat = document.getElementById("tempat").value;
		jQuery.ajax({
				url: 'prosesjarak.php',
				type: 'POST',
				data: {tempat},
				dataType : 'html',
						
				success: function(data) {
					//console.log(data);
					$("#cetak").html(data);
					//window.alert("Data terkirim");
					// do with data e.g success message
				},
				error: function(error) {
					console.log(error);
				}
			});
	}	
</script>
<p id="cetak"></p>