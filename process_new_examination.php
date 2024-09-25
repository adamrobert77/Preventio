<?php

use classes\Examination;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $image = $_FILES["image"]["name"] ?? null;
    $image_tmp = $_FILES["image"]["tmp_name"] ?? null;
    $image_destination = "media/images/" . $image;
    move_uploaded_file($image_tmp, $image_destination);
    $description = $_POST["description"];
    $gender = $_POST["gender"] ?? [];
    $age = $_POST["age"] ?? [];
    $riskFactors = $_POST["riskFactors"] ?? [];

    try {

        require_once 'classes/Examination.php';
        $new_examination = new Examination($title, $image_destination, $description, $gender, $age, $riskFactors);

        $success = $new_examination->saveToJSON($new_examination, 'data/szurovizsgalatok.json');

        if ($success) {
            header("Location: uj-vizsgalat.php?success");
        }
        exit();
    } catch (Exception $e) {
        $error = urlencode($e->getMessage());
        header("Location: uj-vizsgalat.php?error=$error");
        exit();
    }
}