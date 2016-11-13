<?php
header("Content-type: text/xml");
require("phpsqlsearch_dbinfo.php");
function parseToXML($htmlStr) 
{ 
$xmlStr=str_replace('<','&lt;',$htmlStr); 
$xmlStr=str_replace('>','&gt;',$htmlStr); 
$xmlStr=str_replace('"','&quot;',$htmlStr); 
$xmlStr=str_replace("'",'&#39;',$htmlStr); 
$xmlStr=str_replace("&",'&amp;',$htmlStr); 
return $xmlStr; 
} 
// Get parameters from URL
$center_lat = $_GET["lat"];
$center_lng = $_GET["lng"];
$radius = $_GET["radius"];
// Opens a connection to a MySQL server
$connection=mysql_connect ($db_host, $db_username, $db_pass);
if (!$connection) {
  die('Not connected : ' . mysql_error());
}
// Set the active MySQL database
$db_selected = mysql_select_db($db_name, $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}
// Select all the rows in the markers table
$query = sprintf("SELECT address, name, lat, lng, ( 3959 * acos( cos( radians('%s') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance FROM map_info HAVING distance < '%s' ORDER BY distance LIMIT 0 , 20",
  mysql_real_escape_string($center_lat),
  mysql_real_escape_string($center_lng),
  mysql_real_escape_string($center_lat),
  mysql_real_escape_string($radius));
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}
// Start XML file, echo parent node
echo "<map_info>\n";
// Iterate through the rows, printing XML nodes for each
while ($row = @mysql_fetch_assoc($result)){
  // ADD TO XML DOCUMENT NODE
  echo '<map_info';
  echo 'name="' . parseToXML($row['name']) . '" ';
  echo 'address="' . parseToXML($row['address']) . '" ';
  echo 'lat="' . $row['lat'] . '" ';
  echo 'lng="' . $row['lng'] . '" ';
  echo 'distance="' . $row['distance'] . '" ';
  echo "/>\n";
}

// End XML file
$xml = file_get_contents("/some/xml/file.xml");
if (trim($xml) == '') {
    echo 'Empty XML file!';
}

$xml = simplexml_load_string($xml);


 echo "</map_info>\n";
?>