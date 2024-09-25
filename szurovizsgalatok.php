<?php

session_start();

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
} else {
    $menuItems = [
        ['label' => 'Regisztráció', 'url' => 'regisztracio.php'],
        ['label' => 'Bejelentkezés', 'url' => 'bejelentkezes.php'],
    ];
}
?>

<!doctype html>
<html lang="hu">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Szűrővizsgálatok</title>
  <link rel="icon" href="media/images/kereszt.jpg" />
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/szurovizsgalatok.css">
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
          <li><a href="index.php">Főoldal</a></li>
          <li><a class="active" href="szurovizsgalatok.php">Szűrővizsgálatok</a></li>
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
        <h1 class="page-title">Szűrővizsgálatok</h1>
        <div class="flex-container">
            <?php
            // beolvasas jsonbol
            $json = file_get_contents('data/szurovizsgalatok.json');
            $data = json_decode($json, true);

            // elemek generálása
            foreach ($data as $item) {
                echo '<div class="card">';
                echo '<img src="' . $item['image'] . '" alt="' . $item['title'] . '">';
                echo '<div class="card-container">';
                echo '<h4>' . $item['title'] . '</h4>';
                echo '<p>' . $item['description'] . '</p>';
                echo '</div>';
                echo '</div>';
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