<html lang="en">
<?php
	include('config.php');
?>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pencarian Rute Terpendek</title>

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="assets/css/mdb.min.css" rel="stylesheet">
    <script src="assets/jquery/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyAaVkt8Mw1QlujYck2dFbvTxGeo7f-tx4A" type="text/javascript"></script>

    <style>
    .modal {
	  text-align: center;
	  padding: 0!important;
	}

	.modal:before {
	  content: '';
	  display: inline-block;
	  height: 100%;
	  vertical-align: middle;
	  margin-right: -4px;
	}

	.modal-dialog {
	  display: inline-block;
	  text-align: left;
	  vertical-align: middle;
	}
    .gmap {
        position: relative;
        padding-bottom: 60%; // This is the aspect ratio
        height: 0;
        overflow: hidden;
    }
    .map iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 90%;
        height: 100%;
    }
    </style>
  </head>
  <body onload="initMaps()">
  <div class="container">
  <div class="page-header" align="center">
    <h2>Simulasi Pencarian Rute Terpendek</h2>
  </div>

  <div class="row">
	  	<div class="col-md-12">
	  			<div class="row form-group">
	  				<div class="col-md-10">
		  				<select id="asal" name="asal" class="form-control" onchange="loadSama(); disablecheckbox(); LoadMarkerPeta();">
					  		<option disabled selected>Pilih Titik Asal</option>
						    <?php
						    $nomor=0;
						    $sql1	= 'SELECT * FROM lokasi ORDER BY nama';
						    $query1 = mysqli_query($dbconnect,$sql1);
						    if(mysqli_num_rows($query1) <> 0){
						        while($data1 = mysqli_fetch_array($query1)){ $nomor++; ?>
						            <option value="<?php echo $data1['id_lokasi'].",".$nomor?>"> <?php echo $data1['nama'] ?> </option>
						        <?php }
						    }
						    ?>
						</select>
					</div>
				</div>


				<div class="row form-group">
					<div class="col-md-10">
		  				<select id="tujuan" name="tujuan" class="form-control" onchange="disablecheckbox(); LoadMarkerPeta();">
					  		<option disabled selected>Pilih Titik Tujuan</option>
						    <?php
						    $nomor=0;
						    $tempat = array();
						    $sql1	= 'SELECT * FROM lokasi ORDER BY nama';
						    $query1 = mysqli_query($dbconnect,$sql1);
						    if(mysqli_num_rows($query1) <> 0){
						        while($data1 = mysqli_fetch_array($query1)){ $nomor++; $tempat[$nomor]= $data1['id_lokasi']; ?>			      		<option value="<?php echo $data1['id_lokasi'].",".$nomor?>"> <?php echo $data1['nama'] ?> </option>
						        <?php }
						    }
						    ?>
						</select>
					</div>
				</div>
				<div class="table-responsive">
					<label class="control-label" for="tujuan">Titik Tujuan:</label>
					<form id="kunjungan">
					<table class="table" border="0">
				    <?php
				    $x=0;
				    $sql	= 'SELECT * FROM lokasi ORDER BY nama';
				    $query = mysqli_query($dbconnect,$sql);
				    if(mysqli_num_rows($query) <> 0){
				        while($data = mysqli_fetch_array($query)){ $x++;
				        	if(($x%3)==1){
				       ?>
				        		<tr><td>
				        			<div class="checkbox">
				        			<span title="<?php echo $data['nama']?>">
												<label class="btn btn-success">
													<input autocomplete="off" id="<?php echo $x?>" type="checkbox" value="<?php echo $data['id_lokasi'] ?>" onclick="LoadMarkerPeta();"> <?php echo $data['id_lokasi'] ?>
												</label>
											</span>
				        			</div>
				        		</td>
				        	<?php
				        }
				        	else{
				        		if($x%3==2){
				        			?>
				        			<td>
					        			<div class="checkbox">
													<span title="<?php echo $data['nama']?>">
														<label class="btn btn-success">
															<input autocomplete="off" id="<?php echo $x?>" type="checkbox" value="<?php echo $data['id_lokasi'] ?>" onclick="LoadMarkerPeta();"> <?php echo $data['id_lokasi'] ?>
														</label>
													</span>
					        			</div>
					        		</td>

				        		<?php }
				        		else{ ?>
				        			<td>
				        			<div class="checkbox">
												<span title="<?php echo $data['nama']?>">
													<label class="btn btn-success">
														<input autocomplete="off" id="<?php echo $x?>" type="checkbox" value="<?php echo $data['id_lokasi'] ?>" onclick="LoadMarkerPeta();"> <?php echo $data['id_lokasi'] ?>
													</label>
												</span>
				        			</div>
				        		</td>
				        		</tr>
				        	<?php	}
				        	}
				    	}
				    }

				    ?>
				    </form>
					    <tr><td colspan="3">
					    <div class="checkbox" style="visibility:hidden">
					        	<span title="Pilih Semua"><label><input type="checkbox" id="pilihsemua" onclick="PilihSemua(); LoadMarkerPeta();">Pilih Semua</label></span>
					    </div>
					    </td>
					    </tr>
				    </table>
				</div>

				<div class="form-group">
    				<div class="col-md-offset-3 col-sm-6 col-md-6">
						<input type="submit" class="btn btn-primary" value="Proses" id="prosesalgen" onclick="kirimdata(); onPageLoad();" /> <br>
					</div>
				</div>
	  	</div>

		  	<div class="col-md-8 col-sm-12">
		  			<div class="row">
							<hr>
		  				<div id="map" class="gmap col-md-12"></div>
		  			</div>
		  			<div class="row" id="select_rute">
		  				<div class="row">
		  					<div class="col-md-12" align="right">
		  						<div class="checkbox">
			  						<span title="Tampilkan Graph"><label><input id="tampilgraph" type="checkbox" onclick="loadgraph();">Graph</label></span>
			  					</div>
			  				</div>
		  				</div>
		  				<div class="row">
		  					<div class="col-md-12"><p id="rutefull" style="font-size:17px; font-weight: bold;"></p> </div>
				  		</div>
						<div class="row">
							<div class="form-group">
								<label class="control-label col-md-3" for="rute" align="left">Tampilkan Rute:</label>
						 		<div class="col-md-3">
									<select id="rute" name="rute" class="form-control">
									</select>
								</div>

							</div>
							<br><br>
						</div>
					</div>
</div>
		  	</div>


  </div>
	 <!-- Modal -->
	<div class="modal fade bs-example-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header" align="center">
	                <h4 class="modal-title">
	                    <span class="glyphicon glyphicon-time"></span>Loading
	                 </h4>
	            </div>
	            <div class="modal-body">
	                <div class="progress">
	                    <div class="progress-bar progress-bar-info
	                    progress-bar-striped active"
	                    style="width: 100%">
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>


  <script src="assets/jquery/jquery.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script type="text/javascript">
  	var startakhirtitik = new Array();
  	var startakhir = new Array();
  	var titikpeta = new Array();
  	var od = new Array();
  	var rute = new Array();
  	var rutefull = [];
  	var odpisah = new Array();
  	var latrute = new Array();
  	var lngrute = new Array();
  	var latlong = new Array();
  	var nodes = []; var markers = []; var prevNodes = []; var titik = []; var titikkunjungan = []; var titik2 = []; var rutegraph = [];
    var labelIndex = 0; var latitude = []; var longitude = []; var titik3 = []; var titikrute = []; var titikgraph = [];
    var map;

  	$(document).ready(function(){
	  $("#select_rute").hide();
	});

	$("#select_rute select").change(function(){

		var index = $("#select_rute select").val();

		if(index!=""){
			markers = [];
			/*titik = [];
			titik2 = [];
			titikpeta = [];
			titikkunjungan = [];*/
			//alert(rute[index]);
			latlong = rute[index];
			latlong = latlong.split(";");

			titikrute = odpisah[index];

			initMaps();
		}
		else{
			markers = [];
			latlong = [];
			initMaps();
		}


	});


	function onPageLoad() {
	  document.getElementById("tampilgraph").checked = true;
	}

	function loadgraph(){
		if(document.getElementById("tampilgraph").checked){
			rutegraph = rutefull;
			initMaps();
		}
		else{
			rutegraph = [];
			initMaps();
		}
	}



	function LoadSemuaTujuan(){
		for(i=1; i<= <?php echo $x ?>; i++){
				document.getElementById(i).checked = false;
			}
	}

  	function PilihSemua(){
		if (document.getElementById("pilihsemua").checked == true){
			for(i=1; i<= <?php echo $x ?>; i++){
				if(i==startakhirtitik[0] || i==startakhirtitik[1]){
					document.getElementById(i).checked = false;
				}
				else{
					document.getElementById(i).checked = true;
				}
			}
		}
		else{
			LoadSemuaTujuan();
		}
	}

	function EnableAll(){
		for(i=1; i<= <?php echo $x ?> ; i++){
				document.getElementById(i).disabled = false;
			}
	}

	function PushArray(a,array){
		x = array.length;
		if(x>=2){
			temp = array[1];
			array[0]=temp;
			array[1]=a;
		}
		else{
			array.push(a);
		}
	}

  	function disablecheckbox(){
  		LoadSemuaTujuan();
		document.getElementById("pilihsemua").checked = false;
		EnableAll();

		var x = document.getElementById("asal").value;
		var xsplit = x.split(",");
		var x1 = xsplit[0];
		var x2 = xsplit[1];

		var y = document.getElementById("tujuan").value;
		var ysplit = y.split(",");
		var y1 = ysplit[0];
		var y2 = ysplit[1];

		PushArray(x2,startakhirtitik);
		PushArray(y2,startakhirtitik);

		PushArray(x1,startakhir);
		PushArray(y1,startakhir);

		if(x2 == y2){
			document.getElementById(x2).disabled = true;
		}
		else{

			document.getElementById(x2).disabled = true;
			document.getElementById(y2).disabled = true;
		}
	}

	function loadSama(){
		document.getElementById("tujuan").value = document.getElementById("asal").value;
	}

	function kirimdata(){
	$("#rutefull").show();
	var Lewat = new Array();
	var x=0;
	var Kunjungan = document.forms.namedItem("kunjungan");
	for(i=0; i< Kunjungan.length; i++){
			  if(Kunjungan[i].checked){
				   Lewat[x] = Kunjungan[i].value;
				   x++;
			  }
		}
	if(startakhir.length == 0){
		window.alert("Silahkan Pilih Titik Asal dan Tujuan!");
	}
	else{
		if(Lewat.length == 0){
			window.alert("Silahkan Checklist Tempat yang akan dikunjungi");
		}
		else{
			$('#myModal').modal('show');

			jQuery.ajax({
						url: 'algen.php',
						type: 'POST',
						data: {
							startakhir,
							Lewat,
						},
						dataType : 'json',

						success: function(data) {
							/*console.log(data);
							alert(data);
							$("#cetak").html(data);*/

							var json = data;
							od = [];
							rute = [];
							rutefull = [];
							odpisah = [];

							for (var i = 0; i < json.length; i++) {

								od.push(json[i].od);
								rute.push(json[i].rute);
								odpisah.push(json[i].odpisah);


							    //console.log("PAIR " + i + ": " + json[i].od);
							    //console.log("PAIR " + i + ": " + json[i].rute);
							    //console.log("PAIR " + i + ": " + json[i].odpisah);
							}
							rutefull = json[0].rutefull;
							//console.log("Rute Full : "+rutefull);
							tampilrutefull = " ";
							for(i=0; i<rutefull.length; i++){
								tampilrutefull = tampilrutefull + rutefull[i] + " => ";

							}
							tampilrutefull = tampilrutefull.substring(0,tampilrutefull.length-3);
							document.getElementById("rutefull").innerHTML = "Rute yang harus dilewati adalah "+tampilrutefull;


							select =" ";
							select = "<option value=>SELECT RUTE</option>";

							od.forEach(function(currentValue, index){

								select = select + "<option value="+index+">"+currentValue+"</option>";

							});

							$("#select_rute").show();

							$("#select_rute select").html(" ");
							$("#select_rute select").html(select);
							$('#myModal').modal('hide');

							loadgraph();
							initMaps();
							//window.alert("Data terkirim");
							// do with data e.g success message
						},
						error: function(error) {
							console.log(error);
						}
					});

		}
	}


}




   function LoadMarkerPeta(){
   		titikgraph = [];
   		rutegraph = [];
   		latlong = [];
   		$("#select_rute").hide();
   		$("#rutefull").hide();

   		titik = [];
  		titikpeta = [];
  		titikkunjungan = [];
  		titik2 = [];
  		titikrute = [];
  		titik3 = [];

  		var x = document.getElementById("asal").value;
		var xsplit = x.split(",");
		var x1 = xsplit[0];
		var x2 = xsplit[1];

		var y = document.getElementById("tujuan").value;
		var ysplit = y.split(",");
		var y1 = ysplit[0];
		var y2 = ysplit[1];

		titikpeta.push(x1);
		if(x1!=y1){
			titikpeta.push(y1);
		}
		var z=0;
		var Kunjungan = document.forms.namedItem("kunjungan");
		for(i=0; i< Kunjungan.length; i++){
			  if(Kunjungan[i].checked){
				   titikkunjungan[z] = Kunjungan[i].value;
				   z++;
			  }
		}

		initMaps();
  	}

  		function addPoint(latlng) {
		    var marker = new google.maps.Marker({
		        position: latlng,
		        map: map
		    });

		    markers.push(marker);

		    polyline.getPath().setAt(markers.length - 1, latlng);

		}

		function tampilGraph(lat, lng) {
			var lokasi = new google.maps.LatLng(lat, lng);
		    var marker = new google.maps.Marker({
		        position: lokasi,
		        map: map
		    });

		    graph.push(marker);

		    garis_graph.getPath().setAt(graph.length - 1, lokasi);

		}

		function tampilRute(lat, lng) {
            var lokasi = new google.maps.LatLng(lat, lng);
            addPoint(lokasi);

            //map.fitBounds(bounds);

            // Store node's lat and lng
            latitude.push(lat);
            longitude.push(lng);
         }





function initMaps(){
		markers = []; graph = [];
		latitude = []; longitude = [];

  //    menentukan koordinat titik tengah peta
        var myLatlng = new google.maps.LatLng(-7.050303, 110.439849);

    //  pengaturan zoom dan titik tengah peta
        var myOptions = {
                  zoom: 16,
                  center: myLatlng
              };

    // menampilkan output pada element
        var map = new google.maps.Map(document.getElementById("map"), myOptions);

    // Variabel untuk menyimpan informasi (desc)
        var infoWindow = new google.maps.InfoWindow;

     // Variabel untuk menyimpan batas kordinat
        var bounds = new google.maps.LatLngBounds();

        var lineSymbol = {
          path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW
        };

        function animateCircle(line) {
		    var count = 0;
		    window.setInterval(function() {
		      count = (count + 1) % 200;

		      var icons = line.get('icons');
		      icons[0].offset = (count / 2) + '%';
		      line.set('icons', icons);
		  }, 20);
		}

	    polyline = new google.maps.Polyline({
	        strokeColor: 'red',
	        strokeWeight: 2,
	        map: map,
	        icons: [{
	            icon: lineSymbol,
	            offset: '100%'
	          }],
	    });


	    garis_graph = new google.maps.Polyline({
	        strokeColor: 'blue',
	        strokeWeight: 2,
	        map: map,
	        icons: [{
	            icon: lineSymbol,
	            offset: '100%'
	          }],
	    });

	    animateCircle(garis_graph);

	    var gambar1 = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=|FF0000'
        // Proses membuat marker
        function addMarker(lat, lng, info) {
            var lokasi = new google.maps.LatLng(lat, lng);
            bounds.extend(lokasi);
            var marker = new google.maps.Marker({
                map: map,
                position: lokasi,
                icon : gambar1
            });
            map.fitBounds(bounds);
            bindInfoWindow(marker, map, infoWindow, info);
         }
         var gambar = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=|00FF00';
         function addMarkerStart(lat, lng, info) {
            var lokasi = new google.maps.LatLng(lat, lng);
            bounds.extend(lokasi);
            var marker = new google.maps.Marker({
                map: map,
                position: lokasi,
                icon : gambar

            });
            map.fitBounds(bounds);
            bindInfoWindow(marker, map, infoWindow, info);
         }


        // Menampilkan informasi pada masing-masing marker yang diklik
        function bindInfoWindow(marker, map, infoWindow, html) {
          google.maps.event.addListener(marker, 'click', function() {
            infoWindow.setContent(html);
            infoWindow.open(map, marker);
          });
        }

        //google.maps.event.addDomListener(window, 'load', initMaps);

        var cetakmarker = [

        <?php
        	$query = mysqli_query($dbconnect,"SELECT * FROM lokasi");
            while ($data = mysqli_fetch_array($query))
            {
                $nama = $data['nama'];
                $lat = $data['lat'];
                $lng = $data['lng'];
                $id = $data['id_lokasi'];

                echo ("{id: '$id', lat: $lat, lng: $lng, info:'<b>$nama</b>'},\n");
            }

        ?>
    ];

    panjang = cetakmarker.length;
	jumlah = titikrute.length;
	    for(j=0; j<jumlah; j++){
	    	for(i=0; i<panjang; i++){
	    		if(titikrute[j]==cetakmarker[i].id){
	    			titik3[j] = i;
	    		}
	    	}
	}


	panjang = titik3.length;
    for(i=0; i<panjang; i++){
    	addMarker(cetakmarker[titik3[i]].lat, cetakmarker[titik3[i]].lng, cetakmarker[titik3[i]].info);
    }

    panjang = cetakmarker.length;
    jumlah = titikpeta.length;
    for(j=0; j<jumlah; j++){
    	for(i=0; i<panjang; i++){
    		if(titikpeta[j]==cetakmarker[i].id){
    			titik[j] = i;
    		}
    	}
    }

    panjang = titik.length;
    for(i=0; i<panjang; i++){
    	addMarkerStart(cetakmarker[titik[i]].lat, cetakmarker[titik[i]].lng, cetakmarker[titik[i]].info);
    }

    panjang = cetakmarker.length;
    jumlah = titikkunjungan.length;
    for(j=0; j<jumlah; j++){
    	for(i=0; i<panjang; i++){
    		if(titikkunjungan[j]==cetakmarker[i].id){
    			titik2[j] = i;
    		}
    	}
    }


    panjang = titik2.length;
    for(i=0; i<panjang; i++){
    	addMarker(cetakmarker[titik2[i]].lat, cetakmarker[titik2[i]].lng, cetakmarker[titik2[i]].info);
    }

    panjang = latlong.length;
    for(i=0; i<panjang; i++){
    	var latrute = latlong[i].split(",");
    	tampilRute(latrute[0],latrute[1]);
    }

    if(rutegraph.length != 0){
    	panjang = cetakmarker.length;
		jumlah = rutegraph.length;
		    for(j=0; j<jumlah; j++){
		    	for(i=0; i<panjang; i++){
		    		if(rutegraph[j]==cetakmarker[i].id){
		    			titikgraph[j] = i;
		    		}
		    	}
		}

		panjang = titikgraph.length;
	    for(i=0; i<panjang; i++){
	    	tampilGraph(cetakmarker[titikgraph[i]].lat, cetakmarker[titikgraph[i]].lng);
	    }
    }

    //document.getElementById("loadmarker").innerHTML = cetakmarker[0].id;
}


  </script>
  </div>
  <!-- <div class="panel-footer" align="center"><strong>Copyright &copy; 2016<a href="http://undip.ac.id"> Universitas Diponegoro</a>.</strong> All rights reserved.</div> -->
  </body>
</html>
