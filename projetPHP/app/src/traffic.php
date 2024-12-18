<?php

function getTraffic() {
$urlTraffic = "https://carto.g-ny.org/data/cifs/cifs_waze_v2.json";

// $fileTraffic = file_get_contents($urlTraffic, false);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $urlTraffic);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
curl_setopt($ch, CURLOPT_PROXY, 'www-cache:3128');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$fileTraffic = curl_exec($ch);
curl_close($ch);

$decodeTraffic = json_decode($fileTraffic, true);

return $decodeTraffic;


}