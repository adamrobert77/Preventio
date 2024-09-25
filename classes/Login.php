<?php

namespace classes;

class Login
{
    /**
     * @throws \Exception
     */
    public function login($username, $password): array
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

                return ["username" => $username, "role" => $account["role"]];
            }
        }

        throw new \Exception("Sikertelen bejelentkezés!");
    }
}