<html>
    <head>
        <title>Manual database prompts</title>
        <style>textarea{width:100%;height:200px}</style>
    </head>

    <body>
        <h1>WARNING: this is NOT for use in production.</h1>

        <?php
function getSecureDB() {
    $db = new PDO("sqlite:test.db");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_PERSISTENT, true);

    return $db;
}

function sendSecureQuery($db, $query) {
    try {
        return $db->query($query);
    }
    catch (Exception $e) {
        echo "Failed: " . $e->getMessage();
        return null;
    }
}

$db = getSecureDB();
    ?>

        <form action="." method="GET">
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
        <textarea><?php
if ($query == "")
    echo "[no query]";
else {
    $res = sendSecureQuery($db, $query);

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

        <p>Dumped database contents:</p>
        <textarea><?php
var_dump($db);
        ?></textarea>
    </body>
</html>
