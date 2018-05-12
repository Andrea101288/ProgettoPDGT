<?php
require_once(dirname(__FILE__) . '/token.php');
require_once(dirname(__FILE__) . '/curl-lib.php');
require_once(dirname(__FILE__) . '/send_datas.php');
require_once(dirname(__FILE__) . '/acquire_datas.php');
require_once(dirname(__FILE__) . '/get_earthquakes.php');
require_once(dirname(__FILE__) . '/user_check.php');


// Upload last update ID from text file
$last_update_filename = dirname(__FILE__) . '/last-update-id.txt';

// creation an array of states which the Bot can assume
$states = [];

// import coded utf-8 emoji
$earth = "\xF0\x9F\x8C\x8F";
$handOk = "\xE2\x9C\x8C";
$teeth = "\xF0\x9F\x98\xAC";
$tongue = "\xF0\x9F\x98\x9B";
$sos = "\xF0\x9F\x86\x98";
$constr = "\xF0\x9F\x9A\xA7";
$pc = "\xF0\x9F\x92\xBB";
$gradCap = "\xF0\x9F\x8E\x93";
$volcano = "\xF0\x9F\x8C\x8B";
$usaFlag = "\xF0\x9F\x87\xBA\xF0\x9F\x87\xB8";
$itaFlag = "\xF0\x9F\x87\xAE\xF0\x9F\x87\xB9";
$handsUp = "\xF0\x9F\x99\x8C";

$datasToSend = [];

while (1){
    if(file_exists($last_update_filename)) {
        $last_update = intval(@file_get_contents($last_update_filename));
    }
    else {
        $last_update = 0;
    }
    // next request getUpdate
    $datas = http_request("https://api.telegram.org/bot{$token}/getUpdates?offset=".($last_update + 1)."&limit=1");
    print_r($datas);
    // get datas from Telegram User
    if(isset($datas->result[0])) {
        $update_id = $datas->result[0]->update_id;
        // Store in variables all the data that interest me to be saved in the database
        $user_id = $datas->result[0]->message->from->id;
        $chat_id = $datas->result[0]->message->chat->id;
        $text = $datas->result[0]->message->text;

        if(isset($text)){
            // Create data structure as an array
            $dataApp = [
                'user_id' => $user_id,
                'chat_id' => $chat_id,
                'text' => $text
            ];

            // Check in firebase database if exist user_id
            $memory = acquire_datas($dataApp);

            // If user has already sent a message before
            if(isset($memory->$user_id)) {
                // Get User name
                $name = $datas->result[0]->message->from->first_name;
                // Overwrite the data on firebase with the last message
                $memory = send_datas($dataApp, "PATCH");
            }else {
                // If i'm here it means that it is a new user so i send a welcome message
                // get User name to use it in the welcome message
                $name = $datas->result[0]->message->from->first_name;

                // Welcome message
                http_request("https://api.telegram.org/bot{$token}/sendMessage?chat_id=".$chat_id."&text= Benvenuto".$name."!");
            }
            // Save new user datas in db
            $memory = send_datas($dataApp, "PUT");
        }
        // Memorize new ID update in the file
        file_put_contents($last_update_filename, $update_id);

        // Get coordinates
        if(isset($datas->result[0]->message->location)) {
            $lat = $datas->result[0]->message->location->latitude;
            $long = $datas->result[0]->message->location->longitude;
        }

        if(isset($text) and (!isset($states[$chat_id])) or $states[(string)$chat_id] == 0) {
            switch($text) {
                // Bot Commands
                case "/start":
                    // send the welcome message and a little explanation of the Bot
                    $msg = "Ciao sono".$earth." SismaBot ".$earth."\nGrazie a me puoi ottenere le location e i dati di terremoti in un raggio di 30 km da un luogo da te scelto!".$handOk."\nSono in grado di inviarti descrizioni e luoghi in cui si è verificato un sisma in qualunque parte del mondo!\n(o quasi".$teeth.")\nPer poter effettuare la ricerca ho bisogno di sapere dove ti trovi, puoi dirmelo semplicemente premendo sul tasto invia allegato selezionando la posizione\n(ricordati di attivare il GPS".$tongue."..)\n\nPer maggiori informazioni digita il comando /help ".$sos."";
                    http_request("https://api.telegram.org/bot{$token}/sendMessage?chat_id=".$chat_id."&text=".urlencode($msg)."");
                    break;

                case "/earthquakes":
                    // Send a message to the user saying to send me his position
                    http_request("https://api.telegram.org/bot{$token}/sendMessage?chat_id=".$chat_id."&text=Inviami la tua posizione..");
                    // Go to state 1
                    $states[(string)$chat_id] = 1;
                    break;

                case "/damage":
                    // Send a message to the user saying to send me a photo
                    http_request("https://api.telegram.org/bot{$token}/sendMessage?chat_id=".$chat_id."&text=Inviami una foto del danno");
                    // Go to state 2
                    $states[(string)$chat_id] = 2;
                    break;

                case "/help":
                    $helpMsg = "".$earth." SismaBot ".$earth." a tua disposizione! Ecco a te i comandi:\n1) /earthquakes ti permette di conoscere descrizione e località di ogni terremoto nel raggio di 30 km dalla zona da te scelta inviatami condividendo la location\n2) /damage premette di inviare posizione e descrizione di danni provocati da terremoti sull'apposito sito www.Piattasisma.com dove le utorità poi procederanno alla visione\n3) /info per avere tutte le informazioni sul Bot e sul sito collegato ad esso\n4) /help per sapere come utilizzare le funzionalità del bot";
                    // Send a message to the user explaining how to use the Bot Commands
                    http_request("https://api.telegram.org/bot{$token}/sendMessage?chat_id=".$chat_id."&text=".urlencode($helpMsg)."");
                    break;

                case "/info":
                    $infoMsg = "SismaBot si collega a una piattaforma chiamata".$earth." Piattasisma ".$earth." creata per un progetto da due studenti della facoltà di Informatica applicata ".$pc." dell'Università di Urbino ".$gradCap."\n(Dawid Weglarz".$constr.$constr."Andrea Mancini)\nI dati sismici sono acquisiti da OpenData messi a disposizione da diversi siti tra cui:\nINGV (Istituto Nazionale di Geofisica e Vulcanologia)".$volcano.$itaFlag."\nUSGS (United States Geological Survey)".$usaFlag."\nDatagov (U.S. Government’s open data)".$usaFlag."";
                    // Send a message with some general info
                    http_request("https://api.telegram.org/bot{$token}/sendMessage?chat_id=".$chat_id."&text=".urlencode($infoMsg)."");
                    break;

                default:
                    $infoMsg = "Scusami non ho capito...";
                    // Send a message with some general info
                    http_request("https://api.telegram.org/bot{$token}/sendMessage?chat_id=".$chat_id."&text=".urlencode($infoMsg)."");
            }
        }else if (isset($datas->result[0]->message->location) and $states[(string)$chat_id] == 1) {
            $eartquakes = getEarthquakes($datas, $token);

            // Return to state 0
            $states[(string)$chat_id] = 0;
        }else if (isset($datas->result[0]->message->photo) and $states[(string)$chat_id] == 2) {
            // Set the counter to get the last picture in the array
            $last_position = count($datas->result[0]->message->photo) - 1;
            // Get the photo id
            $file_id = $datas->result[0]->message->photo[$last_position]->file_id;
            // Get file using Telegram API
            $file = http_request("https://api.telegram.org/bot{$token}/getFile?file_id=".$file_id);
            $filePath = $file->result->file_path;
            $pictureUrl = "https://api.telegram.org/file/bot".$token."/".$filePath;

            $datasToSend[$user_id]['photo'] = base64_encode(file_get_contents($pictureUrl));

            // Description request
            $msg = "Inviami una breve descrizione";
            http_request("https://api.telegram.org/bot{$token}/sendMessage?chat_id=".$chat_id."&text=".urlencode($msg));

            // Go to state 3
            $states[(string)$chat_id] = 3;
        }else if(isset($text) and $states[(string)$chat_id] == 3) {
            $datasToSend[$user_id]['dsc'] = $text;
            $msg = "Ora inviami la posizione del danno";
            http_request("https://api.telegram.org/bot{$token}/sendMessage?chat_id=".$chat_id."&text=".urlencode($msg));

            // Go to state 4
            $states[(string)$chat_id] = 4;
        }else if(isset($datas->result[0]->message->location) and $states[(string)$chat_id] == 4) {
            $lat = $datas->result[0]->message->location->latitude;
            $long = $datas->result[0]->message->location->longitude;

            // Data to be sent to server
            $datasToSend[$user_id]['lat'] = $lat;
            $datasToSend[$user_id]['lon'] = $long;

            // Check if user is in DB
            checkUser($user_id);
            $datasToSend[$user_id]['user'] = (string)$user_id;

            $r = http_request("http://piattasisma.ddns.net/api/damages/", $datasToSend[$user_id], 'POST');

            if($r != "Error") {
                $msg = "Ottimo Lavoro! ".$handsUp." Caricamento del danno completato!";
                http_request("https://api.telegram.org/bot{$token}/sendMessage?chat_id=".$chat_id."&text=".urlencode($msg));
            } else {
                $msg = "Si è verificato un errore.\nSi prega di riprovare.";
                http_request("https://api.telegram.org/bot{$token}/sendMessage?chat_id=".$chat_id."&text=".urlencode($msg));
            }

            // Return to state 0
            $states[(string)$chat_id] = 0;
        } else {
            // Return to state 0
            $states[(string)$chat_id] = 0;
        }
    }
}
