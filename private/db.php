<?php
function getSecureDB() {
    $db = new PDO("sqlite:".$_SERVER["DOCUMENT_ROOT"]."/private/main-database.db");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_PERSISTENT, true);

    return $db;
}
?>
