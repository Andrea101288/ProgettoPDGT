<html>
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
        <a class="navbar-brand" href="paginaIniziale.php">PiattaSisma</a>
      </nav>
      <form class="form-signin" method="POST" action="damageControl.php">
        <h2 class="h3 mb-3 font-weight-normal">Add your photo and a description</h2>
        <label for="inputPhoto" class="sr-only">Photo</label>
        <input type="file" id="inputPhoto" name="photo" class="form-control m-2" placeholder="Photo" required autofocus>
        <label for="inputAddress" class="sr-only">Address and civic number</label>
        <input type="text" id="inputAddress" name="address" class="form-control m-2" placeholder="Address" required>
        <label for="inputCity" class="sr-only">City</label>
        <input type="text" id="inputCity" name="city" class="form-control m-2" placeholder="City" required>
        <label for="inputDescription" class="sr-only">Description</label>
        <textarea type="text" id="inputDescription" name="description" class="form-control m-2" placeholder="Description"></textarea>
        <button class="btn btn-lg btn-primary btn-block m-2" type="submit">Submit</button>
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
