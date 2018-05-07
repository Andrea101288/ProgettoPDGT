<?php
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
