<!DOCTYPE html>
<html lang="en">
    <?php
    require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";

    component("header");

    insertHeader("Home", array("homepage/main"));
    ?>

    <body>
        <div id="left">
            <h2>Every local farmer is on</h2>
            <h1>Roaming Rooster</h1>
            <br class="large" />

            <div class="center">
            <?php
function button($text, $link, $class) {
    echo "<a href='".$link."' class='button ".$class."'>".$text."</a>";
}

if (0) {
    button("Dashboard", "/pages/dashboard", "primary");
    button("Sign out", "/pages/signout", "secondary");
}
else {
    button("Sign up", "/pages/register", "primary");
    button("Sign in", "/pages/login", "secondary");
} ?>
            </div>

            <br class="large" />
            <p id="arrow">See services</p>
            <br class="large" />

<?php
?>

            <br class="large" />
            <a href="/pages/services" class="button secondary">Browse</a>
        </div>

        <div id="right"></div>
    </body>
</html>
