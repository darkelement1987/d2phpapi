<?php

function apiRequest($args){
require("config.php");

// Name to memid
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.bungie.net/Platform' . $args);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-API-Key: ' . $apiKey));

return json_decode(curl_exec($ch),true);
curl_close;
}

?>