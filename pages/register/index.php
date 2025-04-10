<!DOCTYPE html>
<html lang="en" class="fill-page">
<?php
require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";
root_include("/utils/dbutils.php");

$db = getSecureDB();

// Reusable components
component("header");
component("scripts");
component("text-field");
component("arrow-redirect");
component("text-submit");
component("check-group");
component("pages");
component("tags");

insert_head("Register",
    array("containers", "inputs"));
?>
<body class="fill-page">

<div class="fill-page main-column">
    <header class="titles page" page="0">
        <a href="/pages/homepage">
            <p class="subtitle">Join a strong community on</p>
            <h1>The Roaming Rooster</h1>
        </a>
    </header>

    <div class="card root-content card-half-page">
        <div class="logo-decoration-container">
            <?php component("logo"); ?>
        </div>
        <form class="classic-form" action="/pages/welcome/" id="register-form" method="post">
            <!-- Page 0 -->
            <div class="page" page="0">
                <?php
                insert_arrow_redirect("I have an account", "Login", "/pages/login");
                ?>
            </div>
            <div class="form-element page" page="0">
                <?php
                insertTextField("Username", "username", true);
                insertCheckboxFancyGroup([["want-buy", "I want to Buy"], ["want-sell", "I want to Sell"]]);
                ?>
            </div>
            <div class="page align-self-center" page="0">
                <?php insertTextSubmit("Start Registering"); ?>
            </div>
            <!-- Page 1 -->
            <div class="form-element page preload" page="1">
                <p class="form-section">Login details</p>
                <?php
                insertTextField("Your email", "email", true, "email");
                insertTextField("Phone number?", "phone", false, "tel");
                ?>
            </div>

            <hr class="page preload" page="1">

            <div class="form-element page preload" page="1">
                <p class="form-section">Password</p>
                <?php
                insertTextField("Choose password", "password", true, "password");
                insertTextField("Confirm password", "passwordconfirmation", true, "password");
                ?>
            </div>


            <!-- Page 2 -->

            <div class="form-element page preload" page="2">
                <p class="form-section">Your profile</p>
                <?php
                insertTextField("Displayed name", "display", false);
                ?>
                <p class="form-text">Coming soon, theme selector</p>
            </div>

            <!-- Page 3 -->

            <div class="form-element page preload" page="3">
                <p class="form-section">About you</p>
                <input type="hidden" id="tags-input" name="tags-input" value="">
                <?php
                $tags = get_tags($db, 30);
                insertTags($tags);
                ?>
                <p class="form-text">Can be edited at any moment. Full list will be on your profile page.</p>
            </div>

            <div class="form-element page preload" page="3">
                <p class="form-section">Let us connect you with locals</p>
                <?php
                // TODO
                ?>
            </div>

            <!-- ALL except 0 -->

            <div class="page-ex preload" page-ex="0">
                <?php
                insertNavigationMenu(3, 1);
                ?>
            </div>

            <!-- Confirmation -->

            <div class="page preload form-element" page="3">
                <?php
                insertTextSubmit("Register");
                ?>
            </div>
        </form>
    </div>
</div>

<?php
insert_module("inputs");
insert_module("register");
?>

</body>
</html>

