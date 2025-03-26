<?php
function getSecureDB(): PDO {
    $db = new PDO("sqlite:".$_SERVER["DOCUMENT_ROOT"]."/private/main-database.db");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_PERSISTENT, true);

    return $db;
}

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

function getUserIdByUsername(PDO $db, $username)
{
    $st = $db->prepare("SELECT id FROM users WHERE username = :username LIMIT 1");
    $result = $st->execute(["username" => $username]);
    if (!$result) return null;
    $elements = $st->fetchAll();
    $st->closeCursor();
    if (count($elements) != 1) return null;
    return $elements[0]["id"];
}

function verifyUserPassword(PDO $db, $username, $password): bool
{
    $st = $db->prepare("SELECT password FROM users WHERE username = :username LIMIT 1");
    $result = $st->execute(["username" => $username]);
    if (!$result) return false;
    $elements = $st->fetchAll();
    $st->closeCursor();
    if (count($elements) != 1) return false;
    return password_verify($password, $elements[0]["password"]);
}

function addRoleToUser(PDO $db, $id, $role): void
{
    $st = $db->prepare("INSERT INTO roles (user_id, role) VALUES (:id, :role)");
    $st->execute(["id" => $id, "role" => $role]);
}

function insertUserInDatabase(PDO $db, $email, $username, $password, $display = null, $phone = null, $latitude = null, $longitude = null, $theme_id = null, $is_customer = false, $is_seller = false): void
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

    $id = getUserIdByUsername($db, $username);

    if ($is_seller)
        addRoleToUser($db, $id, 2);
    if ($is_customer)
        addRoleToUser($db, $id, 1);
}
?>
