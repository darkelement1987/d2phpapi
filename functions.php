<?php

function apiRequest($args){
require("config.php");

$url = 'https://www.bungie.net/Platform' . $args;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-API-Key: ' . $apiKey));

return json_decode(curl_exec($ch),true);
curl_close;
}

?>