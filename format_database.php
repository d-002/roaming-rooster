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

    // get list of tables to erase
    // store them in an array, then delete them, to avoid file usage exceptions
    $q_tables = $db->query('SELECT name FROM sqlite_master WHERE type="table"');
    $tables = array();

    while ($table = $q_tables->fetch())
        array_push($tables, $table["name"]);

    $q_tables = null;

    foreach($tables as $name)
        $db->query("DROP TABLE ".$name);

    $db->query("CREATE TABLE test(id integer, name text)");

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
        try {
            formatDatabase();
            echo '
<p>Database successfully formatted. Click <a href=".">here</a> to finish the operation.</p>';
        } catch (Exception $e) {
            echo '
<p>Error while deleting:</p>
<p style="color:red">'.str_replace("\n", "<br />", $e).'</p>
<p>Click <a href=".">here</a> to restart the operation.</p>';
        }
        break;
    case -1:
        echo 'Operation aborted. Click <a href=".">here</a> to try again.';
        break;
}
        ?>

    </body>
</html>
