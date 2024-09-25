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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="szerzők" content="Dr. Nébl Annamária, Ádám Róbert" />
    <meta name="description" content="Főoldal" />
    <meta name="keywords" content="szűrővizsgálat, rákszűrés" />
    <title>Főoldal</title>
    <link rel="icon" href="media/images/kereszt.jpg" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/index_oldal.css">
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
                    <li><a class="active" href="index.php">Főoldal</a></li>
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
                    <h1>Üdvözöljük!</h1>
                    <div class="flex-container">
                        <div class="card">
                            <img id="vernyomas" src="media/images/ferfi_vernyomas.jpg" alt="Vérnyomás mérés" title="Férfi vérnyomás mérése" />
                        </div>
                        <div class="card">
                            <div class="card-container">
                                <h4>A megelőzés, mint a rák ellenszere &#x1F9EA;</h4>
                            <p>Sokan nem gondolnák, de az időben diagnosztizált daganat, kóros elváltozás <em><strong>életeket menthet.</strong></em> Legtöbb esetben azonban akkor jelentkeznek tünetek, <em>amikor már korlátozott lehetőségek vannak a kezelésre.</em></p>
                            </div>
                        </div>
                        <div class="break"></div>
                        <div class="card">
                            <div class="card-container">
                                <h4> Segítünk Önnek </h4>
                                <p>Weboldalunk azt a célt szolgálja, hogy kapaszkodót nyújtson azoknak az embereknek, akik az életkoruknak, nemüknek leginkább javasolt szűrővizsgálatot szeretnék elvégeztetni.</p>
                            </div>
                        </div>
                        <div class="card">
                            <img src="media/images/no_olvas.jpg" alt="olvasó nő" title="olvasó nő"/>
                        </div>
                        <div class="break"></div>
                        <div class="card">
                            <div class="regisztracio">
                                <p>Ahhoz, hogy kiderítse, csupán az alábbiakra lesz szükség:</p>
                                <ul class="lista">
                                    <li>Nyissa meg a regisztrációs felületet &#x1F5A5;</li>
                                    <li>Regisztráljon életkorával, illetve az űrlapban megadandó specifikációkkal &#x1F4CB;</li>
                                    <li>Jelentkezzen be, és kérdezze le a személyreszabott szűrővizsgálatok listáját &#x2705;</li>
                                </ul>
                            </div>
                            <?php
                            if(!isset($_SESSION['username'])) {
                                // Ha be vagyunk jelentkezve, akkor ne tudjunk átmenni reg-re - menjünk admin, vagy profil felületre
                                echo '<div class="button-container">';
                                echo '<a class="button-registration" href="regisztracio.php">Regisztráció</a>';
                                echo '</div>';
                            } else if ($_SESSION['role'] == 1) {
                                echo '<div class="button-container">';
                                echo '<a class="button-registration" href="admin.php">Regisztráció</a>';
                                echo '</div>';
                            } else {
                                echo '<div class="button-container">';
                                echo '<a class="button-registration" href="profil.php">Regisztráció</a>';
                                echo '</div>';
                            }
                            ?>
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