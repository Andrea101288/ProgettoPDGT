<?php
  include 'settings.php';

  session_start();
  if(!isset($_SESSION['username'])) {
    header("Location: login.php");
  }

  // Get datas
  $file = $_FILES["photo"]["tmp_name"];
  $data['photo'] = base64_encode(file_get_contents($file));
  $address = $_REQUEST["address"];
  $city = $_REQUEST["city"];
  $data['dsc'] = $_REQUEST["description"];

  // Connect to database
  $conn = mysqli_connect($server, $user, $password) or die("Error in connection to database");
  mysqli_select_db($conn, $database) or die("Error accessing user table");

  // Check if user exists in db
  $sql = "SELECT * FROM api_user WHERE '".$_SESSION['username']."' = username;";
  $result = mysqli_query($conn, $sql);

  // Close connection to db
  mysqli_close($conn);

  if(mysqli_num_rows($result) > 0) {
    // Get coordinates from Google Maps API
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address).",".urlencode($city)."&key=AIzaSyCJfFfAiXYVz5GJyuiSU0ybWeq8bQuzvVE";
    $res = http_request($url);

    $data['user'] = $_SESSION['username'];

    $data['lat'] = $res->results[0]->geometry->location->lat;
    $data['lon'] = $res->results[0]->geometry->location->lng;

    $target = "http://piattasisma.ddns.net/api/damages/";

    // Do POST request to API server
    http_request($target, $data, 'POST');

    // Redirect to home
    header("Location: homePage.php");
    die();
  }
  else {
    // Redirect to login
    header("Location: login.php");
    die();
  }


  function http_request($url, $data='', $method='GET') {
    // Init stuff
    $handle = curl_init();

    if($handle == false) {
        die("Ops, cURL don't work\n");
    }

    // Encode data
    $jsonData = json_encode($data);

    // Custom header
    $header = array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($jsonData),
    );

    if($method == 'POST') {
      curl_setopt($handle, CURLOPT_POSTFIELDS, $jsonData);
      curl_setopt($handle, CURLOPT_HTTPHEADER, $header);
    }


    // Set stuff
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($handle);

    $status = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    if($status != 200) {
        die("HTTP request failed, status {$status}\n");
    }

    curl_close($handle);
    return json_decode($response);
  }
?>
