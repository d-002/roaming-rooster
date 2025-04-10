<?php
require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";
root_include("/utils/dbutils.php");
component("service");

// check if the user is registered to edit the buttons

$is_connected = has_session();

if ($is_connected) {
    $username = $_SESSION["username"];
}
?>

<!DOCTYPE html>
<html lang="en">
<?php
component("header");
insert_head("Home", array("homepage", "containers", "inputs"));
?>
<body>
<div id="left">
    <h2>Every local farmer is on</h2>
    <h1>Roaming Rooster</h1>

    <div class="center">
        <?php
        function button($text, $link, $class): void
        {
            echo "<a href='" . $link . "' class='button " . $class . "'>" . $text . "</a>";
        }

        if ($is_connected) {
            button("Dashboard", "/pages/dashboard", "primary");
            button("Sign out", "/pages/signout", "secondary");
        } else {
            button("Sign up", "/pages/register", "primary");
            button("Sign in", "/pages/login", "secondary");
        } ?>
    </div>

    <?php
    component("logo");
    ?>

    <p id="arrow">
        See services
    </p>

    <a href="/pages/services" class="button secondary">Browse</a>

    <?php
    $db = getSecureDB();
    $services = random_services($db, 6);
    if (count($services) != 0) {
        ?>
        <div class="widget-list">
            <?php
            foreach ($services as $service) {
                insert_service($service);
            }
            ?>
        </div>
        <?php
    }
    ?>
</div>

<div id="right"></div>
</body>
</html>
