<?php
// function that get datas from firebase
function acquire_datas($dataApp, $method = 'GET') {

$chat_id = $dataApp['chat_id'];
$url = "https://databasepdgt.firebaseio.com/Conversations/{$chat_id}.json";

// inizialize 
$handle = curl_init($url);
if($handle == false){
	die("Ops, cURL doesn't work..\n");
}

// convert array to JSON
$jsondata = json_encode($dataApp);

// Set Firebase URL
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_CUSTOMREQUEST, $method);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

// call execution 
$response = curl_exec($handle);

// return call status
$status = curl_getinfo($handle, CURLINFO_HTTP_CODE);

if($status != 200){
	die("Http request failed, status {$status}\n");
}

// close curl
curl_close($handle);

// decode JSON datas 
return json_decode($response);

}