<?php

include('../config.php');



$str_description = $_POST['description'];
$str_module      = $_POST['module'];
$str_function    = $_POST['function'];
$str_params      = $_POST['params'];

if(empty($str_description)){

    die("No description was received");
}
if(empty($str_module)){

    die("No module name was received");
}
if(empty($str_function)){

    die("No function name was received");
}
if(empty($str_params) && $str_params !== ""){

    die("No parameters was received");
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
module_functions
(`description`, `module`, `function`, `params`)
VALUES
(:str_description, :str_module, :str_function, :str_params)
ON DUPLICATE KEY UPDATE
`id`          = LAST_INSERT_ID(id),
`description` = :str_description,
`module`      = :str_module,
`function`    = :str_function,
`params`      = :str_params
";

try {
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':str_description', $str_description);
    $stmt->bindValue(':str_module', $str_module);
    $stmt->bindValue(':str_function', $str_function);
    $stmt->bindValue(':str_params', $str_params);
    $stmt->execute();
}
catch(PDOException $e) {

    // the database query was not successful so show the error
    echo "Error adding new module function<br>";
    die($e->getMessage());
}



$message = "new module function added successfully";


header("Location: /" . strstr(ltrim($_SERVER['REQUEST_URI'], "/"), "/", true) . "/index.php?message=" . urlencode($message));