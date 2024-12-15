<?php 

require_once'./src/xml.php';
require_once'./src/Air.php';

$xmlMeteo = xmlFile();
$AirQuality = getAirQuality();


$opts = array('http' => array('proxy'=> 'tcp://127.0.0.1:8080', 'request_fulluri'=> true), 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false));
$context = stream_context_create($opts);
// stream_context_set_default($opts);

$IP = $_SERVER['REMOTE_ADDR'];
$details = json_decode(file_get_contents("http://ip-api.com/json/{$IP}"));
print_r($details->message);


////////////////////////////////////////////////////////////////

$urlTraffic = "https://carto.g-ny.org/data/cifs/cifs_waze_v2.json";

$fileTraffic = file_get_contents($urlTraffic, false);
$decodeTraffic = json_decode($fileTraffic, false);

for ($i = 0; $i < count($decodeTraffic->incidents); $i++) {
    echo "Type: " . $decodeTraffic->incidents[$i]->type . "<br>";
    echo "Description: " . $decodeTraffic->incidents[$i]->description . "<br>";
    echo "Short Description: " . $decodeTraffic->incidents[$i]->short_description . "<br>";
    echo "Start Time: " . $decodeTraffic->incidents[$i]->starttime . "<br>";
    echo "End Time: " . $decodeTraffic->incidents[$i]->endtime . "<br>";
    echo "Street: " . $decodeTraffic->incidents[$i]->location->street . "<br>";
    echo "Location Description: " . $decodeTraffic->incidents[$i]->location->location_description . "<br>";
    echo "Source Name: " . $decodeTraffic->incidents[$i]->source->name . "<br>";
    echo "Update Time: " . $decodeTraffic->incidents[$i]->updatetime . "<br>";
    echo "Creation Time: " . $decodeTraffic->incidents[$i]->creationtime . "<br>";
    echo "ID: " . $decodeTraffic->incidents[$i]->id . "<br><br>";
}
?>

<html>
    <body>

    <?php echo $xmlMeteo; ?>
    <?php echo $AirQuality; ?>


    </body>
    <script>
        
    </script>
</html>