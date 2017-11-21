<?php
  include('./../config.php'); 
  if(isset($_GET['asal'])){
    $asal=$_GET['asal'];
    $tujuan = $_GET['tujuan'];
  }
  
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pencarian Rute Terpendek</title>
 
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyAaVkt8Mw1QlujYck2dFbvTxGeo7f-tx4A&libraries=drawing" type="text/javascript"></script>
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
    var latitude = []; var longitude = []; var markers = []; var poly;
    var map; var nodes = [];
    

function hitungJarak (fromLat, fromLng, toLat, toLng) {
    x = toLat - fromLat;
    y = toLng - fromLng;
    x = Math.pow(x,2);
    y = Math.pow(y,2);
    hasil = x + y;
    hasil = Math.sqrt(hasil);
    hasil = hasil * 111319;
    return hasil;
   }



function initialize() {

    var mapOptions = {
        zoom: 16,
        center: new google.maps.LatLng(-7.050303, 110.439849),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById('map'),
    mapOptions);

    var lineSymbol = {
          path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW
        };

    polyline = new google.maps.Polyline({
        strokeColor: 'red',
        strokeWeight: 2,
        map: map,
        icons: [{
            icon: lineSymbol,
            offset: '100%'
          }],
    });

    // Variabel untuk menyimpan informasi (desc)
        var infoWindow = new google.maps.InfoWindow;

     // Variabel untuk menyimpan batas kordinat
        var bounds = new google.maps.LatLngBounds();

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

        google.maps.event.addDomListener(window, 'load', initialize);

    google.maps.event.addListener(map, 'click', function (event) {

        addPoint(event.latLng);

        // Store node's lat and lng
        var lat = event.latLng.lat();
        var lng = event.latLng.lng();
        latitude.push(lat);
        longitude.push(lng);
        //nodes.push(lat);
        //nodes.push(lng); 

        panjang = latitude.length;
        totaljarak=0;

        for(i=0; i<panjang; i++){
            if(i>0){
              jarak = hitungJarak(latitude[i-1],longitude[i-1],latitude[i],longitude[i]);
              totaljarak = totaljarak + jarak;
              totaljarak = Math.ceil(totaljarak);
            }
        }
        document.getElementById("jarak").value = totaljarak;
    });

    <?php
            $titik[0]=$asal;
            $titik[1]=$tujuan;
            $y = 0;
            for($i=0; $i<2; $i++){
                $query = mysqli_query($dbconnect,"SELECT * FROM lokasi WHERE id_lokasi='".$titik[$i]."'");
                while ($data = mysqli_fetch_array($query))
                {   
                    $y++;
                    $nama = $data['nama'];
                    $lat[$i] = $data['lat'];
                    $lon[$i] = $data['lng'];
                    
                    echo ("addMarker($lat[$i], $lon[$i], '<b>$nama</b>','$y');\n");                        
                }
            }

            $query = mysqli_query($dbconnect,"SELECT rute FROM rute WHERE asal='".$asal."' AND tujuan='".$tujuan."'");

                while ($data = mysqli_fetch_array($query))
                {   
                    $rute = $data['rute'];                      
                }

                if($rute != null){
                    $rute = explode(',' , $rute);
                  $panjang = sizeof($rute);
                  $z=0;
                  for($i=0; $i<$panjang; $i++){
                      if($i%2==0){
                        $latitude[$z]=$rute[$i];
                      }
                      else{
                        $longitude[$z]=$rute[$i];
                        $z++;
                      }
                  }
                  $panjang = sizeof($latitude);
                  for($i=0; $i<$panjang; $i++){
                    echo ("tampilRute($latitude[$i], $longitude[$i]);\n"); 
                  }
                }               
          ?>

}

function removePoint(marker) {

    for (var i = 0; i < markers.length; i++) {

        if (markers[i] === marker) {

            markers[i].setMap(null);
            markers.splice(i, 1);

            latitude.splice(i,1);
            longitude.splice(i,1);

            polyline.getPath().removeAt(i);

            panjang = latitude.length;
            totaljarak=0;

            for(i=0; i<panjang; i++){
                if(i>0){
                  jarak = hitungJarak(latitude[i-1],longitude[i-1],latitude[i],longitude[i]);
                  totaljarak = totaljarak + jarak;
                  totaljarak = Math.ceil(totaljarak);
                }
            }
            document.getElementById("jarak").value = totaljarak;
        }
    }
}

function addPoint(latlng) {

    var gambar = 'http://maps.google.com/mapfiles/kml/paddle/blu-circle-lv.png';
    var marker = new google.maps.Marker({
        position: latlng,
        map: map,
        icon : gambar
    });

    markers.push(marker);
    

    polyline.getPath().setAt(markers.length - 1, latlng);

    google.maps.event.addListener(marker, 'click', function (event) {

        removePoint(marker);
    });
}

function tampilRute(lat, lng) {
            var lokasi = new google.maps.LatLng(lat, lng);
            addPoint(lokasi);

            //map.fitBounds(bounds);
      
            // Store node's lat and lng
            latitude.push(lat);
            longitude.push(lng);       
         }
   


    </script> 
  </head>
  <body onload="initialize()">

  <?php
    $tampil = "SELECT * FROM rute r WHERE asal='".$asal."' AND tujuan='".$tujuan."'";
    //perintah menampilkan data dikerjakan
    $sql = mysqli_query($dbconnect, $tampil);

    //tampilkan seluruh data yang ada pada tabel user
    while($data = mysqli_fetch_array($sql))
    {
        $jarak = $data['jarak'];
    }
  ?>
    <div id="map" class="gmap"></div>
    <button onclick="history.back(-1);" class="btn btn-info" ><i class='glyphicon glyphicon-circle-arrow-left'></i> Kembali</button>
    <form class="form-horizontal">
      <div class="form-group">
        <label class="control-label col-sm-4 col-md-5" for="asal">Asal (1):</label>
        <div class="col-sm-8 col-md-4">
          <input type="text" class="form-control" name="asal" id="asal" value="<?php echo $asal?>" readonly>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-4 col-md-5" for="tujuan">Tujuan (2):</label>
        <div class="col-sm-8 col-md-4"> 
          <input type="text" class="form-control" name="tujuan" id="tujuan" value="<?php echo $tujuan?>" readonly>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-4 col-md-5" for="jarak">Jarak:</label>
        <div class="col-sm-8 col-md-4"> 
          <input type="text" class="form-control" name="jarak" id="jarak" value="<?php echo $jarak?>" readonly>
        </div>
      </div>
      <div class="form-group"> 
        <div class="col-sm-offset-5 col-sm-5">
          <button type="submit" class="btn btn-default" onclick="kirimdata(); history.back(-1);">Simpan</button>
        </div>
      </div>
    </form>
    <script type="text/javascript">
      
      function kirimdata(){
        asal = document.getElementById("asal").value;
        tujuan = document.getElementById("tujuan").value;
        jarak = document.getElementById("jarak").value;
        panjang = latitude.length;
        w=0;
        for(i=0; i<panjang; i++){
            nodes[w]=latitude[i];
            w++;
            nodes[w]=longitude[i];
            w++
        }
        rute = nodes.toString();

          jQuery.ajax({
          url: 'prosestambahrutepeta.php',
          type: 'POST',
          data: {
            asal, 
            tujuan,
            jarak,
            rute
          },
          dataType : 'html',
              
          success: function(data) {
            //console.log(data);
            //$("#cetak").html(data);
            //window.alert("Data terkirim");
            // do with data e.g success message
          },
          error: function(error) {
            console.log(error);
          }
        });

      }
      

    </script>
  </body>
