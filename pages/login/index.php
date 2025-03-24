<!DOCTYPE html>
<html lang="en" class="fill-page">
<?php
require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";

component("header");
component("arrow_redirect");
component("text_field");
component("text_submit");

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
        </div>
    </form>
</div>

</body>
</html>
