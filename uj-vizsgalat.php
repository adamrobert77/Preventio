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
  <title>Új vizsgálat hozzáadása</title>
  <link rel="icon" href="media/images/kereszt.jpg" />
  <link rel="stylesheet" href="css/uj-vizsgalat.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/navbar.css">
</head>
<body>
  <div class="page-container">
    <header>
      <h1 class="logo"><a href="index.php">Prevent.<span class="io">io</span></a></h1>
      <input type="checkbox" id="menuToggle">
      <label class="menu-toggle" for="menuToggle">☰</label>
      <nav>
        <label class="menu-toggle" for="menuToggle">x</label>
        <ul>
          <li><a class="active" href="uj-vizsgalat.php">Új vizsgálat hozzáadása</a></li>
          <li><a href="rendszeruzenet_kuldese.php">Rendszerüzenet küldése</a></li>
          <li><a href="uzenetek.php">Üzenetek</a></li>
          <li><a href="admin.php">Admin</a></li>
          <li><a href="process_logout.php">Kijelentkezés</a></li>
        </ul>
      </nav>
    </header>
    <main>
      <div class="column side"></div>
      <div class="column content">
        <h2>Új vizsgálat hozzáadása</h2>

          <?php
          if (isset($_GET['error'])) {
              $error = $_GET['error'];
              echo "<p>Hiba történt: " . htmlspecialchars($error) . "</p>";
          }

          if(isset($_GET['success'])){
              echo "<p> Vizsgálat sikeresen hozzáadva! </p>";
          }
          ?>

        <form action="process_new_examination.php" method="post" enctype="multipart/form-data">
          <label for="title">Vizsgálat neve</label>
          <br>
          <input type="text" id="title" name="title">
          <br>

          <label for="description">Leírás</label>
          <br>
          <textarea id="description" rows="10" name="description"></textarea>
          <br>

          <label for="image">Kép</label>
          <br>
          <input type="file" id="image" name="image">
          <br>

          <fieldset>
            <legend>Nem</legend>
            <input type="checkbox" id="no" name="gender[]" value="female"/>
            <label for="no">Nő</label>

            <input type="checkbox" id="ferfi" name="gender[]" value="male"/>
            <label for="ferfi">Férfi</label>
          </fieldset>

          <fieldset>
            <legend>Életkor</legend>
            <input type="checkbox" id="18" name="age[]" value="18"/>
            <label for="18">0-18</label>

            <input type="checkbox" id="30"  name="age[]" value="30"/>
            <label for="30">18-30</label>

            <input type="checkbox" id="50" name="age[]" value="50"/>
            <label for="50">30-50</label>

            <input type="checkbox" id="50+" name="age[]" value="50+"/>
            <label for="50+">50+</label>
          </fieldset>

          <fieldset>
            <legend>Rizikófaktorok</legend>
            <input type="checkbox" id="tulsuly" name="riskFactors[]"
                   value="ow"/>
            <label for="tulsuly">Túlsúly</label>
            <br>
            <input type="checkbox" id="magasvernyomas" name="riskFactors[]"
                   value="ht"/>
            <label for="magasvernyomas">Magas vérnyomás</label>
            <br>
            <input type="checkbox" id="daganat" name="riskFactors[]"
                   value="cc"/>
            <label for="daganat">Korábbi daganatos betegség</label>
            <br>
            <input type="checkbox" id="cukorbetegseg" name="riskFactors[]"
                   value="dm"/>
            <label for="cukorbetegseg">Cukorbetegség</label>
            <br>
            <input type="checkbox" id="autoimmun" name="riskFactors[]"
                   value="aid"/>
            <label for="autoimmun">Autoimmun betegség</label>
          </fieldset>
          <input type="submit" value="Hozzáadás">
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