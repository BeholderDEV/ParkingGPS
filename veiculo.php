<?php
// Connecting, selecting database
$dbconn = pg_connect("host=localhost port=5432 dbname=parking user=postgres password=123456")
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
