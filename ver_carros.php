<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Parking GPS</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/estilo.css"></link>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="container">
      <div class="jumbotron"><h1><img class="car" src="img/parking.png">Lista dos carros</h1></div>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Lista dos carros</li>
      </ol>
        <ul class="list-group">
          <?php
          // Connecting, selecting database
          $dbconn = pg_connect("host=ec2-79-125-24-188.eu-west-1.compute.amazonaws.com port=5432 dbname=d5pp475o12d3qq user=bsuvisntqclmxj password=CFsGksfLw9_3Gcdmx8EE77d1D8 sslmode=require")
              or die('Could not connect: ' . pg_last_error());

          // Performing SQL query
          $query = "select c.placa as carro, count(p.local_ponto) from carro c full join ponto p on (p.id_carro=c.id) group by c.placa;";
          $result = pg_query($query) or die('Query failed: ' . pg_last_error());

          $out = "";
        $tabela = "<table class='table table-hover'><thead><tr><th>Carro</th><th>Pontos</th></tr></thead>";
        while ($row = pg_fetch_row($result)) {
            $out = $out."<tr><td>".$row[0]."</td><td>".$row[1]."</td><tr>";
        }
        $tabela = $tabela.$out."</tabela>";
        // Closing connection
        pg_close($dbconn);

        echo '<form id="myForm" action="ver_movimentacoes.php" method="post">';
        echo '<input type="hidden" name="tabela" value="'.$tabela.'">';
        echo '</form><script type="text/javascript">document.getElementById("myForm").submit();</script>';
          ?>
        </ul>

    </div> <!-- /container -->
  </body>
</html>
