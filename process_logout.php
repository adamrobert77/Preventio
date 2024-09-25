<?php

    session_start(); // minden esetben meghívjuk, mielőtt szeretnénk bármi session-nel kapcsolatos műveletet végezni
    // session törlése
    session_destroy();
    if ($_SESSION['role'] == 0 || $_SESSION['role'] == 1) {
        header("Location: bejelentkezes.php"); // ugorjunk ide, ha user, vagy admin
    }   else {                                      // elméletileg ez a scope sosem futhatna le, de legyen alternatíva
        header("Location: index.php");
        echo "Valami hiba történt - nem megfelelő role.";
    }

    exit();