<?php
// Connecting, selecting database
$dbconn = pg_connect("host=ec2-79-125-24-188.eu-west-1.compute.amazonaws.com port=5432 dbname=d5pp475o12d3qq user=bsuvisntqclmxj password=CFsGksfLw9_3Gcdmx8EE77d1D8 sslmode=require")
    or die('Could not connect: ' . pg_last_error());

// Performing SQL query
$query = "Select * from carro";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());

while ($row = pg_fetch_row($result)) {
    echo "\n <option class='flat' id='".$row[0]."'>".$row[1]."</option> ";
}

pg_close($dbconn);
?>
