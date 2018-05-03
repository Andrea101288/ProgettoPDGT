<?php
// Library to create http requests

function http_request($url) {
	
    $handle = curl_init($url);
    if($handle == false) {
        die("Ops, cURL non funziona\n");
    }
	
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

    // Request execution, $response = textual response content 
    $response = curl_exec($handle);
	
    // request status
    $status = curl_getinfo($handle, CURLINFO_HTTP_CODE);
	
    if($status != 200) {
        die("Richiesta HTTP fallita, status{$status}\n");
    }
	
    // JSON response Decode 
    return json_decode($response);
}
