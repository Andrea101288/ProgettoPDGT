<html>
  <?php
    session_start();
    if(!isset($_SESSION['username'])) {
      header("Location: login.php");
    }
  ?>
  <head>
    <title>PiattaSisma </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css">
  </head>
  <body>
    <div class="container-fluid">
       <div class="row">
        <nav class="col-md-3 col-lg-2 flex-column">
          <div class="btn-group-vertical p-3">
            <h2><i>PiattaSisma</i></h2>
            <button type="button" class="btn btn-info" onclick="location.href='aboutUs.php'">😎 About us</button>
            <button type="button" class="btn btn-warning" onclick="location.href='#'">👽 Website guide</button>
            <button type="button" class="btn btn-success" onclick="location.href='#'">🌎 Earthquakes list</button>
            <button type="button" class="btn btn-info" onclick="location.href='damages.php'">🌋 Damages</button>
            <button type="button" class="btn btn-warning" onclick="location.href='contactUs.php'">📬 Contact us</button>
            <button type="button" class="btn btn-danger" onclick="location.href='logout.php'">😱 Logout</button><br>
            <form>
              <b>Regione</b><br>
              <input type="radio" name="region" value="italy" checked> Italia<br>
              <input type="radio" name="region" value="usa"> USA<br>
              <input type="radio" name="region" value="latest_world"> Mondo (oggi)<br>
              <b>Data inizio</b>
              <input type="date" id="from_day">
              <b>Data fine</b>
              <input type="date" id="to_day"><br><br>
              <button type="button" class="btn btn-danger" onclick="getMarkers()">Invia</button>
            </form>
          </div>
        </nav>
        <main id="map" role="main" class="col-md-9 col-lg-10 d-flex w-100 h-100 flex-column">
          <!-- Map goes here -->
        </main>
      </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/map_manager.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJfFfAiXYVz5GJyuiSU0ybWeq8bQuzvVE&callback=initMap"></script>
  </body>
</html>
