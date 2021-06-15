<html>
<head>
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
</head>
<body>
<?php

require_once("functions.php");
require("config.php");

if($apiKey == ''){echo "No Api key in config.php";} else {
?>

<b>Find player equipment:</b>
<form action="" method="post">
<p>
<input type="text" name="player" placeholder="Enter player name"></input>
</p>
<input type="submit" value="Find info">
</form>

<?php
if(isset($_POST['player'])){
$name = $_POST['player'];

if(empty($name)){echo "Please enter a name, input cannot be empty";} else {

// Name to memid
$json =& apiRequest('/Destiny2/SearchDestinyPlayer/-1/' . $name . '/');

// Check if name exists
if(!empty($json["Response"])){

$memid = $json["Response"][0]["membershipId"];
$memtype = $json["Response"][0]["membershipType"];

// Get profile info by memid
$json =& apiRequest('/Destiny2/2/Profile/' . $memid . '/?components=100');

// Memid -> count characters
$count = count($json['Response']['profile']['data']['characterIds']);
if($count < 2){
	$charnum = 'character';
	} else {
		$charnum = 'characters';
	}
echo "<h1>$name has $count $charnum</h1>";

// Get Character info
$chars = $json['Response']['profile']['data']['characterIds'];

// Show Character info
echo "<h2><u>Character info:</u></h2>";
$i = 0;
foreach($chars as $value){
	$i++;
	
	echo '<h2>Character ' . $i . '</h2>';
	$charinfo =& apiRequest('/Destiny2/' . $memtype . '/Profile/' . $memid . '/Character/' . $value . '/?components=200');
	$charitems =& apiRequest('/Destiny2/' . $memtype . '/Profile/' . $memid . '/Character/' . $value . '/?components=205');
	
	echo "<h3>Weapons on character:</h3>";
	
	// Lookup items
	$items = $charitems["Response"]["equipment"]["data"]["items"];
	foreach($items as $itemkey => $itemvalue){
	
	// Lookup item hashes
	$itemhash = $itemvalue["itemHash"];
	$buckethash = $itemvalue["bucketHash"];
	
	// Item hash to names
	$weaponname =& apiRequest('/Destiny2/Manifest/DestinyInventoryItemDefinition/' . $itemhash . '/');
	
	//Check if weapon
	if($weaponname["Response"]["itemType"] == "3"){
	echo $weaponname["Response"]["displayProperties"]["name"] . "<br>";
	}
	
	}
}

// Return error if player doesn't exist
} else {echo "Invalid Player name given";}
}
}
}
?>
</body>
</html>