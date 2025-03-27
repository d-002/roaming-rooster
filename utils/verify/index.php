<?php
require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";
rootInclude("/private/db.php");
rootInclude("/utils/dbutils.php");
rootInclude("/utils/sanitize.php");

$db = getSecureDB();

if (isset($_REQUEST["username"])) {
    echo isUsernameInDatabase($db, $_REQUEST["username"]) ? "forbidden" : "usable";
} else if (isset($_REQUEST["email"])) {
    $email = $_REQUEST["email"];
    echo isEmail($email) && !isEmailInDatabase($db, $_REQUEST["email"]) ? "usable" : "forbidden";
}
