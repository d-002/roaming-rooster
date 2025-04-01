<?php
root_include("/utils/dbutils.php");

function quickAdminCheck() {
    $ok = has_session();

    if ($ok) {
        $username = $_SESSION["username"];
        $db = getSecureDB();

        $ok = checkValidUsername($db, $username) !== -1;

        if ($ok) {
            $id = getUserIdByUsername($db, $username);
            $ok = isAdmin($db, $id);
        }

        $db = null;
    }

    if (!$ok) header("Location: /pages/homepage");
}
?>
