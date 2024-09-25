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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="szerzők" content="Dr. Nébl Annamária, Ádám Róbert" />
    <title>Üzenet küldése az adminnak</title>
    <link rel="icon" href="media/images/kereszt.jpg" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/navbar.css">
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
                <li><a href="profil.php">Profil</a></li>
                <li><a href="process_logout.php">Kijelentkezés</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="column side"></div>
        <div class="column content">
            <h1>Üzenet küldése az oldal adminisztrátorának</h1>

            <?php
            if (isset($_GET['error'])) {
                $error = $_GET['error'];
                echo "<p>Hiba történt: " . htmlspecialchars($error) . "</p>";
            }

            if(isset($_GET['success'])){
                echo "<p> Rendszerüzenet sikeresen elküldve! </p>";
            }
            ?>

            <form action="process_admin_message.php" method="post">
                <label for="text">Üzenet szövege</label>
                <br>
                <textarea id="text" rows="10" name="text"></textarea>
                <br>
                <input type="submit" value="Küldés">
            </form>
        </div>
        <div class="column side"></div>
    </main>

    <footer>
        <p>Szerzők: Dr. Nébl Annamária, Ádám Róbert</p>
    </footer>
</div>
</body>
</html>