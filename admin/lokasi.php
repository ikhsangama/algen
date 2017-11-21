<?php

require './../config.php';
?>
<head>
	<script src="http://maps.google.com/maps/api/js?key=AIzaSyAaVkt8Mw1QlujYck2dFbvTxGeo7f-tx4A" type="text/javascript"></script>
    <style>
    .gmap {
        position: relative;
        padding-bottom: 30%; // This is the aspect ratio
        height: 0;
        overflow: hidden;
    }
    .map iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    </style>
	<script type="text/javascript">

	var marker;
      function initialize() {
          
        // Variabel untuk menyimpan informasi (desc)
        var infoWindow = new google.maps.InfoWindow;
        
        //  Variabel untuk menyimpan peta Roadmap
        var mapOptions = {
          mapTypeId: google.maps.MapTypeId.ROADMAP
        } 
        
        // Pembuatan petanya
        var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
              
        // Variabel untuk menyimpan batas kordinat
        var bounds = new google.maps.LatLngBounds();

        // Pengambilan data dari database
        <?php
            $y = 0;
            $query = mysqli_query($dbconnect,"SELECT * FROM lokasi");
            while ($data = mysqli_fetch_array($query))
            {   
                $y++;
                $nama = $data['nama'];
                $lat = $data['lat'];
                $lon = $data['lng'];
                
                echo ("addMarker($lat, $lon, '<b>$nama</b>','$y');\n");                        
            }
          ?>
          
        // Proses membuat marker 
        function addMarker(lat, lng, info, lab) {
            var lokasi = new google.maps.LatLng(lat, lng);
            bounds.extend(lokasi);
            var marker = new google.maps.Marker({
                map: map,
                label: lab,
                position: lokasi
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
 
        }
      google.maps.event.addDomListener(window, 'load', initialize);

	</script>
</head>
<body onload="initialize()">
<center><h2>DAFTAR LOKASI</h2>
<div id="map-canvas" class="gmap"></div></center>
<div class="table-responsive">
	<table class="table table-striped green">
		<thead >
			<tr>
				<th>No</th>
				<th>ID</th>
				<th>Nama Lokasi</th>                
				<th></th>
                <th></th>
                <th colspan="2" align="centre">Terakhir Update</th>
			</tr>
		</thead>
	<tr>

<?php 
$i=0; //inisialisasi untuk penomoran data
//perintah untuk menampilkan data, id_brg terbesar ke kecil
$tampil = "SELECT * FROM lokasi ORDER BY nama";
//perintah menampilkan data dikerjakan
$sql = mysqli_query($dbconnect, $tampil);

//tampilkan seluruh data yang ada pada tabel user
while($data = mysqli_fetch_array($sql))
 {
 $i++;
?>
 <td><?php echo $i ?></td>
 <td><?php echo $data['id_lokasi']?></td>
 <td><?php echo $data['nama']?></td>
 <td><a href="index.php?page=edit_lokasi&lokasi=<?php echo $data['id_lokasi'];?>"> <button type='button' class='btn btn-info'><i class='glyphicon glyphicon-pencil'></i> Edit</button></a></td>
 <td><a href="hapuslokasi.php?id=<?php echo $data['id_lokasi'];?>" onclick="return confirm('Yakin mau hapus <?php echo $data['nama']?>?');"> <button type='button' class='btn btn-danger'><i class='glyphicon glyphicon-trash'></i> Hapus</button></a></td>
 <td><?php echo $data['update_by']?></td>
 <td><?php echo $data['waktu_update']?></td>
 </tr>
 
 <?php 
 }
 ?>
</table>
 </div>
 <a href='index.php?page=tambah_lokasi'><button type='button' class='btn btn-success'><i class='glyphicon glyphicon-plus'></i> Tambah</button></a>
 
 </body>