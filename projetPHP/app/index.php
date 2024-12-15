<?php 

require_once'./src/xml.php';
require_once'./src/Air.php';
require_once './src/traffic.php';
require_once './src/Ip.php';


$trafficInfo = getTraffic();
$xmlMeteo = xmlFile();
$AirInfo = getAirQuality();
$ipAddress = getIp();

///////passage de proxy///////////
$opts = array('http' => array('proxy'=> 'tcp://127.0.0.1:8080', 'request_fulluri'=> true), 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false));
$context = stream_context_create($opts);



?>

<html>

<head>
    <title>Projet PHP</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
     <link rel="stylesheet" href="style.css">
</head>
               
    <body>

    <h1>Prévisions Météo :</h1>
    <section id="meteo_section">
    <?php echo $xmlMeteo; ?>
    </section>
    
    <h2>Qualité de l'air :</h2>
    <section id="air_section">
    <?php echo $AirInfo; ?>
    </section>

    <h2>Info Trafic :</h2>
    <section id="traffic_section">
        <div id="map"></div>
    </section>
    </body>

    <script>
        var map = L.map('map').setView([48.69, 6.18], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        <?php foreach ($trafficInfo['incidents'] as $incident): 
            list($lat, $lon) = explode(' ', $incident['location']['polyline']);
        ?>
            L.marker([<?php echo $lat; ?>, <?php echo $lon; ?>]).addTo(map)
            .bindPopup(`<?php echo $incident['description']; ?>`)
        <?php endforeach; ?>
    </script>
</html>