<!DOCTYPE html>
<html lang="en" class="fill-page">
<?php
require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";

component("header");
component("arrow_redirect");

insertHeader("Welcome", ["inputs", "containers"]);
?>
<body class="fill-page container align-content-center text-center">
<?php
if (isset($_REQUEST["display"])) {
    ?>
    <p class="subtitle">Welcome <?php echo $_REQUEST["display"]; ?> on</p>
    <h1>The Roaming Rooster</h1>
    <a href="/pages/login.php"><p class="pointed">Login</p></a>
    <?php
} else {
    ?>
    <p class="subtitle">Invalid request</p>
    <?php
}
?>
</body>
</html>