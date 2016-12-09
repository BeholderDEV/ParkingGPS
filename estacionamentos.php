<?php
// Connecting, selecting database
$dbconn = pg_connect("host=ec2-79-125-24-188.eu-west-1.compute.amazonaws.com port=5432 dbname=d5pp475o12d3qq user=bsuvisntqclmxj password=CFsGksfLw9_3Gcdmx8EE77d1D8 sslmode=require")
    or die('Could not connect: ' . pg_last_error());

// Performing SQL query
$longitude = addslashes($_POST["longitude"]);
$latitude = addslashes($_POST["latitude"]);

$query = "select * from get_conveniados_sorted(".$longitude.", ".$latitude.");";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());

$out = "";
$tabela = "<table class='table table-hover'><thead><tr><th>Estacionamento</th><th>Valor</th><th>Distância</th></tr></thead>";
while ($row = pg_fetch_row($result)) {
    $dist = round($row[2]);
    $kind = " m";
    if($dist>1000){
        $dist = round($dist/1000,2);
        $kind = " Km";
    }
    $out = $out."<tr><td>".$row[0]."</td><td>R$ ".round($row[1],2)."</td><td>".$dist.$kind."</td><tr>";
}
$tabela = $tabela.$out."</tabela>";
// Closing connection
pg_close($dbconn);

echo '<form id="myForm" action="estacionamentos_proximos.php" method="post">';
echo '<input type="hidden" name="tabela" value="'.$tabela.'">';
echo '</form><script type="text/javascript">document.getElementById("myForm").submit();</script>';
?>
