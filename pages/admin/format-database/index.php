<html lang="en">
    <head>
        <title>Database formatting</title>
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

    foreach($tables as $name)
        $db->query("DROP TABLE ".$name);
}

function createTables($db): void
{
    // /!\ order is important

    $db->query("CREATE TABLE images(id INTEGER PRIMARY KEY, url TEXT)");
    $db->query("CREATE TABLE themes(
        id INTEGER PRIMARY KEY,
        main_image_id INTEGER, banner_image_id INTEGER, col1 INTEGER, col2 INTEGER,
        FOREIGN KEY(main_image_id) REFERENCES images(id),
        FOREIGN KEY(banner_image_id) REFERENCES images(id)
    )");
    $db->query("CREATE TABLE users(
        id INTEGER PRIMARY KEY,
        username TEXT, display_name TEXT, password TEXT, email TEXT, verified_email BOOLEAN, phone TEXT, latitude FLOAT, longitude FLOAT, theme_id INTEGER, banned BOOLEAN,
        FOREIGN KEY(theme_id) REFERENCES themes(id)
    )");
    $db->query("CREATE TABLE roles(
        id INTEGER PRIMARY KEY,
        user_id INTEGER, role INTEGER,
        FOREIGN KEY(user_id) REFERENCES users(id)
    )");
    $db->query("CREATE TABLE balances(
        id INTEGER PRIMARY KEY, user_id INTEGER, amount FLOAT,
        FOREIGN KEY(user_id) REFERENCES users(id)
    )");
    $db->query("CREATE TABLE conversations(id INTEGER PRIMARY KEY, user1 INTEGER, user2 INTEGER, subject TEXT, closed BOOLEAN)");
    $db->query("CREATE TABLE notifications(
        id INTEGER PRIMARY KEY,
        user_id INTEGER, conversation_id INTEGER, text TEXT, time TIMESTAMP,
        FOREIGN KEY(user_id) REFERENCES users(id),
        FOREIGN KEY(user_id) REFERENCES conversation(id)
    )");
    $db->query("CREATE TABLE messages(
        id INTEGER PRIMARY KEY,
        user_id INTEGER, conversation_id INTEGER, message TEXT, time TIMESTAMP,
        FOREIGN KEY(user_id) REFERENCES users(id),
        FOREIGN KEY(user_id) REFERENCES conversation(id)
    )");
    $db->query("CREATE TABLE conversations_requests(
        id INTEGER PRIMARY KEY,
        sender INTEGER, receiver INTEGER, is_service_inquiry BOOLEAN,
        FOREIGN KEY(sender) REFERENCES users(id),
        FOREIGN KEY(sender) REFERENCES users(id))");
    $db->query("CREATE TABLE tags(id INTEGER PRIMARY KEY, name TEXT)");
    $db->query("CREATE TABLE tags_users_join(
        id INTEGER PRIMARY KEY,
        tag_id INTEGER, user_id INTEGER,
        FOREIGN KEY(tag_id) REFERENCES tags(id),
        FOREIGN KEY(user_id) REFERENCES users(id)
    )");
    $db->query("CREATE TABLE tags_services_join(
        id INTEGER PRIMARY KEY,
        tag_id INTEGER, service_id INTEGER,
        FOREIGN KEY(tag_id) REFERENCES tags(id),
        FOREIGN KEY(service_id) REFERENCES services(id)
    )");
    $db->query("CREATE TABLE orders(
        id INTEGER PRIMARY KEY,
        buyer_id INTEGER, seller_id INTEGER, sub_service_id INTEGER, amount FLOAT,
        FOREIGN KEY(buyer_id) REFERENCES users(id),
        FOREIGN KEY(seller_id) REFERENCES users(id)
    )");
    $db->query("CREATE TABLE ratings(
        id INTEGER PRIMARY KEY,
        sub_service_id INTEGER, user_id INTEGER, rating FLOAT, comment TEXT,
        FOREIGN KEY(sub_service_id) REFERENCES sub_services(id),
        FOREIGN KEY(user_id) REFERENCES users(id)
    )");
    $db->query("CREATE TABLE services(
        id INTEGER PRIMARY KEY,
        user_id INTEGER, theme_id INTEGER, title TEXT, description TEXT, latitude FLOAT, longitude FLOAT,
        FOREIGN KEY(user_id) REFERENCES users(id),
        FOREIGN KEY(theme_id) REFERENCES themes(id)
    )");
    $db->query("CREATE TABLE sub_services(
        id INTEGER PRIMARY KEY,
        service_id INTEGER, availability INTEGER, title TEXT, description TEXT, price FLOAT,
        FOREIGN KEY(service_id) REFERENCES services(id)
    )");
    $db->query("CREATE TABLE admin_logs(
        id INTEGER PRIMARY KEY,
        user_id INTEGER, time TIMETSAMP, message TEXT,
        FOREIGN KEY(user_id) REFERENCES users(id)
    )");
}

function formatDatabase() {
    $db = getSecureDB();

    // get list of tables to erase
    // store them in an array, then delete them, to avoid file usage exceptions
    empty_database($db);

    createTables($db);

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
            formatDatabase();
            echo '
<p>Database successfully formatted. Click <a href=".">here</a> to finish the operation.</p>';
        } catch (Exception $e) {
            echo '
<p>Error while formatting:</p>
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
