<?php 


function getIp() {
      
$IP = $_SERVER['REMOTE_ADDR'];
$details = json_decode(file_get_contents("http://ip-api.com/json/{$IP}"));

    print_r($details);

    return $details;
}