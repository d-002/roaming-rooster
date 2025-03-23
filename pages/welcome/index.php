<!DOCTYPE html>
<html lang="en" class="fill-page">
<?php
require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";

component("header");
rootInclude("/private/db.php");
rootInclude("/utils/dbutils.php");

insertHeader("Welcome", ["inputs", "containers"]);
?>
<body class="fill-page container align-content-center text-center">
<?php
if (isset($_REQUEST["username"]) && isset($_REQUEST["password"]) && isset($_REQUEST["email"])) {
    insertUserInDatabase(getSecureDB(), $_REQUEST["email"], $_REQUEST["username"], $_REQUEST["password"]);
    ?>
    <p class="subtitle">Welcome <?php echo $_REQUEST["username"]; ?> on</p>
    <h1>The Roaming Rooster</h1>
    <a href="/pages/login"><p class="pointed">Login</p></a>
    <?php
} else {
    ?>
    <p class="subtitle">Invalid request</p>
    <?php
}
?>
</body>
</html>