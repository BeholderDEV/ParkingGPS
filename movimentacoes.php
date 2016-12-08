<?php
// Connecting, selecting database
$dbconn = pg_connect("host=ec2-79-125-24-188.eu-west-1.compute.amazonaws.com port=5432 dbname=d5pp475o12d3qq user=bsuvisntqclmxj password=CFsGksfLw9_3Gcdmx8EE77d1D8 sslmode=require")
    or die('Could not connect: ' . pg_last_error());

// Performing SQL query
$carro = strtoupper($_POST["carro"]);

$query = "Select id from carro where placa='".$carro."'";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());

$row = pg_fetch_row($result);

$query = "select * from get_movimentacao(".$row[0].");";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());

while ($row = pg_fetch_row($result)) {
    echo "\n ".$row[0]."\t".$row[1]."\t".$row[2]."\t".$row[3]."\t".$row[4];
}

// Closing connection
pg_close($dbconn);
?>