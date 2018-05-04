<?php
// function to upload datas in JSON format in a web service
function send_datas($dataApp, $method = 'POST') {

    // Inizialize datas
    $chat_id = $dataApp['chat_id'];
    $user_id = $dataApp['user_id'];
    $dataApp2[$user_id] = $dataApp['text'];

    // firebase Url 
    $url = "https://databasepdgt.firebaseio.com/Conversations/{$chat_id}.json";

    // curl init
    $handle = curl_init($url);

    if($handle == false){
        die("Ops, cURL doesn't work..\n");
    }
    // Convert array to JSON data
    $jsondata = json_encode($dataApp2);

    // Set option 
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($handle, CURLOPT_POSTFIELDS, $jsondata);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

    // call exec
    $response = curl_exec($handle);
    // get call states
    $status = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    if($status != 200){
        die("Http request failed, status{$status}\n");
    }

    // close 
    curl_close($handle);

    // json datas decode 
    return json_decode($response);

}