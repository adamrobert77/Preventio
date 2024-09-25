<?php

session_start();

use classes\Message;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // az aktuális user a feladó
    $from = $_SESSION["username"];
    $text = $_POST["text"];
    $date = date('m/d/Y h:i:s a', time());

    try {
        // JSON fájl beolvasása
        $jsonData = file_get_contents('data/login-data.json');
        $users = json_decode($jsonData, true);

        // minden admin címzett
        $to = [];
        foreach ($users as $user) {
            if ($user['role'] == 1) {
                $to[] = $user['username'];
            }
        }


        require_once 'classes/Message.php';

        $new_message = new Message($to,$from,$text,$date);

        $success = $new_message->sendMessage($new_message,"data/messages.json");

        if ($success) {
            header("Location: admin_uzenet.php?success");
        }
        exit();

    }catch(Exception $e){
        $error = urlencode($e->getMessage());
        header("Location: admin_uzenet.php?error=$error");
        exit();
    }
}