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
                    <li><a  class="active" href="regisztracio.php">Regisztráció</a></li>
                    <li><a href="bejelentkezes.php"><span class=" fa fa-sign-in fa-10x"></span>Bejelentkezés</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <div class="column side"></div>
            <div class="column content">
                <h1>Regisztrációs űrlap</h1> <!-- itt eredetileg action-ben az eredmeny.html volt - amíg mennek a tesztek elállítottam-->
                <form action="regisztracio.php" method="POST" enctype="multipart/form-data"> <!-- POST javasolt, ha jelszót is küldünk szerver felé!! (url-ben GET esetén belekerül minden info)-->
                    <fieldset class="felhasznalo">
                        <legend>Felhasználói adatok</legend>
                        <label for="felhasznalonev">Felhasználónév</label> <!-- Az input mezőket a name="valami"-val tudjuk PHP-nak értelmezhető módon elnevezni -->
                        <input type="text" id="felhasznalonev" name="username"> <!-- A változók nevét angolul jelöljük az egyértelműség kedvéért-->
                        <label for="jelszo">Jelszó</label>
                        <input type="password" id="jelszo" name="password">
                        <label for="jelszo">Jelszó újra</label>
                        <input type="password" id="jelszo" name="password2">
                        <br>
                        <label for="image">Profilkép</label>
                        <input type="file" id="image" name="image">
                        <br>
                        <div>
                            <h4 class="felsorolas">Kötelezően kitöltendő mezők:</h4>
                            <p class="felteltelek-sorai"><strong class="felteltelek-sorai-kezdes">Felhasználónév:</strong> legalább 5 karakter hosszú, tartalmazhat kis és nagybetűket.</p>
                            <p class="felteltelek-sorai"><strong class="felteltelek-sorai-kezdes">Jelszó:</strong> legalább 6 karakter hosszú, tartalmazzon betűt és számot egyaránt.</p>
                            <p class="felteltelek-sorai"><strong class="felteltelek-sorai-kezdes">Testsúly és magasság:</strong> nem lehet üres, sem nulla.</p>
                            <p class="felteltelek-sorai"><strong class="felteltelek-sorai-kezdes">Nem:</strong> kötelezően választandó.</p>
                        </div>

                    </fieldset>
                    <fieldset class="egeszsegugy">
                        <legend>Egészségügyi adatok</legend>
                        <label for="eletkor">Életkor (év)</label>
                        <input type="number"  min="0" id="eletkor" name="age">
                        <fieldset>
                            <legend>Nem</legend>
                            <input type="radio" id="no" name="gender" value="no"
                                   checked/>
                            <label for="no">Nő</label>

                            <input type="radio" id="ferfi" name="gender"
                                   value="ferfi" />
                            <label for="ferfi">Férfi</label>
                        </fieldset>
                        <label for="testsuly">Testsúly (kg)</label>
                        <input type="number" min="0" id="testsuly" name="weight">
                        <br>
                        <label for="magassag">Magasság (cm)</label>
                        <input type="number" min="0" id="magassag" name="height">
                        <br>
                        <fieldset>
                            <legend>Kórelőzmény</legend>
                            <input type="checkbox" id="magasvernyomas" name="disorders[]" value="ht"/>
                            <label for="magasvernyomas">Magas vérnyomás</label>
                            <br>
                            <input type="checkbox" id="daganat" name="disorders[]" value="cc"/>
                            <label for="daganat">Daganatos betegség</label>
                            <br>
                            <input type="checkbox" id="cukorbetegseg" name="disorders[]" value="dm"/>
                            <label for="cukorbetegseg">Cukorbetegség</label>
                            <br>
                            <input type="checkbox" id="autoimmun" name="disorders[]" value="aid"/>
                            <label for="autoimmun">Autoimmun betegség</label>
                        </fieldset>
                    </fieldset>
                    <div class="button-container">
                        <input type="reset" value="Visszaállítás alaphelyzetbe">
                        <button class="button" type="submit" name="signup" value="Regisztráció">
                            <span>Regisztráció</span>
                        </button>
                    </div>
                </form>
                <div class="response-container">
                <?php // szúrjuk be a registration class-t

                    use classes\Registration;

                    require_once 'classes/Registration.php'; // ide bedobjuk a classt

                    if ($_SERVER["REQUEST_METHOD"] === "POST") {
                        $registration = new Registration($_POST,$_FILES);
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