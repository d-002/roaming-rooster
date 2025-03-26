<?php
session_start();
if (!isset($_SESSION["connected"]) || !$_SESSION["connected"]) {
    session_destroy();
    die("You are not connected.");
}

require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";

component("header");
component("search");

?>
<!DOCTYPE html>
<html lang="en">
<?php
insertHeader("Dashboard", ["inputs", "containers"]);
?>
<body>
<p>Hello world, you are connected</p>
<?php
insertSearchWidget(page: false);
?>
</body>
</html>