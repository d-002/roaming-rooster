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
component("pages");

insertHeader("Register", array("containers", "inputs"));
?>
<body class="fill-page">

<div class="fill-page main-column">
    <header class="titles page page-0">
        <a href="/home.php">
            <p class="subtitle">Join a strong community on</p>
            <h1>The Roaming Rooster</h1>
        </a>
    </header>

    <div class="card card-half-page">
        <div class="logo-decoration-container">
            <?php component("logo"); ?>
        </div>
        <form class="classic-form" action="" id="register-form">
            <!-- Page 0 -->
            <div class="page page-0">
                <?php
                insertArrowRedirect("I have an account", "Login", "/pages/login.php");
                ?>
            </div>
            <div class="form-element page page-0">
                <?php
                insertTextField("Username", "username", true);
                insertCheckboxFancyGroup([["want-buy", "I want to Buy"], ["want-sell", "I want to Sell"]]);
                ?>
            </div>
            <div class="page page-0 align-self-center">
                <?php insertTextSubmit("Start Registering"); ?>
            </div>
            <!-- Page 1 -->
            <div class="form-element page page-1">
                <?php
                insertTextField("Your email", "email", true, "email");
                insertTextField("Phone number?", "phone", false, "tel");
                ?>
            </div>

            <hr class="form-element page page-1">

            <div class="form-element page page-1">
                <?php
                insertTextField("Choose password", "password", true, "password");
                insertTextField("Confirm password", "password-confirmation", true, "password");
                ?>
            </div>

            <div class="form-element page page-1">
                <?php
                insertNavigationMenu(3, 1);
                ?>
            </div>
        </form>
    </div>
</div>

<script src="/assets/scripts/inputs.js"></script>
<script src="/assets/scripts/register.js"></script>

</body>
</html>

