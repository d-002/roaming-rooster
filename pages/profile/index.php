<?php
require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";
component("header");

insertHeader("Register", array("containers", "inputs"));

root_include("/utils/dbutils.php");

session_start();
if (!isset($_SESSION["connected"]) || $_SESSION["connected"] !== true) {
    header("Location: /pages/login");
    exit;
}

$username = $_SESSION["username"];
$db = getSecureDB();

$stmt = $db->prepare("SELECT display_name, email FROM users WHERE username = ? LIMIT 1");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
    <body class="main-column" style="padding:2rem;">
        <h1>Your Profile</h1>

        <?php if ($user): ?>
            <p><strong>Username:</strong> <?= htmlspecialchars($username) ?></p>
            <p><strong>Display Name:</strong> <?= htmlspecialchars($user["display_name"]) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user["email"]) ?></p>
        <?php else: ?>
            <p>User not found in database.</p>
        <?php endif; ?>
</body>
</html>