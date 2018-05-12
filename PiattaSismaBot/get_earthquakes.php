<?php
require_once(dirname(__FILE__) . '/curl-lib.php');
function getEarthquakes($UserDatas, $token){        
   
    // get Datas from Telegram user
    $lat = $UserDatas->result[0]->message->location->latitude;
    $long = $UserDatas->result[0]->message->location->longitude;
    $chat_id = $UserDatas->result[0]->message->chat->id;
    $earthquakes_datas = http_request("http://piattasisma.ddns.net/api/earthquakes/italy?lon=".$long."&lat=".$lat."&rad=30");
    
    // for each earthquakes i find in a 30km radius, i get the datas which i need to send to the user the description and location
    for($i = 0; $i < count($earthquakes_datas->features); $i++) {
        
        $lat = $earthquakes_datas->features[$i]->geometry->coordinates[1];
        $long = $earthquakes_datas->features[$i]->geometry->coordinates[0];
        
        // response using telegram API to send a location
        http_request("https://api.telegram.org/bot{$token}/sendLocation?chat_id=".$chat_id."&longitude=".$long."&latitude=".$lat."");    
        // in some datas i need to get only a part of them using explode();
        $description1 = json_encode($earthquakes_datas->features[$i]->properties->description);
        $description = explode('"', $description1);
        $date1 = json_encode($earthquakes_datas->features[$i]->properties->time);
        $date = explode('"', $date1);
        $time = explode('T', $date[1]);
        $magnitude1 = json_encode($earthquakes_datas->features[$i]->properties->magnitude);
        $magnitude = explode('"', $magnitude1);
        $depth1 = json_encode($earthquakes_datas->features[$i]->properties->depth);
        $depth = explode('"', $depth1);
        
        // response using telegram API to send a message 
        http_request("https://api.telegram.org/bot{$token}/sendMessage?chat_id=".$chat_id."&text= Location: ".
                                                                                    urlencode($description[1].
                                                                                          "\nDate: ".$time[0].
                                                                                          "\nTime: ".$time[1].
                                                                                          "\nMagnitude: ".$magnitude[1].
                                                                                          "\nDepth: ".$depth[1]." mt"));
    }
}     
