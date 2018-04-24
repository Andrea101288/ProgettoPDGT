<?php
// funzione per leggere dati in formato Json su firebase
function acquire_datas($dataApp, $method = 'GET') {

$chat_id = $dataApp['chat_id'];
$url = "https://databasepdgt.firebaseio.com/Conversations/{$chat_id}.json";

// inizializzo
$handle = curl_init($url);
if($handle == false){
	die("Ops, cURL non funziona\n");
}

// trasformo il mio array in JSON
$jsondata = json_encode($dataApp);

// imposto la URl di firebase
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_CUSTOMREQUEST, $method);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

// eseguo la chiamata
$response = curl_exec($handle);

$status = curl_getinfo($handle, CURLINFO_HTTP_CODE);

if($status != 200){
	die("Richiesta Http fallita, status {$status}\n");
}

// chiudo
curl_close($handle);

// decodifica dei dati json 
return json_decode($response);

}