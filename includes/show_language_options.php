<?php

// get the available languages
$sql = "
SELECT
*
FROM
languages
";

try {
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
catch(PDOException $e)
{
// the database query was not successful so shwo the error
echo $e->getMessage();
}
?>

<h2>Language</h2>
<br>
<select id="language_select">
    <?php
    foreach($result as $key => $value){

        ?>
        <option value="<?php echo $value['id'];?>" <?php
        echo ($value['id'] == $language_id) ? "selected" : "";
        ?>><?php echo ucfirst($value['language']); ?></option>
        <?php
    }
    ?>
</select><i class="icon-plus-sign" data-value="language"></i>