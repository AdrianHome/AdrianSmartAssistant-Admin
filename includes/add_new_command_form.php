

<h2>Add New Command</h2>
<br>


<form action="includes/add_new_command.php" method="post">

    <input type="hidden" name="language_id" value="<?php echo $language_id; ?>">

    <?php


    // get the available locations
    $sql = "
SELECT
locations.id,
language_locations.description as name
FROM
language_locations

INNER JOIN locations
ON language_locations.language_id = :bind_language
AND language_locations.location_id = locations.id
";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':bind_language', $language_id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e) {

        // the database query was not successful so show the error
        die($e->getMessage());
    }
    ?>

    <h3>Location</h3>
    <select name="location_id">
        <?php
        foreach($result as $key => $value){

            ?>
            <option value="<?php echo $value['id'] ?>"><?php echo $value['name'];?></option>
            <?php
        }
        ?>
    </select><i class="icon-plus-sign" data-value="location"></i>
    <br>
    <br>





    <?php
    // get the available object
    $sql = "
SELECT
objects.id,
language_objects.description as name
FROM
language_objects

INNER JOIN objects
ON language_objects.language_id = :bind_language
AND language_objects.object_id = objects.id
";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':bind_language', $language_id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e) {

        // the database query was not successful so show the error
        die($e->getMessage());
    }
    ?>

    <h3>Object</h3>
    <select name="object_id">
        <?php
        foreach($result as $key => $value){

            ?>
            <option value="<?php echo $value['id'] ?>"><?php echo $value['name'];?></option>
            <?php
        }
        ?>
    </select><i class="icon-plus-sign" data-value="object"></i>
    <br>
    <br>





    <?php
    // get the available methods
    $sql = "
SELECT
methods.id,
language_methods.description as name
FROM
language_methods

INNER JOIN methods
ON language_methods.language_id = :bind_language
AND language_methods.method_id = methods.id
";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':bind_language', $language_id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e) {

        // the database query was not successful so show the error
        die($e->getMessage());
    }
    ?>

    <h3>Method</h3>
    <select name="method_id">
        <?php
        foreach($result as $key => $value){

            ?>
            <option value="<?php echo $value['id'] ?>"><?php echo $value['name'];?></option>
            <?php
        }
        ?>
    </select><i class="icon-plus-sign" data-value="method"></i>
    <br>
    <br>





    <?php
    // get the available actions
    $sql = "
SELECT
actions.id,
language_actions.description as name
FROM
language_actions

INNER JOIN actions
ON language_actions.language_id = :bind_language
AND language_actions.action_id = actions.id
";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':bind_language', $language_id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e) {

        // the database query was not successful so show the error
        die($e->getMessage());
    }
    ?>

    <h3>Actions</h3>
    <select name="action_id">
        <?php
        foreach($result as $key => $value){

            ?>
            <option value="<?php echo $value['id'] ?>"><?php echo $value['name'];?></option>
            <?php
        }
        ?>
    </select><i class="icon-plus-sign" data-value="action"></i>
    <br>
    <br>





    <?php
    // get the available descriptions
    $sql = "
SELECT
descriptions.id,
language_descriptions.description as name
FROM
language_descriptions

INNER JOIN descriptions
ON language_descriptions.language_id = :bind_language
AND language_descriptions.description_id = descriptions.id
";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':bind_language', $language_id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e){

        // the database query was not successful so show the error
        die($e->getMessage());
    }
    ?>

    <h3>Descriptions</h3>
    <select name="description_id">
        <?php
        foreach($result as $key => $value){

            ?>
            <option value="<?php echo $value['id'] ?>"><?php echo $value['name'];?></option>
            <?php
        }
        ?>
    </select><i class="icon-plus-sign" data-value="description"></i>
    <br>
    <br>





<?php
// get the available module functions
$sql = "
SELECT
`id`,
`module`,
`function`,
`params`
FROM
module_functions
";

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
catch(PDOException $e) {

    // the database query was not successful so show the error
    die($e->getMessage());
}
?>

<h3>Module functions</h3>
<select name="module_function_id">
    <?php
    foreach($result as $key => $value){

        ?>
        <option value="<?php echo $value['id'] ?>"><?php
        echo "{$value['module']} - {$value['function']} - {$value['params']}";?></option>
        <?php
    }
    ?>
</select><i class="icon-plus-sign" data-value="module_function"></i>




<br>
<br>
<input type="submit" value="Submit">
</form>
<br>
<br>