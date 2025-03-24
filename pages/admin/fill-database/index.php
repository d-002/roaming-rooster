<html>
    <head>
        <title>Database filling</title>
        <style>textarea{width:100%;height:200px}</style>
    </head>

    <body>
        <h1>WARNING: this will WIPE OUT ALL DATA from the database and create a new, clean one.</h1>
        <a href="/pages/admin/query-database">Go back to the query page</a>

        <?php
include $_SERVER["DOCUMENT_ROOT"]."/private/db.php";

function empty_database($db) {
    $q_tables = $db->query('SELECT name FROM sqlite_master WHERE type="table"');
    $tables = array();

    while ($table = $q_tables->fetch())
        array_push($tables, $table["name"]);

    $q_tables = null;

    foreach($tables as $name) {
        $query = "DELETE FROM ".$name;

        //echo "<p>".$query."</p>";
        $db->query($query);
    }
}

function pdo_type($value) {
    $type = gettype($value);
    switch($type) {
        case "string": return \SQLITE3_TEXT;
        case "integer": return \SQLITE3_INTEGER;
        case "boolean": return \SQLITE3_INTEGER;
        case "double": return \SQLITE3_FLOAT;
        default: return \SQLITE3_TEXT;
    }
}

function insert($db, $table, $values_arr) {
    // get columns
    $q_columns = $db->query("PRAGMA table_info(".$table.")");

    // build list, excluding ID
    $keys = "";
    $i = 0;
    while ($column = $q_columns->fetch()) {
        $name = $column["name"];
        if ($name === "id") continue;
        if ($i++) $keys .= ", ";
        $keys .= $name;
    }

    $values = "";
    $i = 0;
    for ($i = 0; $i < count($values_arr); $i++) {
        if ($i) $values .= ", ";
        $values .= "?";
    }

    $query = "INSERT INTO ".$table." (".$keys.") VALUES (".$values.")";
    //echo '<p>'.$query.'</p>';

    $sdmt = $db->prepare($query);

    $i = 0;
    foreach($values_arr as $_=>$value)
        $sdmt->bindValue(++$i, $value, pdo_type($value));

    $sdmt->execute();
}

function fillDatabase() {
    $db = getSecureDB();

    empty_database($db);

    // images
    insert($db, "images", array("test"));

    $db = null;
}

$state = 0; // 0: nothing sent, 1: sent command to delete, 2: done deletion, -1: aborted

if (array_key_exists("text", $_GET))
    $state = $_GET["text"] === "I understand" ? 1 : -1;
else
    $query = "";

switch($state) {
    case 0:
        echo '
<form method="GET">
    <label for="text">Type "I understand" to format the database:</label>
    <input type="text" id="text" name="text" />
    <br>
    <input type="submit" />
</form>
        ';
        break;
    case 1:
        try {
            fillDatabase();
            echo '
<p>Database successfully filled. Click <a href=".">here</a> to finish the operation.</p>';
        } catch (Exception $e) {
            echo '
<p>Error while filling:</p>
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
