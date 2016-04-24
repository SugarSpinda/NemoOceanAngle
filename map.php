<?php
  session_start();
  include("mysql_connect.inc.php");
  $view = $_GET["view"];
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Map</title>
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        background: #c6E0f5;
      }
      #map {
		position: fixed;
        height: 100%;
      }

	#map_warp {
		position: absolute;
        z-index: 100;
	}

/*    #map_home_btn {
		position: absolute;
    	right: 0;
    	display: block;
        background-color: transparent;
        border: none;
        cursor: pointer;
        max-width: 5%;
    }
*/
    #icon_description {
		position: absolute;
        z-index: 100;
        bottom: 0;
        left: 0;
        max-width: 20%;
    }

    #map_menu {
    	/*float: left;*/
    	display: block;
        background-color: transparent;
        border: none;
        cursor: pointer;
        max-width: 15%;
    }

    .dropbtn {
    	display: block;
        background-color: transparent;
        border: none;
        cursor: pointer;
    }

    img {
    	max-width: 100%;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #c6E0f5;
        color: #6a90c6;
        min-width: 220px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 100;
    }

    .dropdown-content a {
        padding: 12px 16px;
        color: #6a90c6;
        text-decoration: none;
        display: block;
        border-bottom: 3px solid #FFFECF;
    }

    .dropdown-content a:last-child {
        border-bottom: none;
    }
    .dropdown-content a:hover {background-color: #FFFECF}

    .dropdown:hover .dropdown-content {
        display: block;
    }

    </style>
  </head>
  <body>
    <div id="map_warp">
      <div id="map_menu">
        <div class="dropdown">
          <div class="dropbtn"><img src="menu.png"/></div>
          <div class="dropdown-content">
<?php
          if($_SESSION['num'] == null) {
          	echo '<a href="elogin.php">Login</a>';
          } else {
          	echo '<a href="map.php?view=0">Show All GPS</a>';
          }
?>
            <a href="map.php?view=1">Show Public GPS</a>
<?php
          if($_SESSION['num'] != null) {
          	echo '<a href="map.php?view=2">Show Private GPS</a>';
          	echo '<a href="manage.php">Manage GPS Devices</a>';
          }
?>
          </div>
      </div>
      <!-- <div id="map_home_btn"><img src="home_btn.png"/></div> -->
      </div>
    </div>
    <div id="map"></div>
    <script>
      var points = {
<?php
  if($_SESSION['num'] == null) {
    $sql = "select M.*, I.type, I.text FROM MAP M, INFO I where M.private=0 GROUP BY M.id";
    $retval = mysql_query($sql, $conn);
    if (!$retval) { die('Could not enter data: ' . mysql_error()); }

  	$row = mysql_fetch_assoc($retval);

    while ($row)
    {
      echo "id_".$row["id"].": {";
      echo "id: ".$row["id"].",";
      echo 'text: "'.$row["text"].'",';
      echo "center: { lat: ".$row['latitude'].", lng: ".$row['longitude']."},";
      echo "range: 6,";	// TODO: set range
      echo 'rangeColor: "#ffb3b3",';
      echo 'markerWidth: 6,';
      echo 'markerHeight: 6,';
      echo 'markerIcon: "all_public.png"';

  	  if ($row = mysql_fetch_assoc($retval)) {
        echo "},";
  	  } else {
        echo "}";
  	  }
    }
  } else {
  	if ($view == 1) {
      $sql = "select M.*, I.type, I.text FROM MAP M, INFO I where M.private=0 GROUP BY M.id";
  	} else if ($view == 2) {
      $sql = "select M.*, I.type, I.text FROM MAP M, INFO I where M.uid=".
        $_SESSION['num']." GROUP BY M.id";
  	} else {
      $sql = "select M.*, I.type, I.text FROM MAP M, INFO I where M.private=0 OR M.uid=".
        $_SESSION['num']." GROUP BY M.id";
  	}
    $retval = mysql_query($sql, $conn);
    if (!$retval) { die('Could not enter data: ' . mysql_error()); }

  	$row = mysql_fetch_assoc($retval);

    while ($row)
    {
      echo "id_".$row["id"].": {";
      echo "id: ".$row["id"].",";
      echo 'text: "'.$row["text"].'",';
      echo "center: { lat: ".$row['latitude'].", lng: ".$row['longitude']."},";
      echo "range: 6,";	// TODO: set range
      echo 'rangeColor: "#ffb3b3",';

      if ($row['id'] == 882346 && $_SESSION["num"] == 1) {	// other boat
      // if ($row['type'] == 99 && $row['uid'] != $_SESSION["num"]) {	// other boat
        echo 'markerWidth: 16,';
        echo 'markerHeight: 24,';
        echo 'markerIcon: "other_boat.png"';
      } else if ($row['id'] == 191525 && $_SESSION["num"] == 1) {
        echo 'markerWidth: 24,';
        echo 'markerHeight: 36,';
        echo 'markerIcon: "self_boat.png"';
      } else if ($row['id'] == 882346 && $_SESSION["num"] == 2) {	// self boat
      // } else if ($row['type'] == 99) {	// self boat
        echo 'markerWidth: 24,';
        echo 'markerHeight: 36,';
        echo 'markerIcon: "self_boat.png"';
      } else if ($row['id'] == 191525 && $_SESSION["num"] == 2) {
        echo 'markerWidth: 16,';
        echo 'markerHeight: 24,';
        echo 'markerIcon: "other_boat.png"';
      } else if ($row['private'] == 1) {	// self private
        echo 'markerWidth: 12,';
        echo 'markerHeight: 12,';
        echo 'markerIcon: "self_private.png"';
      } else if ($row['uid'] == $_SESSION['num']) {	// self public
        echo 'markerWidth: 6,';
        echo 'markerHeight: 6,';
        echo 'markerIcon: "self_public.png"';
      } else {	// all public
        echo 'markerWidth: 6,';
        echo 'markerHeight: 6,';
        echo 'markerIcon: "all_public.png"';
      }

  	  if ($row = mysql_fetch_assoc($retval)) {
        echo "},";
  	  } else {
        echo "}";
  	  }
    }
  }
?>
      };
      var markers = [];
      var ids = [];

      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 18,
          mapTypeControl: false,
          center: {lat: 45.328163, lng: -64.936763},
          // center: {lat: 23.973875, lng: 120.982024},
          mapTypeId: google.maps.MapTypeId.HYBRID
        });

		var infoWindow = new google.maps.InfoWindow();

        for (var p in points) {
          var cityCircle = new google.maps.Circle({
            strokeWeight: 0,
            fillColor: points[p].rangeColor,
            fillOpacity: 0.35,
            map: map,
            center: points[p].center,
            radius: points[p].range
          });

          var icon = {
              url: points[p].markerIcon,
              scaledSize: new google.maps.Size(points[p].markerWidth, points[p].markerHeight),
              origin: new google.maps.Point(0,0),
              anchor: new google.maps.Point(points[p].markerWidth / 2, points[p].markerHeight / 2)
          };

          var marker = new google.maps.Marker({
            // position: {lat: 23.973875, lng: 120.982024},
            position: {lat: points[p].center.lat, lng: points[p].center.lng},
            map: map,
            icon: icon
          });

          markers.push({ markerObject: marker, circleObject: cityCircle });
          ids.push(points[p].id);

          google.maps.event.addListener(marker, "click", (function(marker, p) {

            return function() {
              infoWindow.setContent(
                "<div id=\"maker_wrap\">" +
                  "<h2>ID: " + p.id + "</h2>" +
                  "<h3>" + p.text + "</h3>" +
                  "<h4>Location: (" + p.center.lat + ", " + p.center.lng + ")</h4>" +
                "</div>"
              );
              infoWindow.open(map, marker);
            }
          })(marker, points[p]));
        }

        try{google.maps.event.addDomListener(window, 'load', initialize);} catch (e){}
		  // // Try HTML5 geolocation.
		  // if (navigator.geolocation) {
		  //   navigator.geolocation.getCurrentPosition(function(position) {
		  //     var pos = {
		  //       lat: position.coords.latitude,
		  //       lng: position.coords.longitude
		  //     };

		  //     infoWindow.setPosition(pos);
		  //     infoWindow.setContent('Location found.');
		  //     map.setCenter(pos);
		  //   }, function() {
		  //     handleLocationError(true, infoWindow, map.getCenter());
		  //   });
		  // } else {
		  //   // Browser doesn't support Geolocation
		  //   handleLocationError(false, infoWindow, map.getCenter());
		  // }

      }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
      infoWindow.setPosition(pos);
      infoWindow.setContent(browserHasGeolocation ?
                            'Error: The Geolocation service failed.' :
                            'Error: Your browser doesn\'t support geolocation.');
    }

    function updateMarker(lat, lng, index){
      for (var i = 0; i < markers.length; i++) {
      	if (i == index) {
          markers[i].markerObject.setPosition(new google.maps.LatLng(lat, lng));
          markers[i].circleObject.setCenter(new google.maps.LatLng(lat, lng));
        }
      }
    }

    function getHandler(responseText, index) {
    	var split = responseText.indexOf(",");
    	var lat = responseText.substring(0, split);
    	var lng = responseText.substring(split + 1);
    	updateMarker(lat, lng, index);
    }

    function httpGetAsync(theUrl, callback, index) {
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.onreadystatechange = function() {
            if (xmlHttp.readyState == 4 && xmlHttp.status == 200)
                callback(xmlHttp.responseText, index);
        }
        xmlHttp.open("GET", theUrl, true); // true for asynchronous
        xmlHttp.send(null);
    }

    var counter = 500;
    var myFunction = function(){
        clearInterval(interval);
        interval = setInterval(myFunction, counter);

        for (var i = 0; i < ids.length; i++) {
          httpGetAsync("gps.php?id=" + ids[i], getHandler, i);
        }
    }
    var interval = setInterval(myFunction, counter);
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD9Vru-kzSNMcJiIFcexRrbOg5cgg5GTM8&callback=initMap">
    </script>
    <div id="icon_description"><img src="icon_description2.png"/></div>
  </body>
</html>
