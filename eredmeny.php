<?php

use classes\Examination;
use classes\HealthAnalyzer;

require_once 'classes/HealthAnalyzer.php';
require_once 'classes/Examination.php';

// Ellenőrizzük, hogy be van-e jelentkezve a felhasználó, és megvannak-e a szükséges adatok
session_start();
if (!isset($_SESSION['username'])) {
    // Ha a felhasználó nincs bejelentkezve, átirányítjuk a bejelentkezési oldalra
    header("Location: bejelentkezes.php");
    exit();
}

    // szúrjuk be a dinamikus menüsort
if(isset($_SESSION['username']) && $_SESSION['role'] == 0) {
    // Ha simán user, akkor jelenítsük meg a profil és kijelentkezés gombokat
    $menuItems = [
        ['label' => 'Üzenetek', 'url' => 'uzenetek.php'],
        ['label' => 'Profil', 'url' => 'profil.php'],
        ['label' => 'Kijelentkezés', 'url' => 'process_logout.php']
    ];
} else if(isset($_SESSION['username']) && $_SESSION['role'] == 1) {
    // Ha admin, akkor profil + kijelentkezés + admin gombokat ---> alapvetően adminnak nincs dolga az oldalakon, de kap egy gombot, hogy visszajusson a "helyére"
    $menuItems = [
        ['label' => 'Admin', 'url' => 'admin.php'],
        ['label' => 'Kijelentkezés', 'url' => 'process_logout.php']
    ];
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
}

// HealthAnalyzer példány létrehozása a felhasználó adataival
$healthAnalyzer =new HealthAnalyzer($userData['gender'],$userData['age'],$userData['height'],$userData['weight'],$userData['disorders']);

// Javasolt szűrővizsgálatok lekérése
$recommendedExaminations = $healthAnalyzer->recommendExamination();

$disorderMappings = [
    'ht' => 'Magas vérnyomás',
    'aid' => 'Autoimmun betegség',
    'cc' => 'Daganatos megbetegedés',
    'dm' => 'Cukorbetegség'
];

$genderMappings = [
        'ferfi' => 'Férfi',
        'no' => 'Nő'
]

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Szűrővizsgálatok</title>
    <link rel="icon" href="media/images/kereszt.jpg" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/eredmeny.css">
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
                    <?php foreach ($menuItems as $menuItem): ?>
                        <li>
                            <!--Alkalmazzuk a korábbi formázást bejelentkezésre egy if elágazással, amúgy meg simán printeljünk-->
                            <?php if($menuItem['label'] === "Bejelentkezés"): ?>
                                <a href="<?php echo $menuItem['url']; ?>"><span class=" fa fa-sign-in fa-10x"></span><?php echo $menuItem['label']; ?></a>
                            <?php else: ?>
                                <a href="<?php echo $menuItem['url']; ?>"><?php echo $menuItem['label']; ?></a>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </header>
        <main>

            <div class="column side"></div>
            <div class="column content">
                <h2>Az Ön által megadott adatok:</h2>
                <table class="adatok">
                    <tr>
                        <td>Életkor</td>
                        <td><?= $userData['age'] ?> év</td>
                    </tr>
                    <tr>
                        <td>Nem</td>
                        <td><?= $genderMappings[$userData['gender']] ?></td>
                    </tr>
                    <tr>
                        <td>Magasság</td>
                        <td><?= $userData['height'] ?> cm</td>
                    </tr>
                    <tr>
                        <td>Testsúly</td>
                        <td><?= $userData['weight'] ?> kg</td>
                    </tr>
                    <tr>
                        <td>Kórelőzmény</td>
                        <td><?php if (!empty($userData['disorders'])): ?>
                                <ul>
                                    <?php foreach ($userData['disorders'] as $disorder): ?>
                                        <li><?= $disorderMappings[$disorder] ?? 'Ismeretlen zavar' ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                -
                            <?php endif; ?></td>
                    </tr>
                </table>
                <hr>
                <h2>Javasolt szűrővizsgálatok személyesen Önnek:</h2>
                <?php foreach ($recommendedExaminations as $examinationId): ?>
                    <?php
                    // Examination osztály getById metódusának meghívása az ajánlott vizsgálat ID-vel
                    try {
                        $examination = Examination::getById($examinationId, 'data/szurovizsgalatok.json');
                    } catch (Exception $e) {
                        echo $e;
                    }
                    if ($examination): ?>
                        <section>
                            <h3><?= $examination['title'] ?></h3>
                            <p><?= $examination['description'] ?></p>
                        </section>
                    <?php endif; ?>
                <?php endforeach; ?>
                <hr>
                <div class="megosztas">
                    <h2 class="figyelem">Ossza meg ismerőseivel, hívja fel környezete
                        figyelmét a
                        rendszeres
                        szűrővizsgálatok fontosságára! </h2>
                    <div class="social-media">
                        <a class="fa fa-print"></a>
                        <a class="fa fa-facebook"></a>
                        <a class="fa fa-twitter"></a>
                        <a class="fa fa-instagram"></a>
                    </div>
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