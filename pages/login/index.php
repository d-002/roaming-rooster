<?php
require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";
rootInclude("/utils/dbutils.php");

component("header");
component("arrow_redirect");
component("text_field");
component("text_submit");

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

    <?php

    if ($error != null) {
        ?>
        <p class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </p>
        <?php
    }
    ?>

    <div class="line">
        <div class="logo-decoration-container">
            <?php
            component("logo");
            ?>
        </div>

        <form class="classic-form" method="POST">
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

    echo "username = " . $username;
    echo "password = " . $password;
    if (!isUsernameInDatabase($db, $username)) {
        showPage("This user does not have an account.");
        return;
    }
    if (!verifyUserPassword($db, $username, $password)) {
        showPage("Invalid password, try again.");
        return;
    }

    $id = getUserIdByUsername($db, $username);
    $ban = isUserBanned($db, $id);
    if ($ban === null) {
        showPage("Cannot verify if your account is banned");
        return;
    } else if ($ban) {
        showPage("Your account id banned");
        return;
    }

    session_start();
    $_SESSION["username"] = $username;
    $_SESSION["connected"] = true;

    header("Location: /pages/dashboard");
} else {
    showPage();
}
?>
