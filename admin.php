<?php
session_start();

// Ellenőrizzük, hogy be van-e jelentkezve a felhasználó
if (!isset($_SESSION['username'])) {
    // Ha nincs bejelentkezve, átirányítjuk a felhasználót a bejelentkezés oldalra
    header("Location: bejelentkezes.php");
    exit();
} else if (!($_SESSION['role'] == 1)) {
    // Amennyiben be van jelentkezve, de nem admin, redirect to profil.php (URL elérés lezárása)
    header("Location: profil.php");
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
    <title>Admin felület</title>
    <link rel="icon" href="media/images/kereszt.jpg" />
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/style.css">
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
                    <li><a href="uj-vizsgalat.php">Új vizsgálat hozzáadása</a></li>
                    <li><a href="rendszeruzenet_kuldese.php">Rendszerüzenet küldése</a></li>
                    <li><a href="uzenetek.php">Üzenetek</a></li>
                    <li><a class="active" href="admin.php">Admin</a></li>
                    <li><a class="right" href="process_logout.php">Kijelentkezés</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <div class="column side"></div>
            <div class="column content">
                <h1>Felhasználók</h1>
                <?php
                if (isset($_GET['error']) ) {
                    $error = $_GET['error'];
                    echo "<p>Hiba történt: " . htmlspecialchars($error) . "</p>";
                } else if (isset($_GET['message']) ) {
                    $message = $_GET['message'];
                    echo "<p>Üzenet: " . htmlspecialchars($message) . "</p>";
                }
                ?>
                <form action="process_deleteUser.php" method="POST">
                    <table>
                        <tr>
                            <th><strong>Profilkép</strong></th>
                            <th><strong>Felhasználónév</strong></th>
                            <th><strong>Szerepkör</strong></th>
                            <th><strong>Kijelölés</strong></th>
                        </tr>
                        <?php
                        if (!empty($users)) {
                            foreach ($users as $user) {
                                echo "<tr>";
                                if (isset($user['image'])) {
                                    echo "<td><img src='" . $user['image'] . "' width='50'></td>";
                                } else {
                                    echo "<td>Nincs kép</td>";
                                }
                                echo "<td>" . $user['username'] . "</td>";
                                echo "<td>" . ($user['role'] == 1 ? "Admin" : "Felhasználó") . "</td>";
                                echo "<td><input type='radio' name='username' value='". $user['username'] ."'></td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </table>
                    <input type="hidden" name="confirm_delete" value="yes">
                    <button type="submit" class="delete-button">Kijelölt felhasználó törlése</button>
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