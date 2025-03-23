<?php

function isUsernameInDatabase(PDO $db, $username): bool
{
    $st = $db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
    $result = $st->execute(['username' => $username]);
    if (!$result) return false;
    $elements = $st->fetchAll();
    return count($elements) != 0;
}
