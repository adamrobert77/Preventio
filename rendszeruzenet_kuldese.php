<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rendszerüzenet küldése</title>
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
                <li><a href="uj-vizsgalat.php">Új vizsgálat hozzáadása</a></li>
                <li><a class="active">Rendszerüzenet küldése</a></li>
                <li><a href="uzenetek.php">Üzenetek</a></li>
                <li><a href="admin.php">Admin</a></li>
                <li><a href="process_logout.php">Kijelentkezés</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="column side"></div>
        <div class="column content">
            <h2>Rendszerüzenet küldése</h2>
            <h3>Adminként Önnek lehetősége van rendszerüzenetet küldeni, melyet minden felhasználó megkap</h3>

            <?php
            if (isset($_GET['error'])) {
                $error = $_GET['error'];
                echo "<p>Hiba történt: " . htmlspecialchars($error) . "</p>";
            }

            if(isset($_GET['success'])){
                echo "<p> Rendszerüzenet sikeresen elküldve! </p>";
            }
            ?>

            <form action="process_system_message.php" method="post">
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