<?php
session_start();

// Ellenőrizzük, hogy be van-e jelentkezve a felhasználó
if (!isset($_SESSION['username'])) {
    // Ha nincs bejelentkezve, átirányítjuk a felhasználót a bejelentkezés oldalra
    header("Location: bejelentkezes.php");
    exit();
}else if($_SESSION['role']===1){
    header("Location: admin.php");
    exit();
}

// Betöltjük a felhasználó adatait a JSON fájlból
$userData = null;
$username = $_SESSION['username'];

$jsonData = file_get_contents('data/login-data.json');
$users = json_decode($jsonData, true);

foreach ($users as $user) {
    if ($user['username'] === $username) {
        $userData = $user;
        break;
    }
}

// Ellenőrzés, hogy találtunk-e felhasználót a megadott felhasználónév alapján
if ($userData === null) {
    // Ha nem találtunk, valószínűleg valami hiba történt, átirányítjuk a bejelentkezési oldalra
    header("Location: bejelentkezes.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="szerzők" content="Dr. Nébl Annamária, Ádám Róbert" />
    <title>Regisztráció</title>
    <link rel="icon" href="media/images/kereszt.jpg" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/regisztracio.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
<div class="page-container">
    <header>
        <h1 class="logo"
        ><a href="index.php">Prevent.<span class="io">io</span></a></h1>
        <input type="checkbox" id="menuToggle">
        <label class="menu-toggle" for="menuToggle">☰</label>
        <nav>
            <label class="menu-toggle" for="menuToggle">x</label>
            <ul>
                <li><a href="index.php">Főoldal</a></li>
                <li><a href="szurovizsgalatok.php">Szűrővizsgálatok</a></li>
                <li><a href="kapcsolat.php">Kapcsolat</a></li>
                <li><a href="uzenetek.php">Üzenetek</a></li>
                <li><a class="active" href="profil.php">Profil</a></li>
                <li><a href="process_logout.php">Kijelentkezés</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="column side"></div>
        <div class="column content">
            <h1>Felhasználói adatok módosítása</h1> <!-- itt eredetileg action-ben az eredmeny.html volt - amíg mennek a tesztek elállítottam-->
            <form action="process_password_change.php" method="POST"> <!-- POST javasolt, ha jelszót is küldünk szerver felé!! (url-ben GET esetén belekerül minden info)-->
                <fieldset class="felhasznalo">
                    <legend>Jelszó módosítása</legend>
                    <label for="jelszo">Jelenlegi jelszó</label> <!-- Az input mezőket a name="valami"-val tudjuk PHP-nak értelmezhető módon elnevezni -->
                    <input type="password" id="jelszo" name="oldPassword"> <!-- A változók nevét angolul jelöljük az egyértelműség kedvéért-->
                    <label for="jelszo">Jelszó</label>
                    <input type="password" id="jelszo" name="newPassword">
                    <label for="jelszo">Jelszó újra</label>
                    <input type="password" id="jelszo" name="newPassword2">
                    <div>
                        <p class="felteltelek-sorai"><strong class="felteltelek-sorai-kezdes">Jelszó:</strong> legalább 6 karakter hosszú, tartalmazzon betűt és számot egyaránt. Az új jelszónak és ellenőrző cellának egyeznie kell.</p>
                    </div>
                    <button class="button" type="submit" name="passwordChange" value="PasswordChange">
                        <span>Jelszó megváltoztatása</span>
                    </button>
                </fieldset>
            </form>

            <div class="response-container">
                <?php // szúrjuk be a registration class-t

                use classes\Registration;

                require_once 'classes/Registration.php'; // ide bedobjuk a classt

                if ($_SERVER["REQUEST_METHOD"] === "POST") {
                    $registration = new Registration($_POST);
                    $registration->signUp();
                }
                ?>
            </div>
        </div>
        <div class="column side"></div>
    </main>
    <footer>
        <p>Szerzők: Dr. Nébl Annamária, Ádám Róbert</p>
    </footer>
</div>
</body>
</html>