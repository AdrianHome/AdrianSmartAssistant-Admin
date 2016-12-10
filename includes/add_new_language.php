<?php

include('../config.php');



$str_language = $_POST['value'];

if(empty($str_language)){

    die("No language was received");
}



// connect to the database
try {
    $conn = new PDO("mysql:host=localhost;dbname=" . DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    // the database connection was not successful so show the error
    echo "Failed to connect to the db <br>";
    die($e->getMessage());
}



$sql = "
INSERT INTO
languages
(`language`)
VALUES
(:str_language)
ON DUPLICATE KEY UPDATE
`id`   = LAST_INSERT_ID(id),
`language` = :str_language
";

try {
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':str_language', $str_language);
    $stmt->execute();
}
catch(PDOException $e) {

    // the database query was not successful so show the error
    echo "Error creating {$str_language} language<br>";
    die($e->getMessage());
}



$message = "{$str_language} language added successfully";


header("Location: /" . strstr(ltrim($_SERVER['REQUEST_URI'], "/"), "/", true) . "/index.php?message=" . urlencode($message));