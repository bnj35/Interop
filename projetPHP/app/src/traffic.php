<?php

function getTraffic() {
$urlTraffic = "https://carto.g-ny.org/data/cifs/cifs_waze_v2.json";

$fileTraffic = file_get_contents($urlTraffic, false);
$decodeTraffic = json_decode($fileTraffic, true);

return $decodeTraffic;


}