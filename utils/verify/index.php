<?php
require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";
root_include("/utils/dbutils.php");
root_include("/utils/sanitize.php");

$db = getSecureDB();

if (isset($_REQUEST["username"])) {
    echo isUsernameInDatabase($db, $_REQUEST["username"]) ? "forbidden" : "usable";
} else if (isset($_REQUEST["email"])) {
    $email = $_REQUEST["email"];
    echo isEmail($email) && !isEmailInDatabase($db, $_REQUEST["email"]) ? "usable" : "forbidden";
}
