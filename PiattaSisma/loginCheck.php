<?php
  include 'settings.php';

  // Get username and password of the user which want to login
  $user_username = $_REQUEST["username"];
  $user_password = $_REQUEST["password"];

  // Connect to database
  $conn = mysqli_connect($server, $user, $password) or die("Error in connection to database");
  mysqli_select_db($conn, $database) or die("Error accessing user table");

  // Check if user exist in database
  $sql = "SELECT * FROM api_user WHERE '".$user_username."' = username AND '".$user_password."' = password;";
  $result = mysqli_query($conn, $sql);

  // Start session to save logged user
  session_start();

  if(mysqli_num_rows($result) > 0) {
    // User found: save username for next checks
    $_SESSION['username'] = $user_username;
    mysqli_close($conn);

    // Redirect user to home page
    header("Location: homePage.php");
    die();
  }
  else {
    $_SESSION['wrong_login'] = 1;
    mysqli_close($conn);

    // Redirect to login page
    header("Location: login.php");
    die();
  }
?>
