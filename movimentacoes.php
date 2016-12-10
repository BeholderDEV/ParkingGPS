<?php
// Connecting, selecting database
$dbconn = pg_connect("host=ec2-107-21-212-175.compute-1.amazonaws.com port=5432 dbname=d720m6nvm27rpq user=axiwhaycappayo password=ed2fd1c749c7bdd7ffc48a7338eb48add4948a3dc6f284b682d28b82fe381262 sslmode=require")
    or die('Could not connect: ' . pg_last_error());

// Performing SQL query
$carro = strtoupper($_POST["carro"]);

$query = "Select id from carro where placa='".$carro."'";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());

$row = pg_fetch_row($result);

$query = "select * from get_movimentacao(".$row[0].");";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());

$out = "";
$tabela = "<table class='table table-hover'><thead><tr><th>Estacionamento</th><th>Data Entrada</th><th>Data Saida</th><th>Permanencia</th><th>Valor</th></tr></thead>";
while ($row = pg_fetch_row($result)) {
    $out = $out."<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]." min</td><td>R$ ".round($row[4],2)."</td><tr>";
}
$tabela = $tabela.$out."</tabela>";
// Closing connection
pg_close($dbconn);

echo '<form id="myForm" action="ver_movimentacoes.php" method="post">';
echo '<input type="hidden" name="tabela" value="'.$tabela.'">';
echo '</form><script type="text/javascript">document.getElementById("myForm").submit();</script>';
?>
