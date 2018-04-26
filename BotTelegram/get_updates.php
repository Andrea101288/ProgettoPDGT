<?php
require_once(dirname(__FILE__) . '/token.php');
require_once(dirname(__FILE__) . '/curl-lib.php');
require_once(dirname(__FILE__) . '/send_datas.php');
require_once(dirname(__FILE__) . '/acquire_datas.php');
require_once(dirname(__FILE__) . '/get_terremoti.php');

if(!isset($token)) {
    die("Token non impostato, creare un file token.php nella cartella root come scritto nella prima esercitazione\n");
}
// Carica l'ID dell'ultimo aggiornamento da file
$last_update_filename = dirname(__FILE__) . '/last-update-id.txt';

$stati = [];

while (1){
    
    if(file_exists($last_update_filename)) {
        $last_update = intval(@file_get_contents($last_update_filename));
    }
    else {
        $last_update = 0;
    }
    
    $dati = http_request("https://api.telegram.org/bot{$token}/getUpdates?offset=".($last_update + 1)."&limit=1");
    print_r($dati);
    if(isset($dati->result[0])) {
        $update_id = $dati->result[0]->update_id;
        // salvo nelle variabili tutti i dati che mi interessano da salvare nel database
        $user_id = $dati->result[0]->message->from->id;
        $chat_id = $dati->result[0]->message->chat->id;   
        $text = $dati->result[0]->message->text;            
        
        if(isset($text)){
            // creo una struttura per i miei dati
            $dataApp = [
            'user_id' => $user_id,
            'chat_id' => $chat_id,
            'text' => $text
            ]; 
            
            // guardo sul database creato di firebase se c'è la chat_id
            $memory = acquire_datas($dataApp);	        
            
            // se l'utente ha già inviato un messaggio 
            if(isset($memory->$user_id)) {
                
                // acquisisco il nome dell'utente 
                $name = $dati->result[0]->message->from->first_name;
                // sovrascrivo i dati su firebase con l'ultimo messaggio
                $memory = send_datas($dataApp, "PATCH");
                
                // messaggio di benvenuto del nuovo utente
                http_request("https://api.telegram.org/bot{$token}/sendMessage?chat_id=".$chat_id."&text= Bentornato ".$name."!");
                
            }else{
                
                // vuol dire che è un nuovo utente e quindi gli mando il mess di benvenuto	
                // prendo il nome del nuovo utente per usarlo nel messaggio
                $name = $dati->result[0]->message->from->first_name;
                
                // messaggio di benvenuto del nuovo utente
                http_request("https://api.telegram.org/bot{$token}/sendMessage?chat_id=".$chat_id."&text= Benvenuto".$name."!"); 
                
            }    
            // salvo i dati sul database del nuovo utente
            $memory = send_datas($dataApp, "PUT");
        }    
        // Memorizziamo il nuovo ID update nel file
        file_put_contents($last_update_filename, $update_id);
        
        // prendo le coordinate dall'utente
        if(isset($dati->result[0]->message->location)){
            $lat = $dati->result[0]->message->location->latitude;
            $long = $dati->result[0]->message->location->longitude;
        } 
        
        if(isset($text)){
            
            switch($text){
        
                case "/terremoti":
            
                    // Mando un messaggio all'utente di inviarmi la posizione
                    http_request("https://api.telegram.org/bot{$token}/sendMessage?chat_id=".$chat_id."&text=Inviami la tua posizione..");
                
                    // entro nello stato 1
                    $stati[(string)$chat_id] = 1;      
            
                    default;
            }
        
        }else if (isset($dati->result[0]->message->location) and $stati[(string)$chat_id] == 1) {
            
            $terremoti = getTerremoti($dati, $token);   
           
        }
    }
} 
   /* switch($text)
    
        case "/terremoti" :
    
            // guardo se mi ha inviato la posizione e in caso affermativo gli prendo le coordinate
            if(isset($dati->result[0]->message->location)){
                $lat = $dati->result[0]->message->location->latitude;
                $long = $dati->result[0]->message->location->longitude;
                $dati_terremoto = http_request("http://localhost:8000/earthquakes/italy?lon=".$long."&lat=".$lat."&rad=35");
                print_r("http://localhost:8000/earthquakes/italy?lon=".$long."&lat=".$lat."&rad=35");

                print_r($dati_terremoto);
                $dati_da_inviare = json_encode($dati_terremoto);
                http_request("https://api.telegram.org/bot{$token}/sendMessage?chat_id=".$chat_id."&text= ".urlencode($dati_da_inviare)."");
            // $memory = send_datas($dataApp, "PUT");
            }else
                http_request("https://api.telegram.org/bot{$token}/sendMessage?chat_id=".$chat_id."&text=Non ho ricevuto la tua posizione! Riprova");
            
        case "/danno" : 

            // gli mando la location dei danni
            // guardo se mi ha inviato la posizione e in caso affermativo gli prendo le coordinate
            if(isset($dati->result[0]->message->location)){
                $lat = $dati->result[0]->message->location->latitude;
                $long = $dati->result[0]->message->location->longitude;
                $dati_terremoto = http_request("http://localhost:8000/earthquakes/italy?lon=".$long."&lat=".$lat."&rad=35");
                print_r($dati_terremoto);
                $dati_da_inviare = json_encode($dati_terremoto);
                http_request("https://api.telegram.org/bot{$token}/sendLocation?chat_id=".$chat_id."&longitude=".$long."&latitude=".$lat."");
            } 
    
    
    
    
    
    
}  */