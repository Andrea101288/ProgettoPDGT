<?php
  include 'settings.php';

  // Get username and password of the user which want to register
  $user_username = $_REQUEST["username"];
  $user_password = $_REQUEST["password"];
  $user_email = $_REQUEST["email"];

  // Connect to database
  $conn = mysqli_connect($server, $user, $password) or die("Error in connection to database");
  mysqli_select_db($conn, $database) or die("Error accessing user table");

  // Check if user already exist in database
  $sql = "SELECT * FROM api_user WHERE username = '".$user_username."'";
  $result = mysqli_query($conn, $sql);

  // Start session to save logged user
  session_start();

  if (mysqli_num_rows($result) > 0) {
    // User found: can't register 
    $_SESSION['wrong_login'] = 1;
    mysqli_close($conn);

    // Redirect user to register page
    header("Location: register.php");
    die();
  }
  else {
    // Insert user in database
    $sql = "INSERT INTO api_user VALUES('".$user_username."', '".$user_password."', '".$user_email."', 1 );";

    // Check if user was correctly registred
    if (!mysqli_query($conn, $sql)) {
      $_SESSION['wrong_login'] = 1;

      // Redirect user to register page
      header("Location: register.php");
      die();
    }
    else {
      // Save mail for next checks
      $_SESSION['username'] = $user_username;
      mysqli_close($conn);

      // Redirect to login page
      header("Location: homePage.php");
      die();
    }
  }
?>
