<html>
    <head>
        <title>Database formatting</title>
        <style>textarea{width:100%;height:200px}</style>
    </head>

    <body>
        <h1>WARNING: this will WIPE OUT ALL DATA from the database and create a new, clean one.</h1>

        <?php
function getSecureDB() {
    $db = new PDO("sqlite:test.db");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_PERSISTENT, true);

    return $db;
}

function formatDatabase() {
    $db = getSecureDB();

    $db = null;
}
        ?>

        <?php
$state = 0; // 0: nothing sent, 1: sent command to delete, 2: done deletion, -1: aborted

if (array_key_exists("text", $_GET))
    $state = $_GET["text"] == "I understand" ? 1 : 1;
else
    $query = "";

switch($state) {
    case 0:
        echo '
<form action="." method="GET">
    <label for="text">Type "I understand" to format the database:</label>
    <input type="text" id="text" name="text" />
    <br>
    <input type="submit" />
</form>
        ';
        break;
    case 1:
        formatDatabase();
        echo '
<p>Database formatted. Click here to finish the operation:</p>
<a href=".">Finish</a>';
        break;
    case -1:
        echo 'Operation aborted. Click <a href=".">here</a> to try again.';
        break;
}
        ?>

    </body>
</html>
