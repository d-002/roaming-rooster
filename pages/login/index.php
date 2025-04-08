<?php
require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";
root_include("/utils/dbutils.php");

component("header");
component("arrow-redirect");
component("text-field");
component("text-submit");
component("common/notifications");

function show_page($error = null): void
{
    ?>
    <!DOCTYPE html>
    <html lang="en" class="fill-page">
    <?php
    insert_head("Login", ["inputs", "containers"]);
    ?>

    <body class="fill-page main-column take-all justify-content-center align-content-center">

    <header class="titles">
        <a href="/pages/homepage">
            <p class="subtitle">Every local farmer is on</p>
            <h1>The Roaming Rooster</h1>
        </a>
    </header>

    <?php

    if ($error != null) {
        ?>
        <p class="alert alert-danger" role="alert">
            <?= $error; ?>
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
                insert_arrow_redirect("Before, I should", "Register", "/pages/register");
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
        show_page("Please enter an username and a password.");
        return;
    }

    $username = $_REQUEST["username"];
    $password = $_REQUEST["password"];
    $db = getSecureDB();

    // echo "username = " . $username . ", password = " . $password;
    if (!isUsernameInDatabase($db, $username)) {
        show_page("This user does not have an account.");
        return;
    }
    if (!verifyUserPassword($db, $username, $password)) {
        show_page("Invalid password, try again.");
        return;
    }

    $id = getUserIdByUsername($db, $username);
    $banned = isUserBanned($db, $id);
    if ($banned === null) {
        show_page("Cannot verify if your account is banned");
        return;
    } else if ($banned) {
        show_page("Your account id banned");
        return;
    }

    if (session_status() !== PHP_SESSION_NONE) {
        // destroy previous session, to avoid errors and make sure the new user is the one logged in
        session_destroy();
    }

    session_start();
    $_SESSION["username"] = $username;
    $_SESSION["id"] = $id;
    $_SESSION["connected"] = true;

    send_notification($db, "You are connected. Welcome back.", user: $id);

    header("Location: /pages/dashboard");
} else {
    show_page();
}
?>
