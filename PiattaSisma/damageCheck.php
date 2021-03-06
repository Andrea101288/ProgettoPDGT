<?php
  require_once(dirname(__FILE__) . '/httpRequest.php');
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
  $sql = $conn->prepare("SELECT * FROM api_user WHERE username = ?;");

  // Bind paramters
  $sql->bind_param('s', $_SESSION['username']);

  // Execute the query
  $sql->execute();

  // Get results
  $result = $sql->get_result();

  // Close connection to db
  mysqli_close($conn);

  if(mysqli_num_rows($result) > 0) {
    $data['user'] = $_SESSION['username'];

    // Get coordinates from Google Maps API
    $coor = get_coordinates($address.",".$city);

    if($coor == Null) {
        $_SESSION['address_not_found'] = 1;
        header("Location: addDamages.php");
        die();
    }

    $data['lat'] = $coor['lat'];
    $data['lon'] = $coor['lon'];

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

  // Return coordinates from given address
  function get_coordinates($address) {
    // Init stuff
    $handle = curl_init();

    // Set stuff
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address)."&key=AIzaSyCJfFfAiXYVz5GJyuiSU0ybWeq8bQuzvVE";

    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($handle);
    $res = json_decode($response);

    if($res->status == "ZERO_RESULTS") {
        $rv = Null;
    }
    else {
        $rv['lat'] = $res->results[0]->geometry->location->lat;
        $rv['lon'] = $res->results[0]->geometry->location->lng;
    }

    curl_close($handle);
    return $rv;
  }
?>
