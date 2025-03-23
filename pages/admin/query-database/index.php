<html>
    <head>
        <title>Manual database prompts</title>
        <style>textarea{width:100%}</style>
    </head>

    <body>
        <h1>WARNING: this is NOT for use in production.</h1>
        <a href="/pages/admin/format-database">/!\ SENSITIVE - go to the format database page</a>

        <?php
include $_SERVER["DOCUMENT_ROOT"]."/private/db.php";
$db = getSecureDB();
        ?>

        <form action="" method="GET">
            <label for="query">Enter query here:</label>
            <input type="text" id="query" name="query" />
            <br>
            <input type="submit" />
        </form>

        <?php
if (array_key_exists("query", $_GET))
    $query = $_GET["query"];
else
    $query = "";
        ?>

        <p>Query: <?php echo $query ?></p>
        <p>Dumped query result:</p>
        <textarea style="height:200px"><?php
if ($query == "")
    echo "[no query]";
else {
    $res = null;
    try {
        $res = $db->query($query);
    }
    catch (Exception $e) {
        echo "Failed query: " . $e->getMessage();
    }

    if ($res != null)
        try {
            var_dump($res->fetchAll());
        }
        catch (Exception $e) {
            echo "Could not var_dump, error: ".$e;
        }

    $res = null;
}
        ?></textarea>

        <p>Full database contents:</p>
        <textarea style="height:500px"><?php
// get all tables
try {
    $q_tables = $db->query('SELECT name FROM sqlite_master WHERE type="table"');

    while ($table = $q_tables->fetch()) {
        $table_name = $table["name"];

        echo "Listing table ".$table_name.":\n  Columns:";

        $columns = array();

        $q_columns = $db->query("PRAGMA table_info(".$table_name.")");
        while ($column = $q_columns->fetch()) {
            $column_name = $column["name"];

            array_push($columns, $column_name);
            echo " ".$column_name."=".$column["type"];
        }

        echo "\n  Listing entries:\n";

        $q_entries = $db->query("SELECT * FROM ".$table_name);
        while ($entry = $q_entries->fetch()) {
            echo "    ";
            foreach ($columns as $column)
                echo $column."=".$entry[$column]." ";
            echo "\n";
        }

        echo "\n";
    }
}
catch (Exception $e) {
    echo "Failed to read contents, error: ".$e;
}

        ?></textarea>
    </body>
</html>
