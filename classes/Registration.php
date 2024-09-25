<?php

namespace classes;

class Registration
{

    // alapvető adattagok
    private string $user;
    private string $pass;
    private string $pass2;
    private int $age;
    private array $disorders = [];
    private string $gender;
    private int $weight;
    private int $height;
    private int $role;
    private ?string $image;

    // constructor
    public function __construct($postData,$files)
    {
        if (isset($postData["signup"])) {
            $this->user = $postData["username"];
            $this->pass = $postData["password"];
            $this->pass2 = $postData["password2"];
            $this->age = $postData["age"];
            $this->gender = $postData["gender"];
            $this->weight = $postData["weight"];
            $this->height = $postData["height"];
            $this->role = 0;                         // mindig user lesz a regisztrált tag
            if (isset($postData["disorders"])) {
                $this->disorders = $postData["disorders"];
            }
        }

        if(!empty($files["image"]["name"])){
            $image = $files["image"]["name"];
            $image_tmp = $files["image"]["tmp_name"] ?? null;
            $image_destination = 'media/images/' . $image;
            move_uploaded_file($image_tmp, $image_destination);
            $this->image = $image_destination;
        }else{
            $this->image = null;
        }
    }


    // valósítsuk meg a függvényt - végezzük el az ellenőrzéseket

    public function signUp(): void
    {
        $errors = [];


        // A felhasználónév nem lehet foglalt!
        if(strlen($this->user) < 5 || $this->user == null) {
            $errors[] = "A felhasználónévnek legalább 5 karakter hosszúnak kell lennie.";
        } else {

            $fileContents = file_get_contents("data/login-data.json");  // kiolvassuk a json file-t

            if($fileContents === false) {                                       // nézzük be tudja-e olvasni a file-t
                $errors[] = "Nem lehet beolvasni a login file-t.";
            } else {
                $accounts_read = json_decode($fileContents, true);
            }
            if($accounts_read === null) {
                $errors[] = "Nem sikerült dekódolni a JSON file-t.";
            } else {// ha idáig eljutottunk, akkor meg tudtuk nyitni a filet, és olvasni is tudtunk belőle
                foreach ($accounts_read as $account) { // vizsgáljuk, hogy van-e már ilyen felhasználó
                    // ha a kulcs nem létezik, nem futtathatjuk a kódot - ha ez nincs az if-ben warning-ot dob az oldal
                    if (array_key_exists("username", $account) && $account["username"] === $this->user) {
                        $errors[] = "A felhasználónév már foglalt.";
                        break;
                    }
                }
            }
        }


        // A jelszónak legalább 5 karakter hosszúnak kell lennie
        if (strlen($this->pass) < 6) { // vizsgáljuk, hogy milyen hosszú a jelszó
            $errors[] = "A jelszó túl rövid."; // tömbök esetében automatikusan hozzá fűzzük a következő tételt egyelőség jellel
        }

        // A jelszónak tartalmaznia kell betűt és számjegyet egyaránt
        if (!preg_match('/[A-Za-z]/', $this->pass) || !preg_match('/[0-9]/', $this->pass)) {
            $errors[] = "A jelszónak tartalmaznia kell betűt és számjegyet egyaránt.";
        }

        // A jelszónak és ell. jelszónak egyeznie kell
        if ($this->pass !== $this->pass2) {
            $errors[] = "A két jelszó nem egyezik.";
        }


        // Csak 16 éves kortól lehet regisztrálni
        if ($this->age < 16) {
            $errors[] = "Csak 16 éves kortól lehet regisztrálni.";
        }

        // Testsúlyt és magasság nem lehet 0
        if($this->weight==0 || $this->height==0 || $this->weight == null || $this->height == null) {
            $errors[] = "A testsúly és a magasság nem lehet nulla, sem üres.";
        }

        // Ha nincs hiba, írjuk ki, hogy sikeres reg, amúgy meg soroljuk fel a hibákat egymás alá
        if (count($errors) === 0) {
            echo "Sikeres regisztráció!";
        } else {
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
        }


        if(count($errors) === 0) { // ha nincs hiba, mehet a file-ba az adat
            $fileContents = file_get_contents("data/login-data.json");  // kiolvassuk a json file-t
            if ($fileContents === false) {                                       // nézzük be tudja-e olvasni a file-t
                echo "Nem lehet beolvasni a login file-t. (file-ba írásnál)";
            } else {
                $existingAccounts = json_decode($fileContents, true);
            }
            if ($existingAccounts === null) {
                echo "Nem sikerült dekódolni a JSON file-t. (file-ba írásnál";
            } else {
                $hashedPassword = password_hash($this->pass, PASSWORD_DEFAULT);
                $postData = array(
                    "username" => $this->user,
                    "password" => $hashedPassword,
                    "age" => $this->age,
                    "gender" => $this->gender,
                    "weight" => $this->weight,
                    "height" => $this->height,
                    "disorders" => $this->disorders,
                    "role" => $this->role,
                    "image" => $this->image
                );
                $existingAccounts[] = $postData;        // fűzzük hozzá az új adatokat a meglévőkhöz

                $jsonData = json_encode($existingAccounts,JSON_PRETTY_PRINT);

                $filePath = "data/login-data.json";

                file_put_contents($filePath, $jsonData);
            }
        }
    }
}