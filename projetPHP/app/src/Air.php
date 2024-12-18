<?php

function getAirQuality () {

$urlAir = "https://services3.arcgis.com/Is0UwT37raQYl9Jj/arcgis/rest/services/ind_grandest/FeatureServer/0/query?where=lib_zone%3D%27Nancy%27&objectIds=&time=&geometry=&geometryType=esriGeometryEnvelope&inSR=&spatialRel=esriSpatialRelIntersects&resultType=none&distance=0.0&units=esriSRUnit_Meter&returnGeodetic=false&outFields=*&returnGeometry=true&featureEncoding=esriDefault&multipatchOption=xyFootprint&maxAllowableOffset=&geometryPrecision=&outSR=&datumTransformation=&applyVCSProjection=false&returnIdsOnly=false&returnUniqueIdsOnly=false&returnCountOnly=false&returnExtentOnly=false&returnQueryGeometry=false&returnDistinctValues=false&cacheHint=false&orderByFields=&groupByFieldsForStatistics=&outStatistics=&having=&resultOffset=&resultRecordCount=&returnZ=false&returnM=false&returnExceededLimitFeatures=true&quantizationParameters=&sqlFormat=none&f=pjson&token=";

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $urlAir);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
    curl_setopt($ch, CURLOPT_PROXY, 'www-cache:3128');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $fileAir = curl_exec($ch);
    curl_close($ch);

$CleanAir = json_decode($fileAir, false);

$AirQuality = $CleanAir->features[0]->attributes->lib_qual;
$AirColor = $CleanAir->features[0]->attributes->coul_qual;


return ['airQuality'=>$AirQuality, 'airColor'=>$AirColor];

}
