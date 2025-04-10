<?php
// check if user is authorized
include $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";
root_include("/pages/admin/common-utils.php");

quickAdminCheck();
?>

<html lang="en">
<head>
    <title>Database filling</title>
    <style>textarea {
            width: 100%;
            height: 200px
        }</style>
</head>

<body>
<h1>WARNING: this will WIPE OUT ALL DATA from the database and create a new, clean one.</h1>
<a href="/pages/admin/query-database">Go back to the query page</a>

<?php
root_include("/utils/time.php");

function empty_database($db): void
{
    $q_tables = $db->query('SELECT name FROM sqlite_master WHERE type="table"');
    $tables = array();

    while ($table = $q_tables->fetch())
        $tables[] = $table["name"];

    $q_tables = null;

    foreach ($tables as $name) {
        $query = "DELETE FROM " . $name;

        $db->query($query);
    }
}

function pdo_type($value): int
{
    $type = gettype($value);
    return match ($type) {
        "boolean", "integer" => PDO::PARAM_INT,
        default => PDO::PARAM_STR,
    };
}

function insert($db, $table, $values_arr): void
{
    // get columns
    $q_columns = $db->query("PRAGMA table_info(" . $table . ")");

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
    for ($i = 0; $i < count($values_arr); $i++) {
        if ($i) $values .= ", ";
        $values .= "?";
    }

    $query = "INSERT INTO " . $table . " (" . $keys . ") VALUES (" . $values . ")";
    //echo '<p>'.$query.'</p>';

    $sdmt = $db->prepare($query);

    $i = 0;
    foreach ($values_arr as $value)
        $sdmt->bindValue(++$i, $value, pdo_type($value));

    $sdmt->execute();
}

function fillDatabase(): void
{
    $db = getSecureDB();

    empty_database($db);

    // images
    insert($db, "images", array("/assets/images/dummy/flower1.png"));
    insert($db, "images", array("/assets/images/dummy/flower2.png"));
    insert($db, "images", array("/assets/images/dummy/flower3.png"));
    insert($db, "images", array("/assets/images/dummy/food1.png"));
    insert($db, "images", array("/assets/images/dummy/food2.png"));
    insert($db, "images", array("/assets/images/dummy/food3.png"));

    insert($db, "themes", array(1, 2, 0xff0000, 0x00ff00));
    insert($db, "themes", array(3, 4, 0xffffff, 0x0000ff));
    insert($db, "themes", array(5, 6, 0x000000, 0x808080));

    insert($db, "users", array("hello", "Hello", password_hash("hello", PASSWORD_DEFAULT), "hello@hello.com", false, "+012345", .42, .69, 1, false));
    insert($db, "users", array("world", "World", password_hash("world", PASSWORD_DEFAULT), "world@world.com", true, "+056789", .69, .42, 2, false));
    insert($db, "users", array("a", "a", password_hash("a", PASSWORD_DEFAULT), "a@a.com", 1, "+0", 3.14, 2.72, false, false));
    insert($db, "users", array("banned", "ImBanned", password_hash("banned", PASSWORD_DEFAULT), "im@banned.com", true, "+11111", 0, 0, 3, true));
    insert($db, "users", array("best_seller", "best_seller", password_hash("best seller", PASSWORD_DEFAULT), "seller@best.com", true, "+056989", .42, .42, 2, false));
    insert($db, "users", array("admin", "admin", password_hash("admin", PASSWORD_DEFAULT), "admin@admin.com", true, "+admin", 0, 0, 0, false));

    insert($db, "roles", array(1, 0));
    insert($db, "roles", array(1, 1));
    insert($db, "roles", array(2, 0));
    insert($db, "roles", array(2, 2));
    insert($db, "roles", array(3, 0));
    insert($db, "roles", array(4, 1));
    insert($db, "roles", array(4, 0));
    insert($db, "roles", array(5, 0));
    insert($db, "roles", array(6, 0));
    insert($db, "roles", array(6, 1));
    insert($db, "roles", array(6, 2));

    insert($db, "balances", array(1, 42.69));
    insert($db, "balances", array(2, 100));
    insert($db, "balances", array(3, 0));
    insert($db, "balances", array(3, 10));
    insert($db, "balances", array(4, 100));
    insert($db, "balances", array(5, 1000000));

    insert($db, "conversations", array(1, 2, "Untitled", false));
    insert($db, "conversations", array(1, 3, "Other", false));
    insert($db, "conversations", array(3, 4, "Closed conversation", true));

    insert($db, "notifications", array(1, 1, "notification for conversation 1", now()));
    insert($db, "notifications", array(2, 1, "notification for conversation 1 - other person", now()));
    insert($db, "notifications", array(2, 2, "notification to admin user, from conversation 2", now()));

    insert($db, "messages", array(1, 1, "this is a message", now() - 1000));
    insert($db, "messages", array(2, 1, "hello", now() - 500));
    insert($db, "messages", array(1, 1, "world", now()));
    insert($db, "messages", array(3, 2, "this is another message", now() - 1000));
    insert($db, "messages", array(4, 2, "hello", now() - 500));
    insert($db, "messages", array(3, 2, "world", now() - 100));
    insert($db, "messages", array(3, 2, "world2", now()));

    insert($db, "conversations_requests", array(4, 3, false));
    insert($db, "conversations_requests", array(3, 4, true));

    insert($db, "tags", array("flower"));
    insert($db, "tags", array("fruit"));
    insert($db, "tags", array("vegetable"));
    insert($db, "tags", array("gardening"));
    insert($db, "tags", array("organic"));

    insert($db, "tags_services_join", array(1, 1));
    insert($db, "tags_services_join", array(2, 1));
    insert($db, "tags_services_join", array(3, 1));
    insert($db, "tags_services_join", array(4, 2));
    insert($db, "tags_services_join", array(5, 3));

    insert($db, "orders", array(1, 2, 1, 10));
    insert($db, "orders", array(3, 4, 2, 20));
    insert($db, "orders", array(1, 3, 3, 30));

    insert($db, "ratings", array(1, 1, 3.5, "good"));
    insert($db, "ratings", array(2, 2, 4.5, "very good"));
    insert($db, "ratings", array(3, 3, 0, "very bad\nSecond line"));

    insert($db, "services", array(1, 1, "Selling flowers", "This service is selling flowers", .5, .5));
    insert($db, "services", array(1, 1, "Selling fruits", "This service is selling fruits", .8, .3));
    insert($db, "services", array(4, 2, "Selling fruits", "This service is selling fruits", .7, .3));
    insert($db, "services", array(4, 1, "Selling animals", "This service is selling animals", .7, .3));
    insert($db, "services", array(1, 2, "Selling vegetables", "This service is selling vegetables", .8, .9));
    insert($db, "services", array(4, 1, "Selling salads", "This service is selling salads", .4, .9));
    insert($db, "services", array(4, 3, "Selling exotic animals", "This service is selling exotic animals", .10, .9));

    insert($db, "sub_services", array(1, 10, "Selling red flowers", "this subservice is selling red flowers", 2.72));
    insert($db, "sub_services", array(1, 6, "Selling yellow flowers", "this subservice is selling yellow flowers", 3.14));
    insert($db, "sub_services", array(2, 42, "Selling blue fruits", "this subservice is selling blue fruits", 6.9));

    insert($db, "admin_logs", array(3, now(), "this is an admin log"));
    insert($db, "admin_logs", array(3, now(), "this is another admin log"));

    $db = null;
}

$state = 0; // 0: nothing sent, 1: sent command to delete, 2: done deletion, -1: aborted

if (array_key_exists("text", $_GET))
    $state = $_GET["text"] === "I understand" ? 1 : -1;
else
    $query = "";

switch ($state) {
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
<p style="color:red">' . str_replace("\n", "<br />", $e) . '</p>
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
