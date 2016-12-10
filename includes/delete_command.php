<?php

include('../config.php');



(isset($_GET['l_o_m_a_d_id'])) ?
    $lomad_id = $_GET['l_o_m_a_d_id'] :
    die('l_o_m_a_d_id id not received');




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






// create a new location object relationship
$sql = "
DELETE
FROM
location_object_method_actions_descriptions
WHERE
id = :lomad_id
";

try {
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':lomad_id', $lomad_id);
    $stmt->execute();
}
catch(PDOException $e) {

    // the database query was not successful so show the error
    echo "Error deleting command <br>";
    die($e->getMessage());
}



header( 'Location: /' . strstr(ltrim($_SERVER['REQUEST_URI'], "/"), "/", true) . '/index.php?message=command-deleted-successfully' ) ;