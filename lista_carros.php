<?php
// Connecting, selecting database
$dbconn = pg_connect("host=ec2-54-235-123-159.compute-1.amazonaws.com port=5432 dbname=d28gt5qo4kjh76 user=yidwvplyhjyvjz password=fb6dfdd2ec9ecc899b9e459643236be4e3ab165e2adaadcd6ebfc0c7c81cfd97 sslmode=require")
              or die('Could not connect: ' . pg_last_error());

// Performing SQL query
$query = "Select * from carro";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());

while ($row = pg_fetch_row($result)) {
    echo "\n <option class='flat' id='".$row[0]."'>".$row[1]."</option> ";
}

pg_close($dbconn);
?>
