<!DOCTYPE html>
<html lang="en">
<?php
include $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";
rootInclude("/components/header.php");
insertHeader("Register");
?>
<body>

<div>
    <header>
        <h2>Join a strong community on</h2>
        <h1>The Roaming Rooster</h1>
    </header>

    <div>
        <div>
            <div>
                <img src="/assets/images/logo.png" alt="A roaming rooster">
            </div>
        </div>
        <div>
            <?php
            rootInclude("/components/arrow_redirect.php");
            insertArrowRedirect("I have an account", "Login", "/pages/login.php");
            ?>
        </div>
    </div>
</div>

</body>
</html>

