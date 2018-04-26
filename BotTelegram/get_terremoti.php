<?php
require_once(dirname(__FILE__) . '/curl-lib.php');
function getTerremoti($dati, $token){        
   
    $lat = $dati->result[0]->message->location->latitude;
    $long = $dati->result[0]->message->location->longitude;
    $chat_id = $dati->result[0]->message->chat->id;
    $dati_terremoto = http_request("http://localhost:8000/earthquakes/italy?lon=".$long."&lat=".$lat."&rad=5");    
    print_r($dati_terremoto);
     
    for($i = 0; $i < count($dati_terremoto->features); $i++) {
        
        $lat = $dati_terremoto->features[$i]->geometry->coordinates[1];
        $long = $dati_terremoto->features[$i]->geometry->coordinates[0];
        
        http_request("https://api.telegram.org/bot{$token}/sendLocation?chat_id=".$chat_id."&longitude=".$long."&latitude=".$lat."");    
        $dati_da_inviare = json_encode($dati_terremoto->features[$i]);
        http_request("https://api.telegram.org/bot{$token}/sendMessage?chat_id=".$chat_id."&text= ".urlencode($dati_da_inviare)."");
    
    }
}     