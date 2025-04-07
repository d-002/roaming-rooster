<?php
root_include("/utils/dbutils.php");

function quickAdminCheck() {
    assert_session();
    
    $db = getSecureDB();

    if (!isAdmin($db, $_SESSION["id"])) header("Location: /pages/homepage");
    
    $db = null;
}
?>
