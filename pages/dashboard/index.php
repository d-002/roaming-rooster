<?php
require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";

assert_session();
component("header");
component("dashboard_widgets");

?>
<!DOCTYPE html>
<html lang="en">
<?php
insertHeader("Dashboard", ["inputs", "containers", "widgets"]);
?>

<body>
<?php
// initial username check, to not have to do it later
$db = getSecureDB();

$username = $_SESSION["username"];
$id = checkValidUsername($db, $username);
if ($id == -1) {
    die("Cannot access this page right now");
}
echo "<p>DEBUG: connected with ID " . $id . "</p>";

insert_all_widgets($db, $id);
?>

<a href="/pages/signout">Log out</a>
</body>
</html>
