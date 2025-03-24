<!DOCTYPE html>
<html lang="en" class="fill-page">
<?php
require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";

component("header");
rootInclude("/private/db.php");
rootInclude("/utils/dbutils.php");
rootInclude("/utils/sanitize.php");

insertHeader("Welcome", ["inputs", "containers"]);
?>
<body class="fill-page container align-content-center text-center">
<?php
if (isset($_REQUEST["username"]) && isset($_REQUEST["password"]) && isset($_REQUEST["password-confirmation"]) && isset($_REQUEST["email"])) {
    $db = getSecureDB();

    $password = $_REQUEST["password"];
    $confirmation = $_REQUEST["password-confirmation"];
    $email = $_REQUEST["email"];
    $username = $_REQUEST["username"];

    if (isEmailInDatabase($db, $email) || isUsernameInDatabase($db, $username))
        die("Invalid request. User already in database.");
    if (!isEmail($email))
        die("Invalid email.");

    if ($password !== $confirmation)
        die("Invalid request. Please enter the same password and password confirmation");

    $display = $_REQUEST["display"] ?? null;
    $phone = $_REQUEST["phone"] ?? null;
    $is_seller = isset($_REQUEST["want-sell"]);
    echo "seller: $is_seller";
    $is_customer = isset($_REQUEST["want-buy"]);
    echo "customer: $is_customer";

    insertUserInDatabase($db, $email, $username, $password, display: $display, phone: $phone, is_customer: $is_customer, is_seller: $is_seller);
    ?>
    <p class="subtitle">Welcome <?php echo $_REQUEST["username"]; ?> on</p>
    <h1>The Roaming Rooster</h1>
    <a href="/pages/login"><p class="pointed">Login</p></a>
    <?php
} else {
    ?>
    <p class="subtitle">Invalid request</p>
    <?php
}
?>
</body>
</html>