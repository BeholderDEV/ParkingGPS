<?php
// Connecting, selecting database
$dbconn = pg_connect("host=ec2-79-125-24-188.eu-west-1.compute.amazonaws.com port=5432 dbname=d5pp475o12d3qq user=bsuvisntqclmxj password=CFsGksfLw9_3Gcdmx8EE77d1D8")
    or die('Could not connect: ' . pg_last_error());

// Performing SQL query
$data =addslashes( $_POST["data"]);
$hora = addslashes($_POST["hora"]);
$longitude = addslashes($_POST["longitude"]);
$latitude = addslashes($_POST["latitude"]);

$stamp = $data." ".$hora;
$point = $longitude." ".$latitude;

$query = "INSERT INTO ponto (data_ponto, local_ponto) values ('".$stamp."',st_geomfromtext('POINT(".$point.")',4326))";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());

// Closing connection
pg_close($dbconn);
header("location:http://localhost/Parking/index.php");
?>
