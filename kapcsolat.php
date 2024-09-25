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

<!DOCTYPE html>
<html lang="hu">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="szerzők" content="Dr. Nébl Annamária, Ádám Róbert" />
    <meta name="description" content="Kapcsolat" />
    <title>Kapcsolatok</title>
    <link rel="icon" href="media/images/kereszt.jpg" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/kapcsolat.css">
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
                    <li><a class="active" href="kapcsolat.php">Kapcsolat</a></li>
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
                    <h1>Kapcsolat</h1>
                   <div class="flex-container">
                       <div class="card">
                           <div class="tabla-overflow">
                               <table>
                                   <thead>
                                       <tr>
                                           <th id="nev">Név</th>
                                           <th id="szakterulet">Szakterület</th>
                                           <th id="email">Email</th>
                                           <th id="telefon">Telefonszám</th>
                                       </tr>
                                   </thead>
                                    <tbody>
                                        <tr>
                                            <td headers="nev">Dr. Nébl Annamária</td>
                                            <td headers="szakterulet">Tanácsadás</td>
                                            <td headers="email">nebl_ancsi@valami.com</td>
                                            <td headers="telefon">+36/90/200-3000</td>
                                        </tr>
                                        <tr class="paratlan">
                                            <td headers="nev">Ádám Róbert</td>
                                            <td headers="szakterulet">Tanácsadás</td>
                                            <td headers="email">adam_robert@valami.com</td>
                                            <td headers="telefon">+36/90/200-4000</td>
                                        </tr>
                                        <tr>
                                            <td headers="nev">Valaki01</td>
                                            <td headers="szakterulet">Tanácsadás</td>
                                            <td headers="email">valaki01@valami.com</td>
                                            <td headers="telefon">+36/90/200-5000</td>
                                        </tr>
                                        <tr class="paratlan">
                                            <td headers="nev">Valaki02</td>
                                            <td headers="szakterulet">Tanácsadás</td>
                                            <td headers="email">valaki02@valami.com</td>
                                            <td headers="telefon">+36/90/200-6000</td>
                                        </tr>
                                    </tbody>
                               </table>
                           </div>
                       </div>
                       <div class="break"></div>
                       <div class="card">
                           <h4>Az alábbi videó bemutatja, hol találja irodánkat:</h4>
                           <div class="video-container">
                                <video class="video" controls>
                                    <source src="media/videos/video_SZTE.mp4" type="video/mp4">
                                </video>
                           </div>
                       </div>
                       <div class="break"></div>
                       <div class="card">
                           <h4>Vak és gyengénlátó felhasználóinkat az alább indítható hanganyaggal próbáljuk segíteni irodánk helyszíni beazonosításában.</h4>
                           <div class="audio-container">
                             <audio controls>
                                 <source src="media/audio/hangfile.mp3" type="audio/mp3">
                             </audio>
                           </div>
                       </div>
                       <div class="break"></div>
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