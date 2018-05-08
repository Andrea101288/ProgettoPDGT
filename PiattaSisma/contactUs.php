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
          <div class="btn-group-vertical p-1">
            <h2><a href="homePage.php"><i>PiattaSisma</i></a></h2>
            <button type="button" class="btn btn-info" onclick="location.href='damages.php'">🌋 Damages</button>
            <button type="button" class="btn btn-success" onclick="location.href='aboutUs.php'">😎 About us</button>
            <button type="button" class="btn btn-warning" onclick="location.href='contactUs.php'">📬 Contact us</button>
            <button type="button" class="btn btn-danger" onclick="location.href='logout.php'">😱 Logout</button>
          </div>
        </nav>
        <main role="main" class="inner cover col-md-9 col-lg-10">
          <div class="our_textbox p-5">
            <p>Per qualsiasi problema con il sito o per qualsiasi informazione o suggerimento contattateci:</p>
            <ul>
            <li>Andrea Mancini</li>
            <ul>
              <li><a href="mailto:andrea101288@hotmail.it">Email</a></li>
              <li><a href="https://github.com/Andrea101288">Github</a></li>
              <li><a href="https://www.facebook.com/mancio88ps/">Facebook</a></li>
            </ul>
            <li>Dawid Weglarz</li>
            <ul>
              <li><a href="mailto:d.weglarz@campus.uniurb.it">Email</a></li>
              <li><a href="https://github.com/Radeox">Github</a></li>
            </ul>
            </ul>
          </div>
        </main>
      </div>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  </body>
</html>
