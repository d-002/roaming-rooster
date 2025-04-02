<?php
require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";
root_include("/utils/dbutils.php");

// check if the user is registered to edit the buttons

$isConnected = has_session();

if ($isConnected) {
    $username = $_SESSION["username"];
    $db = getSecureDB();
    $isConnected = checkValidUsername($db, $username) !== -1;

    $db = null; // disconnect from the database early
}
?>

<!DOCTYPE html>
<html lang="en">
<?php
component("header");
insertHeader("Home", array("homepage/main"));
?>
<body>
<div id="left">
    <h2>Every local farmer is on</h2>
    <h1>Roaming Rooster</h1>
    <br class="large">

    <div class="center">
        <?php
        function button($text, $link, $class): void
        {
            echo "<a href='" . $link . "' class='button " . $class . "'>" . $text . "</a>";
        }

        if ($isConnected) {
            button("Dashboard", "/pages/dashboard", "primary");
            button("Sign out", "/pages/signout", "secondary");
        } else {
            button("Sign up", "/pages/register", "primary");
            button("Sign in", "/pages/login", "secondary");
        } ?>
    </div>

    <br class="large">
    <p id="arrow">
        See services
    </p>
    <br class="large">

    <?php
    ?>

    <br class="large">
    <a href="/pages/services" class="button secondary">Browse</a>
</div>

<div id="right"></div>
</body>
</html>
