
<h2>Existing Commands</h2>

<div class="heading_holder">
    <div class="command_info">
        <h3>Action</h3>
    </div>
    <div class="command_info">
        <h3>Object</h3>
    </div>
    <div class="command_info">
        <h3>Description</h3>
    </div>
    <div class="command_info">
        <h3>Location</h3>
    </div>
    <div class="command_info">
        <h3>Method</h3>
    </div>
    <div class="command_info" style="width:80px">
        <h3>Module</h3>
    </div>
    <div class="command_info" style="width:80px">
        <h3>Func</h3>
    </div>
    <div class="command_info" style="width:240px">
        <h3>Params</h3>
    </div>
</div>


<div class="existing_commands_holder">

    <?php

    // get the existing commands set up in the db
    $sql = "
SELECT
location_object_method_actions_descriptions.id as lomad_id,
language_actions.description as action,
language_objects.description as object,
language_locations.description as location,
language_methods.description as method,
language_descriptions.description as description,

objects.id as object_id,
locations.id as location_id,
actions.id as action_id,
methods.id as method_id,
descriptions.id as description_id,
location_objects.id as location_object_id,

module_functions.module as module,
module_functions.function as function,
module_functions.params as params

FROM
location_object_method_actions_descriptions


INNER JOIN location_objects
ON location_object_method_actions_descriptions.location_object_id = location_objects.id

INNER JOIN locations
ON location_objects.location_id = locations.id

INNER JOIN language_locations
ON language_locations.location_id = locations.id

INNER JOIN objects
ON location_objects.object_id = objects.id

INNER JOIN language_objects
ON language_objects.object_id = objects.id

INNER JOIN method_actions
ON location_object_method_actions_descriptions.method_id = method_actions.method_id
AND location_object_method_actions_descriptions.action_id = method_actions.action_id

INNER JOIN methods
ON location_object_method_actions_descriptions.method_id = methods.id

INNER JOIN language_methods
ON language_methods.method_id = methods.id

INNER JOIN actions
ON method_actions.action_id = actions.id

INNER JOIN language_actions
ON language_actions.action_id = actions.id

INNER JOIN descriptions
ON location_object_method_actions_descriptions.description_id = descriptions.id

INNER JOIN language_descriptions
ON language_descriptions.description_id = descriptions.id

INNER JOIN module_functions
ON method_actions.module_function_id = module_functions.id

INNER JOIN languages
ON languages.id = :bind_language
AND language_locations.language_id = languages.id
AND language_objects.language_id = languages.id
AND language_methods.language_id = languages.id
AND language_actions.language_id = languages.id
AND language_descriptions.language_id = languages.id


    ";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':bind_language', $language_id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e)
    {
        // the database query was not successful so shwo the error
        echo $e->getMessage();
    }


    //print_r($result);
    foreach($result as $key => $value){

        ?>
        <div class="command_holder">
            <div class="command_info">
                <?php echo $value['action_id'] . ". " . $value['action']; ?>
            </div>
            <div class="command_info">
                <?php echo $value['object_id'] . ". " . $value['object']; ?>
            </div>
            <div class="command_info">
                <?php echo $value['description_id'] . ". " . $value['description']; ?>
            </div>
            <div class="command_info">
                <?php echo $value['location_id'] . ". " . $value['location']; ?>
            </div>
            <div class="command_info">
                <?php echo $value['method_id'] . ". " . $value['method']; ?>
            </div>
            <div class="module_info" style="width:80px">
                <?php echo $value['module']; ?>
            </div>
            <div class="module_info" style="width:80px">
                <?php echo $value['function']; ?>
            </div>
            <div class="module_info" style="width:220px">
                <?php echo $value['params']; ?>
            </div>
            <div class="delete_command">
                <a href="includes/delete_command.php?l_o_m_a_d_id=<?php
                echo $value['lomad_id']; ?>">
                <i class="icon-remove-sign"></i>
                </a>
            </div>
        </div>
        <?php
    }
    ?>

</div>