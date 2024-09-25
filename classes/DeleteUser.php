<?php

namespace classes;

use Exception;

/**
 * @throws Exception
 */
class DeleteUser
{


    public function __construct()
    {
    }


    /**
     * @throws Exception
     */
    public function deleteUser($userToDelete): void
    {

        if($userToDelete === null) {
            throw new Exception("A törlés nem sikerült - a törlendő user értéke null - kérjük jelezze levélben rendszergazdánknak.");
        }

        // nézzük, meg tudjuk-e nyitni a file-t
        $fileContents = file_get_contents(__DIR__ .'/../data/login-data.json');
        if ($fileContents === false) {
            throw new Exception("Nem lehet beolvasni a login file-t.");
        }
        // nézzük, tudunk-e olvasni belőle
        $existingAccounts = json_decode($fileContents, true);
        if ($existingAccounts === null) {
            throw new Exception("Nem sikerült dekódolni a JSON file-t.");
        }


        $indexToRemove = null;

        // találjuk meg a törlendő account index-ét
        foreach ($existingAccounts as $index => $account) {
            if ($account['username'] === $userToDelete) {
                $indexToRemove = $index;
            }
        }

        // ha találtunk bármit, akkor indulhat a törlés
        if ($indexToRemove !== null) {
            unset($existingAccounts[$indexToRemove]);
        } else {
            throw new Exception("A törlés nem sikerült - kérjük jelezze levélben rendszergazdánknak.");
        }

        // rendezzük vissza a frissített tömböt JSON formátumba
        $updatedAccounts = json_encode($existingAccounts, JSON_PRETTY_PRINT);


        // írjuk vissza a file-ba az adatokat
        if(file_put_contents(__DIR__ .'/../data/login-data.json', $updatedAccounts) === false) {
            throw new Exception("Nem sikerült frissíteni a felhasználókat - törlés sikertelen.");
        }

    }
}