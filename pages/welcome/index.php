<!DOCTYPE html>
<html lang="en" class="fill-page">
<?php
require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";

component("header");
component("common/notifications");
root_include("/utils/dbutils.php");
root_include("/utils/sanitize.php");

insertHeader("Welcome", ["inputs", "containers"]);
?>
<body class="fill-page container align-content-center text-center">
<?php
if (isset($_REQUEST["username"]) && isset($_REQUEST["password"]) && isset($_REQUEST["passwordconfirmation"]) && isset($_REQUEST["email"])) {
    $db = getSecureDB();

    $password = $_REQUEST["password"];
    $confirmation = $_REQUEST["passwordconfirmation"];
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
    $is_customer = isset($_REQUEST["want-buy"]);

    insertUserInDatabase($db, $email, $username, $password, display: $display, phone: $phone, is_customer: $is_customer, is_seller: $is_seller);
    $userId = getUserIdByUsername($db, $username);
    send_notification($db, "Welcome " . htmlspecialchars($display) . " on The Roaming Rooster!", user: $userId);

    if (isset($_REQUEST["tags-input"])) {
        $tagsInput = $_REQUEST["tags-input"];
        insertUserTags($db, $userId, $tagsInput);
    }

    ?>
    <p class="subtitle">Welcome <?= $_REQUEST["username"]; ?> on</p>
    <h1>The Roaming Rooster</h1>
    <a href="/pages/login"><p class="pointed">Login</p></a>
    <?php
} else {
    ?>
    <p class="subtitle">Invalid request</p>
    <?php
    print_r($_REQUEST);
    print_r(phpinfo());
    print_r($_POST);
    print_r($_COOKIE);
    print_r($_GET);
    print_r(file_get_contents("php://input"));
}
?>
</body>
</html>
