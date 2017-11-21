<?php

require './../config.php';
?>
<head>
  <script src="http://maps.google.com/maps/api/js?key=AIzaSyAaVkt8Mw1QlujYck2dFbvTxGeo7f-tx4A" type="text/javascript"></script>
  <style>
    .gmap {
        position: relative;
        padding-bottom: 40%; // This is the aspect ratio
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
    var labelIndex = 0;
    var map;
    

function initMaps(){
  //              menentukan koordinat titik tengah peta
              var myLatlng = new google.maps.LatLng(-7.050303, 110.439849);
 
    //              pengaturan zoom dan titik tengah peta
              var myOptions = {
                  zoom: 16,
                  center: myLatlng
              };
              
    //              menampilkan output pada element
              var map = new google.maps.Map(document.getElementById("map"), myOptions);
              
       
        
    // Add a node to map
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

    

    // Removes markers and temporary paths
function clearMapMarkers() {
      for (index in markers) {
        markers[index].setMap(null);
      }

      prevNodes = nodes;
      nodes = [];      
      markers = [];
}


    </script> 
</head>
<body onload="initMaps()">
<center><h2>TAMBAH LOKASI</h2></center>
<center><div id="map" class="gmap"></div></center><br>
<form class="form-horizontal" method="post" action="prosestambahlokasi.php">
  <div class="form-group">
    <label class="control-label col-sm-4 col-md-5" for="id">ID:</label>
    <div class="col-sm-8 col-md-4">
      <input type="text" class="form-control" name="id" id="id">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-4 col-md-5" for="lokasi">Nama Lokasi:</label>
    <div class="col-sm-8 col-md-4"> 
      <input type="text" class="form-control" name="lokasi" id="lokasi">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-4 col-md-5" for="latitude">Latitude:</label>
    <div class="col-sm-8 col-md-4"> 
      <input type="text" class="form-control" name="latitude" id="latitude" readonly>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-4 col-md-5" for="longitude">Longitude:</label>
    <div class="col-sm-8 col-md-4"> 
      <input type="text" class="form-control" name="longitude" id="longitude" readonly>
    </div>
  </div>
  <div class="form-group"> 
    <div class="col-sm-offset-5 col-sm-5">
      <button type="submit" class="btn btn-default" name="tambahlokasi">Simpan</button>
    </div>
  </div>
</form>
</body>

