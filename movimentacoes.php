<?php
// Connecting, selecting database
$dbconn = pg_connect("host=ec2-54-235-123-159.compute-1.amazonaws.com port=5432 dbname=d28gt5qo4kjh76 user=yidwvplyhjyvjz password=fb6dfdd2ec9ecc899b9e459643236be4e3ab165e2adaadcd6ebfc0c7c81cfd97 sslmode=require")
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
