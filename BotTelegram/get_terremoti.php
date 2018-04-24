<?php
require_once(dirname(__FILE__) . '/token.php');
require_once(dirname(__FILE__) . '/curl-lib.php');
require_once(dirname(__FILE__) . '/send_datas.php');
require_once(dirname(__FILE__) . '/acquire_datas.php');

if(!isset($token)) {
    die("Token non impostato, creare un file token.php nella cartella root come scritto nella prima esercitazione\n");
}

// Carica l'ID dell'ultimo aggiornamento da file
$last_update_filename = dirname(__FILE__) . '/last-update-id.txt';

if(file_exists($last_update_filename)) {
    $last_update = intval(@file_get_contents($last_update_filename));
}
else {
    $last_update = 0;
}

//$dati = http_request("https://api.telegram.org/bot{$token}/getUpdates?offset=".($last_update + 1)."&limit=1");
$dati = http_request("http://localhost:8000/terremoti/italy");
print_r($dati);

if(isset($dati->result[0])) {
    $update_id = $dati->result[0]->update_id;

	// salvo nelle variabili tutti i dati che mi interessano da salvare nel database
	$user_id = $dati->result[0]->message->from->id;
    $chat_id = $dati->result[0]->message->chat->id;
    $text = $dati->result[0]->message->text;
	
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
		
		// mando l'ultimo messaggio memorizzato
		$message = $memory->$user_id;
		
		// Mando un messaggio all'utente sul bot con l'ultimo messaggio che mi aveva inviato precedentemente
        http_request("https://api.telegram.org/bot{$token}/sendMessage?chat_id=".$chat_id."&text=Ultimo Messaggio precedentemente inviato:".urlencode($message));
		
		// sovrascrivo i dati su firebase con l'ultimo messaggio
		$memory = send_datas($dataApp, "PATCH");	
    }
    else {
		
		// vuol dire che è un nuovo utente e quindi gli mando il mess di benvenuto	
		// prendo il nome del nuovo utente per usarlo nel messaggio
		$name = $dati->result[0]->message->from->first_name;
		
		// messaggio di benvenuto del nuovo utente
		$message = "Benvenuto ".$name."!";
        
        http_request("https://api.telegram.org/bot{$token}/sendMessage?chat_id=".$chat_id."&text=".urlencode($message)."!");	
		// salvo i dati sul database del nuovo utente
		
		// $memory = send_datas($dataApp, "PUT");

	}
	

    // Memorizziamo il nuovo ID nel file
    file_put_contents($last_update_filename, $update_id);
}