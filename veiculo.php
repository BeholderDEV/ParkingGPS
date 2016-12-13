<?php
// Connecting, selecting database
$dbconn = pg_connect("host=ec2-54-235-123-159.compute-1.amazonaws.com port=5432 dbname=d28gt5qo4kjh76 user=yidwvplyhjyvjz password=fb6dfdd2ec9ecc899b9e459643236be4e3ab165e2adaadcd6ebfc0c7c81cfd97 sslmode=require")
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
