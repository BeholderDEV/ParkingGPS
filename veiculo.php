<?php
// Connecting, selecting database
$dbconn = pg_connect("host=ec2-79-125-24-188.eu-west-1.compute.amazonaws.com port=5432 dbname=d5pp475o12d3qq user=bsuvisntqclmxj password=CFsGksfLw9_3Gcdmx8EE77d1D8 sslmode=require")
    or die('Could not connect: ' . pg_last_error());

require 'validador_placa.php';

// Performing SQL query
$placa = strtoupper (str_replace ( '-' , '' , $_POST["placa"]));
$entrada = addslashes($placa);
if(carReg($entrada))
{
    $query = "INSERT INTO carro (placa) values ('".$entrada."')";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
    echo "placa certa";
}
else
{
 echo "placa errada";
}
// Closing connection
pg_close($dbconn);
header("location:index.php");
?>
