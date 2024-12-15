<?php

function getTraffic() {
$urlTraffic = "https://carto.g-ny.org/data/cifs/cifs_waze_v2.json";

$fileTraffic = file_get_contents($urlTraffic, false);
$decodeTraffic = json_decode($fileTraffic, true);


foreach ($decodeTraffic['incidents'] as $incident) {
    $street = $incident['location']['street'];
    $coordonee = $incident['location']['polyline'];
    $type = $incident['type'];
    $description = $incident['description'];
    $TrafficClean = "Street: {$street},Coo : {$coordonee},  Type: {$type}, Description: {$description}<br>"; 
};

return $TrafficClean;


}