<?php 

require_once 'Ip.php';

$Ip = getIp();
$lat = $Ip['lat'];
$lon = $Ip['lon'];

function xmlFile() {
    global $lat, $lon;
    $url = "https://www.infoclimat.fr/public-api/gfs/xml?_ll={$lat},{$lon}&_auth=ARsDFFIsBCZRfFtsD3lSe1Q8ADUPeVRzBHgFZgtuAH1UMQNgUTNcPlU5VClSfVZkUn8AYVxmVW0Eb1I2WylSLgFgA25SNwRuUT1bPw83UnlUeAB9DzFUcwR4BWMLYwBhVCkDb1EzXCBVOFQoUmNWZlJnAH9cfFVsBGRSPVs1UjEBZwNkUjIEYVE6WyYPIFJjVGUAZg9mVD4EbwVhCzMAMFQzA2JRMlw5VThUKFJiVmtSZQBpXGtVbwRlUjVbKVIuARsDFFIsBCZRfFtsD3lSe1QyAD4PZA%3D%3D&_c=19f3aa7d766b6ba91191c8be71dd1ab2";

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
    curl_setopt($ch, CURLOPT_PROXY, 'www-cache:3128');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $file = curl_exec($ch);
    curl_close($ch);

    $test = simplexml_load_string($file);

    $xml = new DOMDocument;
    $xml->loadXML($test->asXML());

    $xsl = new DOMDocument;
    $xsl ->load('./src/meteo.xsl');

    $proc = new XSLTProcessor();
    $proc->importStyleSheet($xsl);

    $xmlClean  = $proc->transformToXML($xml);

    return $xmlClean;
}



