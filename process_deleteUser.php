<?php

use classes\DeleteUser;

require_once 'classes/DeleteUser.php';

if(isset($_POST['confirm_delete']) && $_POST['confirm_delete'] === 'yes'){
    session_start();

    // flag, amivel jelzem, h a user a saját fiókját törli a profil.php-n
    // egyéb esetben az admin töröl az admin.php-n
    // header beállításánál van jelentősége
    $deleteself = false;

    if($_POST['username']==$_SESSION['username']){
        $deleteself = true;
    }

    $userToRemove = $_POST['username'];

        try {

            $deletingUser = new DeleteUser();
            $deletingUser->deleteUser($userToRemove);

            $result = urlencode("Sikeres eltávolítás.");

            if($deleteself){
                header("Location: bejelentkezes.php?message=$result");
            }else{
                header("Location: admin.php?message=$result");
            }
            exit();

        } catch (Exception $e) {
            $error = urlencode($e->getMessage());

            if($deleteself){
                header("Location: profil.php?error=$error");
            }else{
                header("Location: admin.php?error=$error");
            }
            exit();
        }
} else {
    header("Location: bejelentkezes.php");
    exit();
}