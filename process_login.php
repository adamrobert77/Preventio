<?php

use classes\Login;

require_once 'classes/Login.php';

if (isset($_POST["login"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $login = new Login();
        $userData = $login->login($username, $password);

        session_start();
        $_SESSION['username'] = $userData['username'];
        $_SESSION['role'] = $userData['role'];

        if ($_SESSION['role'] == 0) {
            header("Location: profil.php"); // ugorjunk ide, ha user
        } else if ($_SESSION['role'] == 1) {
            header("Location: admin.php"); // ugorjunk ide, ha admin
        } else {
            echo "nem megfelelő jogosultság";
        }
        exit();
    } catch (Exception $e) {
        $error = urlencode($e->getMessage());
        header("Location: bejelentkezes.php?error=$error");
        exit();
    }
}