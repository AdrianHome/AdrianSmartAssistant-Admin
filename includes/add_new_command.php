<?php

include('../config.php');



(isset($_POST['language_id'])) ?
    $language_id = $_POST['language_id'] :
    die('language id not received');

(isset($_POST['location_id'])) ?
    $location_id = $_POST['location_id'] :
    die('location id not received');

(isset($_POST['object_id'])) ?
    $object_id = $_POST['object_id'] :
    die('object id not received');

(isset($_POST['description_id'])) ?
    $description_id = $_POST['description_id'] :
    die('description id not received');

(isset($_POST['method_id'])) ?
    $method_id = $_POST['method_id'] :
    die('method id not received');

(isset($_POST['action_id'])) ?
    $action_id = $_POST['action_id'] :
    die('action id not received');

(isset($_POST['module_function_id'])) ?
    $module_function_id = $_POST['module_function_id'] :
    die('module function id not received');




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
INSERT INTO
location_objects
(location_id, object_id)
VALUES
(:location_id, :object_id)
ON DUPLICATE KEY UPDATE
id          = LAST_INSERT_ID(id),
location_id = :location_id,
object_id   = :object_id
";

try {
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':location_id', $location_id);
    $stmt->bindValue(':object_id', $object_id);
    $stmt->execute();
}
catch(PDOException $e) {

    // the database query was not successful so show the error
    echo "Error creating location object relationship <br>";
    die($e->getMessage());
}

// get the location object id
$location_object_id = $conn->lastInsertId();




// create a new method action relationship
$sql = "
INSERT INTO
method_actions
(method_id, action_id, module_function_id)
VALUES
(:method_id, :action_id, :module_function_id)
ON DUPLICATE KEY UPDATE
method_id  = :method_id,
action_id  = :action_id,
command_id = :module_function_id
";

try {
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':method_id', $method_id);
    $stmt->bindValue(':action_id', $action_id);
    $stmt->bindValue(':module_function_id', $module_function_id);
    $stmt->execute();
}
catch(PDOException $e) {

    // the database query was not successful so show the error
    echo "Error creating method action relationship <br>";
    die($e->getMessage());
}







// create the location object method actions descriptions relationship
$sql = "
INSERT INTO
location_object_method_actions_descriptions
(location_object_id, method_id, action_id, description_id)
VALUES
(:location_object_id, :method_id, :action_id, :description_id)
ON DUPLICATE KEY UPDATE
location_object_id = :location_object_id,
method_id          = :method_id,
action_id          = :action_id,
description_id     = :description_id
";

try {
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':location_object_id', $location_object_id);
    $stmt->bindValue(':method_id', $method_id);
    $stmt->bindValue(':action_id', $action_id);
    $stmt->bindValue(':description_id', $description_id);
    $stmt->execute();
}
catch(PDOException $e) {

    // the database query was not successful so show the error
    echo "Error creating location object method action description relationship <br>";
    die($e->getMessage());
}




header('Location: /ADRIAN-local-application/index.php?message=command-added-successfully');