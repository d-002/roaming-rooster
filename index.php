<?php
function getSecureDB() {
    $db = new PDO("sqlite:test.db");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_PERSISTENT, true);

    return $db;
}

function sendSecureQuery($db, $query) {
    try {
        return null;
    }
    catch (Exception $e) {
        echo "Failed: " . $e->getMessage();
        return null;
    }
}

$db = getSecureDB();
var_dump($db);

$db = null; // close the connection (except no because it's persistent but it doesn't matter)
?>
