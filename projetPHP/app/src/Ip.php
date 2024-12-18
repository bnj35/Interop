<?php 

function getIp() {
    $IP = $_SERVER['REMOTE_ADDR'];

    $url ="http://ip-api.com/json/{$IP}";
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
    curl_setopt($ch, CURLOPT_PROXY, 'www-cache:3128');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $lat = json_decode($response, true)['lat'];
    $lon = json_decode($response, true)['lon'];

    return ['lat' => $lat, 'lon' => $lon];
}