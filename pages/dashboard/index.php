<?php
require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";

assert_session();
component("header");
component("dashboard_widgets");
component("common/page_header");
component("common/notifications");
component("common/profile");

?>
<!DOCTYPE html>
<html lang="en">
<?php
insertHeader("Dashboard", ["inputs", "containers", "widgets", "page_header"]);
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

insert_header("Dashboard", $id);
insert_all_widgets($db, $id);
?>

<a href="/pages/signout">Log out</a>

<script src="/assets/scripts/widget.js"></script>

</body>
</html>
