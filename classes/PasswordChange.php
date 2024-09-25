<?php

namespace classes;

use Exception;

class PasswordChange
{
    public function __construct()
    {
    }

    /**
     * @throws Exception
     */
    public function changePassword($username, $currentPassword, $newPassword, $newPassword2): void
    {
        // csekkoljuk az inputokat
        if (empty($username) || empty($currentPassword) || empty($newPassword) || empty($newPassword2)) {
            throw new Exception("Minden mező kitöltése kötelező.");
        }

        if ($newPassword !== $newPassword2) {
            throw new Exception("Az új jelszavak nem egyeznek meg.");
        }

        // csekkoljuk, hogy jó-e a megadott jelenlegi jelszó
        if (!$this->verifyCurrentPassword($username, $currentPassword)) {
            throw new Exception("A megadott jelenlegi jelszó helytelen.");
        }

        // Validate the new password format
        if (!$this->isValidPasswordFormat($newPassword)) {
            throw new Exception("Az új jelszó legalább 6 karakter hosszú kell legyen, és tartalmazzon legalább egy betűt és egy számot.");
        }

        // Update the user's password
        $this->updatePassword($username, $newPassword);
    }

    private function verifyCurrentPassword($username, $password): bool
    {

        $fileContents = file_get_contents("data/login-data.json");
        if ($fileContents === false) {
            throw new \Exception("Nem lehet beolvasni a login file-t.");
        }

        $existingAccounts = json_decode($fileContents, true);
        if ($existingAccounts === null) {
            throw new \Exception("Nem sikerült dekódolni a JSON file-t.");
        }

        foreach ($existingAccounts as $account) {
            if (array_key_exists("username", $account) &&
                $account["username"] == $username &&
                password_verify($password, $account["password"])) {
                return true;
            }
        }
        return false;
    }

    private function isValidPasswordFormat($password): bool
    {
        return strlen($password) >= 6 && preg_match('/[A-Za-z]/', $password) && preg_match('/\d/', $password);
    }

    private function updatePassword($username, $newPassword): void
    {
        $file = "data/login-data.json";

        // nyissuk meg a file-t
        $fileContents = file_get_contents($file);
        if ($fileContents === false) {
            throw new Exception("Nem lehet beolvasni a login file-t.");
        }

        // decode-oljuk a json-t tömbre
        $existingAccounts = json_decode($fileContents, true);
        if ($existingAccounts === null) {
            throw new Exception("Nem sikerült dekódolni a JSON file-t.");
        }

        // keressük meg a felhasználót, és frissítsük a jelszavát
        foreach ($existingAccounts as &$account) {
            if ($account['username'] === $username) {
                // új jelszó beírása hash-elt módon
                $account['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
                break;
            }
        }

        // kódoljuk vissza json formátumba a tömböt
        $updatedAccounts = json_encode($existingAccounts, JSON_PRETTY_PRINT);
        if ($updatedAccounts === false) {
            throw new Exception("Nem sikerült kódolni a JSON file-t.");
        }

        // json file visszaírása
        if (file_put_contents($file, $updatedAccounts) === false) {
            throw new Exception("Nem sikerült írni a login file-ba.");
        }
    }
}