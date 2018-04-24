<?php
// funzione per caricare dati in formato Json su un web service
function send_datas($dataApp, $method = 'POST') {

print_r($dataApp);

// inizializzo i dati da scrivere su firebase
$chat_id = $dataApp['chat_id'];
$user_id = $dataApp['user_id'];
$dataApp2[$user_id] = $dataApp['text'];

// url dove salvare i dati
$url = "https://databasepdgt.firebaseio.com/Conversations/{$chat_id}.json";

// inizializzo curl
$handle = curl_init($url);

if($handle == false){
	die("Ops, cURL non funziona\n");
}
// trasformo il mio array in JSON
$jsondata = json_encode($dataApp2);

// imposto la URl di firebase
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_CUSTOMREQUEST, $method);
//curl_setopt($handle, CURLOPT_HTTPHEADER, $header);
curl_setopt($handle, CURLOPT_POSTFIELDS, $jsondata);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

// eseguo la chiamata
$response = curl_exec($handle);

$status = curl_getinfo($handle, CURLINFO_HTTP_CODE);
if($status != 200){
	die("Richiesta Http fallita, status {$status}\n");
}

// chiudo
curl_close($handle);

//decodifica dei dati json
return json_decode($response);

}