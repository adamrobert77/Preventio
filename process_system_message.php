<?php

use classes\Message;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // mindegy melyik admin küldi, a felhasználó annyit lát, h admin küldte az üzit
    $from = "admin";
    $text = $_POST["text"];
    $date = date('m/d/Y h:i:s a', time());

    try {
        // JSON fájl beolvasása
        $jsonData = file_get_contents('data/login-data.json');
        $users = json_decode($jsonData, true);

        // összes felhasználó címzett, aki nem admin
        $to = [];
        foreach ($users as $user) {
            if ($user['role'] == 0) {
                $to[] = $user['username'];
            }
        }


        require_once 'classes/Message.php';

        $new_message = new Message($to,$from,$text,$date);

        $success = $new_message->sendMessage($new_message,"data/messages.json");

        if ($success) {
            header("Location: rendszeruzenet_kuldese.php?success");
        }
        exit();

    }catch(Exception $e){
        $error = urlencode($e->getMessage());
        header("Location: rendszeruzenet_kuldese.php?error=$error");
        exit();
    }
}