<?php
require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";

component("header");
component("arrow_redirect");
component("text_field");
component("text_submit");
rootInclude("/utils/dbutils.php");
rootInclude("/private/db.php");

function showPage($error = null): void
{
    ?>
    <!DOCTYPE html>
    <html lang="en" class="fill-page">
    <?php
    insertHeader("Login", ["inputs", "containers"]);
    ?>

    <body class="fill-page main-column take-all justify-content-center align-content-center">

    <header class="titles">
        <a href="/home.php">
            <p class="subtitle">Every local farmer is on</p>
            <h1>The Roaming Rooster</h1>
        </a>
    </header>

    <div class="line">
        <div class="logo-decoration-container">
            <?php
            component("logo");
            ?>
        </div>

        <form class="classic-form">
            <div class="form-element">
                <?php
                insertTextField("Username", "username", true);
                insertTextField("Password", "password", true, type: "password");
                ?>
            </div>

            <div class="line">
                <?php
                insertTextSubmit("Login");
                insertArrowRedirect("Before, I should", "Register", "/pages/register");
                ?>
                <input type="hidden" id="try" name="try" value="try">
            </div>
        </form>
    </div>

    </body>
    </html>
<?php }

if (isset($_REQUEST["try"])) {
    if (!(isset($_REQUEST["username"]) && isset($_REQUEST["password"]))) {
        showPage("Please enter an username and a password.");
        return;
    }

    $username = $_REQUEST["username"];
    $password = $_REQUEST["password"];
    $db = getSecureDB();

    if (!isUsernameInDatabase($db, $username)) {
        showPage("This user does not have an account.");
    }
    if (!verifyUserPassword($db, $username, $password)) {
        showPage("Invalid password, try again.");
    }

    session_start();
    $_SESSION["username"] = $username;
    $_SESSION["connected"] = true;
} else {
    showPage();
}
?>