<html>
    <head>
        <title>Database formatting</title>
        <style>textarea{width:100%;height:200px}</style>
    </head>

    <body>
        <h1>WARNING: this will WIPE OUT ALL DATA from the database and create a new, clean one.</h1>
        <a href="/pages/admin/query-database">Go back to the query page</a>

        <?php
include $_SERVER["DOCUMENT_ROOT"]."/private/db.php";

function createTables($db) {
    // /!\ order is important

    $db->query("CREATE TABLE images(id INT PRIMARY KEY, url TEXT)");
    $db->query("CREATE TABLE themes(
        id INT PRIMARY KEY,
        main_image_id INT, banner_image_id INT, col1 INT, col2 INT,
        FOREIGN KEY(main_image_id) REFERENCES images(id),
        FOREIGN KEY(banner_image_id) REFERENCES images(id)
    )");
    $db->query("CREATE TABLE users(
        id INT PRIMARY KEY,
        username TEXT, display_name TEXT, password TEXT, email TEXT, verified_email INT, phone TEXT, latitude REAL, longitude REAL, theme_id INT, banned INT,
        FOREIGN KEY(theme_id) REFERENCES themes(id)
    )");
    $db->query("CREATE TABLE roles(
        id INT PRIMARY KEY,
        user_id INT, role INT,
        FOREIGN KEY(user_id) REFERENCES users(id)
    )");
    $db->query("CREATE TABLE balances(
        id INT PRIMARY KEY, user_id INT, amount REAL,
        FOREIGN KEY(user_id) REFERENCES users(id)
    )");
    $db->query("CREATE TABLE notifications(
        id INT PRIMARY KEY,
        user_id INT, conversation_id INT, text TEXT, time INT,
        FOREIGN KEY(user_id) REFERENCES users(id)
    )");
    $db->query("CREATE TABLE messages(
        id INT PRIMARY KEY,
        user_id INT, conversation_id INT, message TEXT, time INT,
        FOREIGN KEY(user_id) REFERENCES users(id)
    )");
    $db->query("CREATE TABLE conversations(id INT PRIMARY KEY, user1 INT, user2 INT, subject TEXT, closed INT)");
    $db->query("CREATE TABLE conversations_requests(id INT PRIMARY KEY, sender INT, receiver INT, is_service_inquiry INT)");
    $db->query("CREATE TABLE tags(id INT PRIMARY KEY, name TEXT)");
    $db->query("CREATE TABLE tags_users_join(
        id INT PRIMARY KEY,
        tag_id INT, user_id INT,
        FOREIGN KEY(tag_id) REFERENCES tags(id)
        FOREIGN KEY(user_id) REFERENCES users(id)
    )");
    $db->query("CREATE TABLE tags_services_join(
        id INT PRIMARY KEY,
        tag_id INT, service_id INT,
        FOREIGN KEY(tag_id) REFERENCES tags(id)
        FOREIGN KEY(service_id) REFERENCES services(id)
    )");
    $db->query("CREATE TABLE orders(
        id INT PRIMARY KEY,
        buyer_id INT, seller_id INT, sub_service_id INT, amount REAL,
        FOREIGN KEY(buyer_id) REFERENCES users(id)
        FOREIGN KEY(seller_id) REFERENCES users(id)
    )");
    $db->query("CREATE TABLE ratings(
        id INT PRIMARY KEY,
        sub_service_id INT, user_id INT, rating REAL, comment TEXT,
        FOREIGN KEY(sub_service_id) REFERENCES sub_services(id)
        FOREIGN KEY(user_id) REFERENCES users(id)
    )");
    $db->query("CREATE TABLE services(
        id INT PRIMARY KEY,
        user_id INT, theme_id INT, title TEXT, description TEXT, latitude REAL, longitude REAL,
        FOREIGN KEY(user_id) REFERENCES users(id),
        FOREIGN KEY(theme_id) REFERENCES themes(id)
    )");
    $db->query("CREATE TABLE sub_services(
        id INT PRIMARY KEY,
        service_id INT, availability INT, title TEXT, description TEXT, price REAL,
        FOREIGN KEY(service_id) REFERENCES services(id)
    )");
    $db->query("CREATE TABLE admin_logs(
        id INT PRIMARY KEY,
        user_id INT, time INT, message TEXT,
        FOREIGN KEY(user_id) REFERENCES users(id)
    )");
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

    createTables($db);

    $db = null;
}
        ?>

        <?php
$state = 0; // 0: nothing sent, 1: sent command to delete, 2: done deletion, -1: aborted

if (array_key_exists("text", $_GET))
    $state = $_GET["text"] == "I understand" ? 1 : -1;
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
