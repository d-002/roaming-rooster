<?php

function isUsernameInDatabase(PDO $db, $username): bool
{
    $st = $db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
    $result = $st->execute(["username" => $username]);
    if (!$result) return false;
    $elements = $st->fetchAll();
    $st->closeCursor();
    return count($elements) != 0;
}

function isEmailInDatabase(PDO $db, $email): bool
{
    $st = $db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
    $result = $st->execute(["email" => $email]);
    if (!$result) return false;
    $elements = $st->fetchAll();
    $st->closeCursor();
    return count($elements) != 0;
}
