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
        $description1 = json_encode($dati_terremoto->features[$i]->properties->description);
        $description = explode('"', $description1);
        $date1 = json_encode($dati_terremoto->features[$i]->properties->time);
        $date = explode('"', $date1);
        $time = explode('T', $date[1]);
        $magnitude1 = json_encode($dati_terremoto->features[$i]->properties->magnitude);
        $magnitude = explode('"', $magnitude1);
        $depth1 = json_encode($dati_terremoto->features[$i]->properties->depth);
        $depth = explode('"', $depth1);
        http_request("https://api.telegram.org/bot{$token}/sendMessage?chat_id=".$chat_id."&text= Location: ".
                                                                                    urlencode($description[1].
                                                                                          "\nDate: ".$time[0].
                                                                                          "\nTime: ".$time[1].
                                                                                          "\nMagnitude: ".$magnitude[1].
                                                                                          "\nDepth: ".$depth[1]." mt"));
    }
}     