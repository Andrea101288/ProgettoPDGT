<?php
require_once(dirname(__FILE__) . '/token.php');
require_once(dirname(__FILE__) . '/curl-lib.php');
require_once(dirname(__FILE__) . '/send_datas.php');
require_once(dirname(__FILE__) . '/acquire_datas.php');
require_once(dirname(__FILE__) . '/get_updates.php');
function getTerremoti($dataApp, $memory){        
        
      // se l'utente ha già inviato un messaggio 
        if(isset($memory->$user_id)) {
            
            $name = $dati->result[0]->message->from->first_name;
            // mando l'ultimo messaggio memorizzato
            $message = $memory->$user_id;
            
            // Mando un messaggio all'utente sul bot con l'ultimo messaggio che mi aveva inviato precedentemente
            http_request("https://api.telegram.org/bot{$token}/sendMessage?chat_id=".$chat_id."&text=Bentornato".$name."!");
            
            // sovrascrivo i dati su firebase con l'ultimo messaggio
            $memory = send_datas($dataApp, "PATCH");	
        }else{
            
            // vuol dire che è un nuovo utente e quindi gli mando il mess di benvenuto	
            // prendo il nome del nuovo utente per usarlo nel messaggio
            $name = $dati->result[0]->message->from->first_name;
            // messaggio di benvenuto del nuovo utente
            http_request("https://api.telegram.org/bot{$token}/sendMessage?chat_id=".$chat_id."&text= Benvenuto".$name."!");    
        }    
        // salvo i dati sul database del nuovo utente
        $memory = send_datas($dataApp, "PUT");
        
        // Memorizziamo il nuovo ID update nel file
        file_put_contents($last_update_filename, $update_id);
        
        // gli mando la location dei danno
            if(isset($dati->result[0]->message->location)){
                $lat = $dati->result[0]->message->location->latitude;
                $long = $dati->result[0]->message->location->longitude;
                $dati_terremoto = http_request("http://localhost:8000/earthquakes/italy?lon=".$long."&lat=".$lat."&rad=5");
                print_r($dati_terremoto);
                $dati_da_inviare = json_encode($dati_terremoto);
                http_request("https://api.telegram.org/bot{$token}/sendLocation?chat_id=".$chat_id."&longitude=".$long."&latitude=".$lat."");
                $dati_terremoto = http_request("http://localhost:8000/earthquakes/italy?lon=".$long."&lat=".$lat."");
                http_request("https://api.telegram.org/bot{$token}/sendMessage?chat_id=".$chat_id."&text= ".urlencode($dati_terremoto)."");
                
            }       
    }     