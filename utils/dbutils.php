<?php
function getSecureDB(): PDO
{
    $db = new PDO("sqlite:" . $_SERVER["DOCUMENT_ROOT"] . "/private/main-database.db");
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

function isUserBanned(PDO $db, $id)
{
    $st = $db->prepare("SELECT banned FROM users WHERE id = :id LIMIT 1");
    $result = $st->execute(["id" => $id]);
    if (!$result) return null;
    $elements = $st->fetchAll();
    $st->closeCursor();
    if (count($elements) != 1) return null;
    return $elements[0]["banned"];
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

function hasUserGotRole(PDO $db, $id, $roleID): bool {
    $st = $db->prepare("SELECT * FROM roles WHERE user_id = :id");
    if (!$st->execute(["id" => $id])) return false;

    while ($elt = $st->fetch()) {
        // single equality here: in case the value in the database is a string,
        // it will be converted into a number to make sure the comparison works.
        // for a well-prepared database, this should not matter as the data should
        // already be an integer, but changing == into === could break and easily
        // pass unnoticed if changes to the database are made in the future
        if ($elt["role"] == $roleID) return true;
    }

    return false;
}

function isBusiness(PDO $db, $id) {
    return hasUserGotRole($db, $id, 0);
}

function isCustomer(PDO $db, $id) {
    return hasUserGotRole($db, $id, 1);
}

function isAdmin(PDO $db, $id) {
    return hasUserGotRole($db, $id, 2);
}

function addRoleToUser(PDO $db, $id, $role): void
{
    $st = $db->prepare("INSERT INTO roles (user_id, role) VALUES (:id, :role)");
    $st->execute(["id" => $id, "role" => $role]);
}

function checkValidUsername(PDO $db, $username): int {
    // checks if this username has basic page access
    // returns user ID if so, -1 otherwise

    if (!isUsernameInDatabase($db, $username)) return -1;
    $id = getUserIDByUsername($db, $username);
    if (isUserBanned($db, $id)) return -1;

    return $id;
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
        return $value !== null;
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

function get_tags(PDO $db, $limit): array
{
    $prepared = $db->prepare("SELECT name FROM tags LIMIT :limit");
    if (!$prepared->execute(["limit" => $limit])) return [];
    $array = [];
    while ($element = $prepared->fetchColumn()) {
        $array[] = $element;
    }
    return $array;
}

function insertUserTags(PDO $db, int $userId, string $tagsInput): void {
    $tagNames = array_filter(array_map('trim', explode(',', $tagsInput)));
    foreach ($tagNames as $tagName) {
        if (empty($tagName)) continue;
        $stmt = $db->prepare("SELECT id FROM tags WHERE name = ?");
        $stmt->execute([$tagName]);
        $tagId = $stmt->fetchColumn();

        if ($tagId) {
            $stmt = $db->prepare("INSERT INTO tags_users_join (tag_id, user_id) VALUES (?, ?)");
            $stmt->execute([$tagId, $userId]);
        }
        else {
            error_log("Tag not found: " . $tagName);
        }
    }
}