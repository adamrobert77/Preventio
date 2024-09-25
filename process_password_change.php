<?php

use classes\PasswordChange;

require_once 'classes/PasswordChange.php';

if(isset($_POST['passwordChange'])){

    try {
        session_start();

        $user = $_SESSION['username'];
        $password = $_POST['oldPassword'];
        $newPassword = $_POST['newPassword'];
        $newPassword2 = $_POST['newPassword2'];


        $passwordChange = new PasswordChange(); // töröljük a felhasználót
        $passwordChange->changePassword($user, $password, $newPassword, $newPassword2);

        $result = urlencode("Sikeres módosítás.");
        header("Location: profil.php?message=$result");
    } catch (Exception $e) {
        $error = urlencode($e->getMessage());
        header("Location: profil.php?error=$error");
        exit();
    }
} else {
    header("Location: profil.php");
}

