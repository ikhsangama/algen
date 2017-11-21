<?php

require './../config.php';
if (isset($_GET['lokasi'])){
  $lokasi = $_GET['lokasi'];
}
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
    var nodes = []; var markers = []; var prevNodes = [];
    var map;
      
      var marker;
      function clearMapMarkers() {
            for (index in markers) {
              markers[index].setMap(null);
            }

            prevNodes = nodes;
            nodes = [];      
            markers = [];
      }
      function initialize() {
          
        // Variabel untuk menyimpan informasi (desc)
        var infoWindow = new google.maps.InfoWindow;
        
        var myLatlng = new google.maps.LatLng(-7.050303, 110.439849);

        //  Variabel untuk menyimpan peta Roadmap
        var mapOptions = {
          mapTypeId: google.maps.MapTypeId.ROADMAP,
          zoom: 16,
          center: myLatlng
        } 
        
        // Pembuatan petanya
        var map = new google.maps.Map(document.getElementById('map'), mapOptions);
              
        // Variabel untuk menyimpan batas kordinat
        var bounds = new google.maps.LatLngBounds();

        // Pengambilan data dari database
        <?php
            $query = mysqli_query($dbconnect,"SELECT * FROM lokasi WHERE id_lokasi='".$lokasi."'");
            while ($data = mysqli_fetch_array($query))
            {   
                $nama = $data['nama'];
                $lat = $data['lat'];
                $lon = $data['lng'];
                
                echo ("addMarker($lat, $lon, '<b>$nama</b>');\n");                        
            }
          ?>
          
        // Proses membuat marker 
        function addMarker(lat, lng, info) {
            var lokasi = new google.maps.LatLng(lat, lng);
            bounds.extend(lokasi);
            var marker = new google.maps.Marker({
                map: map,
                position: lokasi
            });       
            markers.push(marker);
            //map.fitBounds(bounds);
            bindInfoWindow(marker, map, infoWindow, info);
         }
        
        // Menampilkan informasi pada masing-masing marker yang diklik
        function bindInfoWindow(marker, map, infoWindow, html) {
          google.maps.event.addListener(marker, 'click', function() {
            infoWindow.setContent(html);
            infoWindow.open(map, marker);
          });
        }


          google.maps.event.addListener(map, 'click', function(event) {
    
          clearMapMarkers();
            // Add a new marker at the new plotted point on the polyline.
                
          marker = new google.maps.Marker({
          position: event.latLng, 
          map: map,
          });
          markers.push(marker);
          
          // Store node's lat and lng
          var lat = event.latLng.lat();
          var lng = event.latLng.lng();
          nodes.push(lat);
          nodes.push(lng);   
            
          
          document.getElementById("latitude").value = nodes[0];
          document.getElementById("longitude").value = nodes[1];    
            
          });
          
    }       

      google.maps.event.addDomListener(window, 'load', initialize);

          // Removes markers and temporary paths
      

  </script>
</head>
<body onload="initialize()">
<center><h2>EDIT LOKASI</h2></center>
<center><div id="map" class="gmap"></div></center><br>
<form class="form-horizontal" method="post" action="proseseditlokasi.php">
  <div class="form-group">
    <label class="control-label col-sm-4 col-md-5" for="id">ID:</label>
    <div class="col-sm-8 col-md-4">
      <input type="text" class="form-control" name="id" id="id" value="<?php echo $lokasi?>" readonly>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-4 col-md-5" for="lokasi">Nama Lokasi:</label>
    <div class="col-sm-8 col-md-4"> 
      <input type="text" class="form-control" name="lokasi" id="lokasi" value = "<?php echo $nama?>">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-4 col-md-5" for="latitude">Latitude:</label>
    <div class="col-sm-8 col-md-4"> 
      <input type="text" class="form-control" name="latitude" id="latitude" value="<?php echo $lat?>" readonly>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-4 col-md-5" for="longitude">Longitude:</label>
    <div class="col-sm-8 col-md-4"> 
      <input type="text" class="form-control" name="longitude" id="longitude" value="<?php echo $lon?>" readonly>
    </div>
  </div>
  <div class="form-group"> 
    <div class="col-sm-offset-5 col-sm-5">
      <button type="submit" class="btn btn-default" name="editlokasi">Simpan</button>
    </div>
  </div>
</form>
</body>

