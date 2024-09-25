<?php
session_start();

// Ellenőrizzük, hogy be van-e jelentkezve a felhasználó
if (!isset($_SESSION['username'])) {
    // Ha nincs bejelentkezve, átirányítjuk a felhasználót a bejelentkezés oldalra
    header("Location: bejelentkezes.php");
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

// dinamikus navbar
if(isset($_SESSION['username']) && $_SESSION['role'] == 0) {
    // Ha simán user, akkor jelenítsük meg a profil és kijelentkezés gombokat
    $menuItems = [
        ['label' => 'Főoldal', 'url' => 'index.php'],
        ['label' => 'Szűrővizsgálatok', 'url' => 'szurovizsgalatok.php'],
        ['label' => 'Kapcsolat', 'url' => 'kapcsolat.php'],
        ['label' => 'Üzenetek', 'url' => 'uzenetek.php'],
        ['label' => 'Profil', 'url' => 'profil.php'],
        ['label' => 'Kijelentkezés', 'url' => 'process_logout.php']
    ];
} else if(isset($_SESSION['username']) && $_SESSION['role'] == 1) {
    // Ha admin, akkor profil + kijelentkezés + admin gombokat ---> alapvetően adminnak nincs dolga az oldalakon, de kap egy gombot, hogy visszajusson a "helyére"
    $menuItems = [
        ['label' => 'Új vizsgálat hozzáadása', 'url' => 'uj-vizsgalat.php'],
        ['label' => 'Rendszerüzenet küldése', 'url' => 'rendszeruzenet_kuldese.php'],
        ['label' => 'Üzenetek', 'url' => 'uzenetek.php'],
        ['label' => 'Admin', 'url' => 'admin.php'],
        ['label' => 'Kijelentkezés', 'url' => 'process_logout.php']
    ];
} else {
    header("Location: index.php"); //ha random lenne más role, akkor azok minden esetben landoljanak index.php-n
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="szerzők" content="Dr. Nébl Annamária, Ádám Róbert" />
    <title>Rendszerüzenetek</title>
    <link rel="icon" href="media/images/kereszt.jpg" />
    <link rel="stylesheet" href="css/uzenetek.css">
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
                <?php foreach ($menuItems as $menuItem): ?>
                    <li>
                        <!--Alkalmazzuk a korábbi formázást bejelentkezésre egy if elágazással, amúgy meg simán printeljünk-->
                        <?php if($menuItem['label'] === "Bejelentkezés"): ?>
                            <a href="<?php echo $menuItem['url']; ?>"><span class="fa fa-sign-in fa-10x"></span><?php echo $menuItem['label']; ?></a>
                        <?php elseif($menuItem['label'] === 'Üzenetek'): ?>
                            <a class="active" href="<?php echo $menuItem['url']; ?>"><?php echo $menuItem['label']; ?></a>
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
            <h1>Üzenetek</h1>
            <?php
            // Betöltjük az üzeneteket a JSON fájlból
            $messagesData = file_get_contents('data/messages.json');
            $messages = json_decode($messagesData, true);

            // Ellenőrizzük az üzeneteket
            foreach ($messages as $message) {
                // Ellenőrizzük, hogy az aktuális felhasználó szerepel-e a címzettek között
                if (in_array($username, $message['to'])) {
                    // Az üzenet megjelenítése
                    echo '<section>';
                    echo '<p><strong>Feladó: </strong>' . $message['from'] . '</p>';
                    echo '<p><strong>Dátum: </strong>' . $message['date'] . '</p>';
                    echo '<p><strong>Üzenet: </strong>' . $message['text'] . '</p>';
                    echo '</section>';
                }
            }
            ?>
        </div>
        <div class="column side"></div>
    </main>

    <footer>
        <p>Szerzők: Dr. Nébl Annamária, Ádám Róbert</p>
    </footer>
</div>
</body>
</html>