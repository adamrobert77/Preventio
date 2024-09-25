<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="szerzők" content="Dr. Nébl Annamária, Ádám Róbert" />
        <meta name="description" content="Bejelentkezés" />
        <title>Bejelentkezés</title>
        <link rel="icon" href="media/images/kereszt.jpg" />
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="css/navbar.css">
        <link rel="stylesheet" href="css/bejelentkezes.css">
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
                        <li><a href="regisztracio.php">Regisztráció</a></li>
                        <li><a class="active" href="bejelentkezes.php"><span class=" fa fa-sign-in fa-10x"></span>Bejelentkezés</a></li>
                    </ul>
                </nav>
            </header>
            <main>
                <div class="column side"></div>
                <div class="column content">
                    <h2>Bejelentkezés</h2>
                    <?php
                    if (isset($_GET['error']) ) {
                        $error = $_GET['error'];
                        echo "<p>Hiba történt: " . htmlspecialchars($error) . "</p>";
                    } else if (isset($_GET['message']) ) {
                        $message = $_GET['message'];
                        echo "<p>Üzenet: " . htmlspecialchars($message) . "</p>";
                    }
                    ?>
                    <div class="flex-container">
                           <div class="card">
                                   <img id="login-pic" src="media/images/login.jpg" alt="Login picture" title="Formalap ellenőrzés" />
                           </div>
                            <div class="card">
                                    <form action="process_login.php" method="POST"
                                          class="form-container">
                                        <label for="username">Felhasználónév:</label>
                                        <br>
                                        <input type="text" id="username" name="username">
                                        <br>
                                        <label for="password">Jelszó:</label>
                                        <br>
                                        <input type="password" id="password" name="password">
                                        <br>
                                        <input type="submit" value="Bejelentkezés" name="login">
                                    </form>

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