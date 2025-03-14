<html>
    <head>
        <title>Database formatting</title>
        <style>textarea{width:100%;height:200px}</style>
    </head>

    <body>
        <h1>WARNING: this will WIPE OUT ALL DATA from the database and create a new, clean one.</h1>

        <?php
function getSecureDB() {
    $db = new PDO("sqlite:/private/test.db");
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

    $db->query("CREATE TABLE users(id INT AUTOINCREMENT, username TEXT, display_name TEXT, password TEXT, email TEXT, verified_email INT, phone TEXT, latitude REAL, longitude REAL, theme_id INT, banned INT)");
    $db->query("CREATE TABLE roles(user_id INT, role INT)");
    $db->query("CREATE TABLE balances(user_id INT, amount REAL)");
    $db->query("CREATE TABLE notifications(id INT AUTOINCREMENT, user_id INT, conversation_id INT, text TEXT, time INT)");
    $db->query("CREATE TABLE messages(id INT AUTOINCREMENT, user_id INT, conversation_id INT, message TEXT, time INT)");
    $db->query("CREATE TABLE conversations(id INT AUTOINCREMENT, user1 INT, user2 INT, subject TEXT, closed INT)");
    $db->query("CREATE TABLE conversations_requests(id INT AUTOINCREMENT, sender INT, receiver INT, is_service_inquiry INT)");
    $db->query("CREATE TABLE tags(id INT AUTOINCREMENT, name TEXT)");
    $db->query("CREATE TABLE tags_users_join(id INT AUTOINCREMENT, tag_id INT, user_id INT)");
    $db->query("CREATE TABLE tags_services_join(id INT AUTOINCREMENT, tag_id INT, service_id INT)");
    $db->query("CREATE TABLE themes(id INT AUTOINCREMENT, main_image_id INT, banner_image_id INT, col1 INT, col2 INT)");
    $db->query("CREATE TABLE images(id INT AUTOINCREMENT, url TEXT)");
    $db->query("CREATE TABLE orders(id INT AUTOINCREMENT, buyer_id INT, seller_id INT, sub_service_id INT, amount REAL)");
    $db->query("CREATE TABLE ratings(id INT AUTOINCREMENT, sub_service_id INT, user_id INT, rating REAL, comment TEXT)");
    $db->query("CREATE TABLE services(id INT AUTOINCREMENT, user_id INT, theme_id INT, title TEXT, description TEXT, latitude REAL, longitude REAL)");
    $db->query("CREATE TABLE sub_services(id INT AUTOINCREMENT, service_id INT, availability INT, title TEXT, description TEXT, price REAL)");
    $db->query("CREATE TABLE admin_logs(id INT AUTOINCREMENT, user_id INT, time INT, message TEXT)");

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
