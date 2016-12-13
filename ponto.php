<?php
// Connecting, selecting database
$dbconn = pg_connect("host=ec2-54-235-123-159.compute-1.amazonaws.com port=5432 dbname=d28gt5qo4kjh76 user=yidwvplyhjyvjz password=fb6dfdd2ec9ecc899b9e459643236be4e3ab165e2adaadcd6ebfc0c7c81cfd97 sslmode=require")
              or die('Could not connect: ' . pg_last_error());

// Performing SQL query
$data =addslashes( $_POST["data"]);
$hora = addslashes($_POST["hora"]);
$longitude = addslashes($_POST["longitude"]);
$latitude = addslashes($_POST["latitude"]);
$carro = strtoupper($_POST["carro"]);

$stamp = $data." ".$hora;
$point = $longitude." ".$latitude;

$query = "Select id from carro where placa='".$carro."'";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());

$row = pg_fetch_row($result);

$query = "INSERT INTO ponto (data_ponto, local_ponto, id_carro) values ('".$stamp."',st_geomfromtext('POINT(".$point.")',4326), '".$row[0]."')";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());

// Closing connection
pg_close($dbconn);
header("location:index.php");
?>
