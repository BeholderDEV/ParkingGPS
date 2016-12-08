<?php
// Connecting, selecting database
$dbconn = pg_connect("host=ec2-79-125-24-188.eu-west-1.compute.amazonaws.com port=5432 dbname=d5pp475o12d3qq user=bsuvisntqclmxj password=CFsGksfLw9_3Gcdmx8EE77d1D8")
    or die('Could not connect: ' . pg_last_error());

// Performing SQL query
$placa = strtoupper (str_replace ( '-' , '' , $_POST["placa"]));
$entrada = addslashes($placa);
$query = "INSERT INTO carro (placa) values ('".$entrada."')";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());

// Closing connection
pg_close($dbconn);
header("location:http://localhost/Parking/index.php");
?>
