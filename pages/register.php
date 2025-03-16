<!DOCTYPE html>
<html lang="en">
<?php
require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";

// Reusable components
component("header");
component("text_field");
component("arrow_redirect");
component("text_submit");

insertHeader("Register", array("containers", "inputs"));
?>
<body>

<div>
    <header>
        <p class="subtitle">Join a strong community on</p>
        <h1>The Roaming Rooster</h1>
    </header>

    <div class="card">
        <div class="logo-decoration-container">
            <?php component("logo"); ?>
        </div>
        <div>
            <?php
            insertArrowRedirect("I have an account", "Login", "/pages/login.php");
            ?>
            <div>
                <?php
                insertTextField("Username", "username");
                ?>
            </div>
            <?php insertTextSubmit("Start Registering!"); ?>
        </div>
    </div>
</div>

</body>
</html>

