<?php

require_once './src/xml.php';
require_once './src/Air.php';
require_once './src/traffic.php';
require_once './src/Ip.php';



$trafficInfo = getTraffic();
$xmlMeteo = xmlFile();
$AirInfo = getAirQuality();
$airQuality = $AirInfo['airQuality'];
$airColor = $AirInfo['airColor'];
$Ip = getIp();
$lat = $Ip['lat'];
$lon = $Ip['lon'];





?>

<html>

<head>
    <title>Projet PHP</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin="" />
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
        <?php echo $airQuality; ?>
        <div id="air_color" style="background-color: <?php echo $airColor; ?>"></div>
    </section>

    <h2>Info Trafic :</h2>
    <section id="traffic_section">
        <div id="map"></div>
    </section>
    <footer>
        <h4>API utilisées :</h4> <a href="https://services3.arcgis.com/Is0UwT37raQYl9Jj/arcgis/rest/services/ind_grandest/FeatureServer/0/query?where=lib_zone%3D%27Nancy%27&objectIds=&time=&geometry=&geometryType=esriGeometryEnvelope&inSR=&spatialRel=esriSpatialRelIntersects&resultType=none&distance=0.0&units=esriSRUnit_Meter&returnGeodetic=false&outFields=*&returnGeometry=true&featureEncoding=esriDefault&multipatchOption=xyFootprint&maxAllowableOffset=&geometryPrecision=&outSR=&datumTransformation=&applyVCSProjection=false&returnIdsOnly=false&returnUniqueIdsOnly=false&returnCountOnly=false&returnExtentOnly=false&returnQueryGeometry=false&returnDistinctValues=false&cacheHint=false&orderByFields=&groupByFieldsForStatistics=&outStatistics=&having=&resultOffset=&resultRecordCount=&returnZ=false&returnM=false&returnExceededLimitFeatures=true&quantizationParameters=&sqlFormat=none&f=pjson&token=">Air</a>,
        <a href="https://www.infoclimat.fr/public-api/gfs/xml?_ll=48,6&_auth=ARsDFFIsBCZRfFtsD3lSe1Q8ADUPeVRzBHgFZgtuAH1UMQNgUTNcPlU5VClSfVZkUn8AYVxmVW0Eb1I2WylSLgFgA25SNwRuUT1bPw83UnlUeAB9DzFUcwR4BWMLYwBhVCkDb1EzXCBVOFQoUmNWZlJnAH9cfFVsBGRSPVs1UjEBZwNkUjIEYVE6WyYPIFJjVGUAZg9mVD4EbwVhCzMAMFQzA2JRMlw5VThUKFJiVmtSZQBpXGtVbwRlUjVbKVIuARsDFFIsBCZRfFtsD3lSe1QyAD4PZA%3D%3D&_c=19f3aa7d766b6ba91191c8be71dd1ab2">Meteo</a>,<a href="https://carto.g-ny.org/data/cifs/cifs_waze_v2.json">Traffic</a>
        <h4>GitHub :</h4><a href="https://github.com/bnj35/Interop">GitHub</a>
    </footer>
</body>

<script>
    var map = L.map('map').setView([<?php echo $lat; ?>, <?php echo $lon; ?>], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    <?php foreach ($trafficInfo['incidents'] as $incident):
        list($lat, $lon) = explode(' ', $incident['location']['polyline']);
        $starttime = date('d/m/Y H:i', strtotime($incident['starttime']));
        $endtime = date('d/m/Y H:i', strtotime($incident['endtime']));
    ?>
        L.marker([<?php echo $lat; ?>, <?php echo $lon; ?>]).addTo(map)
            .bindPopup(`<?php echo $incident['description'] . '</br>';
                        echo ' début le ' . $starttime;
                        echo ' fin le ' . $endtime ?>`)
    <?php endforeach; ?>
</script>

</html>