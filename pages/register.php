<!DOCTYPE html>
<html lang="en" class="fill-page">
<?php
require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";

// Reusable components
component("header");
component("text_field");
component("arrow_redirect");
component("text_submit");
component("check_group");

insertHeader("Register", array("containers", "inputs"));
?>
<body class="fill-page">

<div class="fill-page main-column">
    <header class="titles">
        <p class="subtitle">Join a strong community on</p>
        <h1>The Roaming Rooster</h1>
    </header>

    <div class="card card-half-page">
        <div class="logo-decoration-container">
            <?php component("logo"); ?>
        </div>
        <form class="classic-form" action="">
            <?php
            insertArrowRedirect("I have an account", "Login", "/pages/login.php");
            ?>
            <div>
                <?php
                insertTextField("Username", "username");
                insertCheckboxFancyGroup([["want-buy", "I want to Buy"], ["want-sell", "I want to Sell"]]);
                ?>
            </div>
            <?php insertTextSubmit("Start Registering!"); ?>
        </form>
    </div>
</div>

<script src="/assets/scripts/inputs.js"></script>

</body>
</html>

