
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
      <div class="jumbotron"><h1>Enviar Pontos</h1></div>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Enviar Pontos</li>
      </ol>
        <form class="form-inline" action="ponto.php" method="post">
          <div class="form-group">
            <label for="data">Data</label>
            <input type="date" class="form-control" id="data" name="data" placeholder="2016-06-12">
          </div>
          <div class="form-group">
            <label for="hora">Hora</label>
            <input type="time" class="form-control" id="hora" name="hora" placeholder="2016-06-12">
          </div>
          <div class="form-group">
            <label for="longitude">Longitude</label>
            <input type="number" step="0.0000000001" class="form-control" id="longitude" name="longitude" placeholder="-48">
          </div>
          <div class="form-group">
            <label for="latitude">Latitude</label>
            <input type="number" step="0.0000000001" class="form-control" id="latitude" name="latitude" placeholder="-26">
          </div>
            <div class="form-group">
            <label for="carro">Lista dos carros</label>
              <select class="form-control" name="carro" id="carro">
                <?php include 'lista_carros.php'; ?>
              </select>
            </div>

          <button type="submit" class="btn btn-default">Send</button>
        </form>


    </div> <!-- /container -->
  </body>
</html>
