<?php

include('../config.php');



$str_value_type  = $_GET['value_type'];
$str_value       = $_POST['value'];
$int_language_id = (int)$_GET['language_id'];

if(empty($str_value_type)){

    die("No value type was received");
}

if(empty($str_value)){

    die("No value was received");
}

if(empty($int_language_id)){

    die("No language id was received");
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




// add new value
$value_column = ($str_value_type == 'description') ? '`description`' : '`name`';

$sql = "
INSERT INTO
{$str_value_type}s
({$value_column})
VALUES
(:str_name)
ON DUPLICATE KEY UPDATE
`id`   = LAST_INSERT_ID(id),
{$value_column} = :str_name
";

try {
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':str_name', $str_value);
    $stmt->execute();
}
catch(PDOException $e) {

    // the database query was not successful so show the error
    echo "Error creating {$str_value_type} value<br>";
    die($e->getMessage());
}

// get the value id
$value_id = (int)$conn->lastInsertId();





// add new language value
$sql = "
INSERT INTO
language_{$str_value_type}s
(`{$str_value_type}_id`,
`language_id`,
`description`)
VALUES
(:value_id,
:int_language_id,
:str_value)
ON DUPLICATE KEY UPDATE
`{$str_value_type}_id` = :value_id,
`language_id` = :int_language_id,
`description` = :str_value
";

try {
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':value_id', $value_id, PDO::PARAM_INT);
    $stmt->bindParam(':int_language_id', $int_language_id, PDO::PARAM_INT);
    $stmt->bindParam(':str_value', $str_value);
    $stmt->execute();
}
catch(PDOException $e) {

    // the database query was not successful so show the error
    echo "Error creating {$str_value_type} language value<br>";
    die($e->getMessage());
}



$message = "{$str_value_type} '{$str_value}' added successfully";


header("Location: /ADRIAN-local-application/index.php?message=" . urlencode($message));