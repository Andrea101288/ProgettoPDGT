<?php
require_once(dirname(__FILE__) . '/acquire_datas.php');
// function to get photos sent by users
function get_photo($UserDatas, $FirebaseDatas, $token) {
    
    $user_id = $UserDatas->result[0]->message->from->id;
    // object photo 
    $photo = $UserDatas->result[0]->message->photo;
    // set the counter to get the last picture into the array
    $a = count($photo)-1;
    // get the photo id
    $file_id = $UserDatas->result[0]->message->photo[$a]->file_id;
    // get file using Telegram API          
    $file = http_request("https://api.telegram.org/bot{$token}/getFile?file_id=".$file_id);            
    $filePath = $file->result->file_path;
    $pictureUrl = "https://api.telegram.org/file/bot".$token."/".$filePath;
    $user = acquire_datas($FirebaseDatas);
    if(!isset($user)){
        // creo una cartella con i permessi a 777
        $esito = mkdir("Pictures/UserId_".$user_id, 0777);
        if($esito)
            echo 'Cartella creata correttamente';
        else
            echo 'Errore nella creazione della cartella';
    }
    // save the photo in a local directory
    $getPhoto = file_put_contents("Pictures/UserId_".$user_id."/Photo_".$i.".jpg", file_get_contents($pictureUrl)); 
    // get the photo to send to the server
    $datasToSend[$user_id]['photo'] = 'Photo'.$user_id.'.jpg';
    ++$i;
    return $datasToSend[$user_id]['photo'];

}