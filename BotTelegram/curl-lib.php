<?php
// Library to create http requests

  function http_request($url, $data='', $method='GET') {
    // Init stuff
    $handle = curl_init();

    if($handle == false) {
        die("Ops, cURL non funziona\n");
    }
    
    // Encode data
    $jsonData = json_encode($data);
      
    if($method == 'POST') {
     
      curl_setopt($handle, CURLOPT_POSTFIELDS, $jsonData);
    }

    // Custom header
    $header = array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($jsonData)
    );

    // Set stuff
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_CUSTOMREQUEST, $method);
    // curl_setopt($handle, CURLOPT_HTTPHEADER, $header);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

    // Esecuzione della richiesta, $response = contenuto della risposta testuale
    $response = curl_exec($handle);

    $status = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    if($status != 200) {
        die("Richiesta HTTP fallita, status {$status}\n");
    }

    curl_close($handle);

    // Decodifica della risposta JSON
    return json_decode($response);
}
