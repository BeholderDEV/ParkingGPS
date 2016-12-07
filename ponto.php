<?php
// Connecting, selecting database
$dbconn = pg_connect("host=localhost port=5432 dbname=parking user=postgres password=123456")
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
