<html>
  <?php
    session_start();

    if(isset($_SESSION['username'])) {
      header("Location: paginaIniziale.php");
    }
  ?>
  <head>
    <title>PiattaSisma</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/signin.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
  </head>
  <body class="text-center">
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
      <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="/PiattaSisma/">PiattaSisma</a>
      </nav>
      <form class="form-signin" method="POST" action="controlloRegistrazione.php">
        <?php
          if(isset$_SESSION['wrong_login']) && ($_SESSION['wrong_login'] == 1) {
            echo '<div class="alert alert-danger" role="alert">';
            echo 'Problema con la registrazione.<br>';
            echo 'Si prega di riprovare.';
            echo '</div>';

            unset($_SESSION['wrong_login']);
          }
        ?>
        <h1 class="h3 mb-3 font-weight-normal">Inserisci le tue credenziali</h1>
        <label for="inputEmail" class="sr-only">Email</label>
        <input type="email" id="inputEmail" name="email" class="form-control m-2" placeholder="Email" required="" autofocus="">
        <label for="inputEmail" class="sr-only">Username</label>
        <input type="username" id="inputUsername" name="username" class="form-control m-2" placeholder="Username" required="" autofocus="">
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="password" class="form-control m-2" placeholder="Password" required="">
        <button class="btn btn-lg btn-primary btn-block m-2" type="submit">Registrarti</button>
      </form>
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
