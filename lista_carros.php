<?php
// Connecting, selecting database
$dbconn = pg_connect("host=ec2-107-21-212-175.compute-1.amazonaws.com port=5432 dbname=d720m6nvm27rpq user=axiwhaycappayo password=ed2fd1c749c7bdd7ffc48a7338eb48add4948a3dc6f284b682d28b82fe381262 sslmode=require")
    or die('Could not connect: ' . pg_last_error());

// Performing SQL query
$query = "Select * from carro";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());

while ($row = pg_fetch_row($result)) {
    echo "\n <option class='flat' id='".$row[0]."'>".$row[1]."</option> ";
}

pg_close($dbconn);
?>
