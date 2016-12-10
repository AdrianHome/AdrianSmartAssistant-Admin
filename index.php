<?php
/**
 * Created by PhpStorm.
 * User: jamiedeakin
 * Date: 14/09/2016
 * Time: 22:05
 */

include('config.php');

// get the language parameter
$language_id = (isset($_GET['language-id']) ? (int)$_GET['language-id'] : 1)
?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="js/index.js"></script>
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body data-language-id="<?php echo $language_id; ?>">

<br>
<br>
<br>
<br>

<?php
// connect to the database
try {
    $conn = new PDO("mysql:host=localhost;dbname=" . DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    // the database connection was not successful so show the error
    echo $e->getMessage();
}


include('includes/show_language_options.php');
?>

<br>
<br>
<br>
<br>

<?php
include('includes/show_existing_commands.php');
?>

<br>
<br>
<br>
<br>

<?php
include('includes/add_new_command_form.php');
?>

<br>
<br>
<br>
<br>
</body>
</html>
<script>

    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    };

    var message = getUrlParameter('message');

    if(typeof message !== 'undefined'){

        alert(message.replace(/\+/g, ' '));
    }

</script>