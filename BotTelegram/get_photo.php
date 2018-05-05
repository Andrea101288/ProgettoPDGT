<?php
require_once(dirname(__FILE__) . '/acquire_datas.php');
// function to get photos sent by users
function get_photo($UserDatas, $token){
    
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
    
    // if is not already exists the User_directory
    if(!file_exists("Pictures/UserId_".$user_id)){
        // i create it with a 777 permission
        $esito = mkdir("Pictures/UserId_".$user_id);
        if($esito)
            echo 'Cartella creata correttamente';
        else
            echo 'Errore nella creazione della cartella';
    }
    // save the photo in a local directory
    $getPhoto = file_put_contents("Pictures/UserId_".$user_id."/LastPhoto.jpg", file_get_contents($pictureUrl)); 
    // get the photo to send to the server
    $datasToSend[$user_id]['photo'] = 'LastPhoto.jpg';
    return $datasToSend[$user_id]['photo'];

}