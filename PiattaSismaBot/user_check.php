<?php
  function checkUser($user_id) {
    include 'settings.php';

    // Connect to database
    $conn = mysqli_connect($server, $user, $password) or die("Error in connection to database");
    mysqli_select_db($conn, $database) or die("Error accessing user table");

    // Check if user exist in database
    $sql = "SELECT * FROM api_user WHERE '".$user_id."' = username;";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 0) {
      $default_password = generateRandomString();
      $sql = "INSERT INTO api_user(username, password, email, enabled) VALUES('$user_id', '$default_password', '', True);";
      mysqli_query($conn, $sql);
    }

    mysqli_close($conn);

    return true;
  }


  function generateRandomString($length = 32) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }
?>
