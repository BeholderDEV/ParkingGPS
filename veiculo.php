<?php
// Connecting, selecting database
$dbconn = pg_connect("host=ec2-107-21-212-175.compute-1.amazonaws.com port=5432 dbname=d720m6nvm27rpq user=axiwhaycappayo password=ed2fd1c749c7bdd7ffc48a7338eb48add4948a3dc6f284b682d28b82fe381262 sslmode=require")
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
