<?php

function isUsernameInDatabase(PDO $db, $username): bool
{
    $st = $db->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
    $st->bindParam("s", $username);
    $result = $st->execute();
    if (!$result) return false;
    $elements = $st->fetchAll();
    return count($elements) != 0;
}
