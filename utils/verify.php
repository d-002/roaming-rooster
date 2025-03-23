<?php
require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";
rootInclude("/private/db.php");
rootInclude("/utils/dbutils.php");

$db = getSecureDB();

if (isset($_REQUEST["username"])) {
    echo isUsernameInDatabase($db, $_REQUEST["username"]) ? "forbidden" : "usable";
}
