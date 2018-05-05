<html>
  <head>
    <title>PiattaSisma</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css">
  </head>
  <body class="text-center">
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
      <header class="masthead mb-auto">
        <div class="inner">
        </div>
      </header>
      <main role="main" class="inner cover">
        <h1>🌎 PiattaSisma 🌍</h1><br>
        <h2>La piattaforma di raccolta danni e dati sismici</h2>
        <h3>Accedi al tuo account e inizia la ricerca!</h3><br>
        <?php
          session_start();

          if(isset($_SESSION['username'])) {
            echo '<button type="button" class="btn btn-primary btn-lg" onclick="location.href=\'homePage.php\'">Entra</a></button>';
          }
          else {
            echo '<button type="button" class="btn btn-primary btn-lg m-1" onclick="location.href=\'login.php\'">Login</a></button>';
            echo '<button type="button" class="btn btn-primary btn-lg m-1" onclick="location.href=\'register.php\'">Sign Up</a></button>';
          }
        ?>
      </main>
      <footer class="mastfoot mt-auto">
        <div class="inner">
          <p>PDGT Project made with ❤️ by <a href="https://github.com/Andrea101288">Andrea101288</a> and <a href="https://github.com/Radeox">Radeox</a></p>
        </div>
      </footer>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  </body>
</html>
