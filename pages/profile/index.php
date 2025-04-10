<?php
require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";
component("header");
component("tags");

root_include("/utils/dbutils.php");

assert_session();

// Set 100 money default
if (!isset($_SESSION['money'])) {
    $_SESSION['money'] = 100; 
}
$balance = $_SESSION['money'];

$username = $_SESSION["username"];
$db = getSecureDB();

$stmt = $db->prepare("SELECT id, display_name, email FROM users WHERE username = ? LIMIT 1");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $userId = $user["id"];
    $userTags = getUserTags($db, $userId);
}

insert_head("Profile", array("containers", "inputs"));
?>

<!DOCTYPE html>
<html lang="en">
    <body class="main-column" style="padding:2rem;">
        <h1>Your Profile</h1>

        <?php if ($user): ?>
            <p><strong>Username:</strong> <?= htmlspecialchars($username) ?></p>
            <p><strong>Display Name:</strong> <?= htmlspecialchars($user["display_name"]) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user["email"]) ?></p>
            <!--display balance in profile page-->
            <p><strong>Current Balance:</strong> <?= $balance ?></p>
            <!--Top up money by input value-->
            <h2>Top Up Money</h2>
            <form action="/utils/currency.php" method="post">
                <input type="number"
                       name = "amount"
                       placeholder = "Enter amount"
                       min = "0.01"
                       step = "0.01"
                       require>
                <button type="submit">Top up now</button>
            </form>


            <h2>Your Tags</h2>
            <?php
                if (isset($userTags) && count($userTags) > 0) {
                    insertTags($userTags);
                }
                else {
                    echo "<p>No tags selected.</p>";
                }
            ?>
        <?php else: ?>
            <p>User not found in database.</p>
        <?php endif; ?>
</body>
</html>
