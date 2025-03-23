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

function insertUserInDatabase(PDO $db, $email, $username, $password, $display = null, $phone = null, $latitude = null, $longitude = null, $theme_id = null)
{
    $data = [
        "email" => $email,
        "username" => $username,
        "password" => password_hash($password, PASSWORD_DEFAULT),
        "display_name" => $display,
        "phone" => $phone,
        "verified_email" => 0,
        "banned" => 0,
        "theme_id" => $theme_id,
        "latitude" => $latitude,
        "longitude" => $longitude
    ];

    $data = array_filter($data, function ($value) {
        return $value != null;
    });

    $columns = implode(", ", array_keys($data));
    $values = implode(", :", array_keys($data));

    $st = $db->prepare("INSERT INTO users ({$columns}) VALUES (:{$values})");
    $st->execute($data);
}
