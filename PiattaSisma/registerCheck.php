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
  $sql = $conn->prepare("SELECT * FROM api_user WHERE username = ?");

  // Bind paramters
  $sql->bind_param('s', $user_username);

  // Execute the query
  $sql->execute();

  // Get results
  $result = $sql->get_result();

  // Start session to save logged user
  session_start();

  if(mysqli_num_rows($result) > 0) {
    // User found: can't register 
    $_SESSION['wrong_login'] = 1;
    mysqli_close($conn);

    // Redirect user to register page
    header("Location: register.php");
    die();
  }
  else {
    // Insert user in database
    $sql = $conn->prepare("INSERT INTO api_user VALUES(?, ?, ?, 1 );");

    // Bind paramters
    $sql->bind_param('sss', $user_username, $user_password, $user_email);

    // Execute the query
    $sql->execute();

    // Get results
    $result = $sql->get_result();

    // Check if user was correctly registred
    if(mysqli_num_rows($result) > 0) {
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
