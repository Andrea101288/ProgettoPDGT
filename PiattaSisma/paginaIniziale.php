<html>
  <?php
    session_start();

    if(!isset($_SESSION['username'])) {
      header("Location: login.php");
    }
  ?>
  <head>
    <title>PiattaSisma</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css">
  </head>
  <body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <a class="navbar-brand" href="/PiattaSisma/">PiattaSisma</a>
    </nav>
    <div class="container-fluid">
      <div class="row">
        <nav style="padding-top:80px" class="col-md-2 d-none d-md-block navbar-dark bg-dark sidebar">
          <a href="logout.php">😱 Logout</a>
        </nav>
        <main id="map" role="main" class="col-md-9 col-lg-10">
          <!-- Map goes here -->
        </main>
      </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/map_manager.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJfFfAiXYVz5GJyuiSU0ybWeq8bQuzvVE&callback=myMap"></script>
  </body>
</html>
