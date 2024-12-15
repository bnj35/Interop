<?php 

require_once'./src/xml.php';
require_once'./src/Air.php';
require_once './src/traffic.php';


$trafficInfo = getTraffic();
$xmlMeteo = xmlFile();
$AirQuality = getAirQuality();


$opts = array('http' => array('proxy'=> 'tcp://127.0.0.1:8080', 'request_fulluri'=> true), 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false));
$context = stream_context_create($opts);

$IP = $_SERVER['REMOTE_ADDR'];
$details = json_decode(file_get_contents("http://ip-api.com/json/{$IP}"));
print_r($details->message);

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
    
    <?php echo $AirQuality; ?>

    <h1>Info Trafic :</h1>
    <section id="traffic_section">
    <?php echo $trafficInfo; ?>
    </section>

    <div id="map"></div>

    </body>

    <script>
        var map = L.map('map').setView([51.505, -0.09], 13);
    </script>
</html>