<?php
require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";
root_include("/utils/dbutils.php");

if (!has_session()) exit();

$db = getSecureDB();
component("common/notifications");

read_notification($db, $_SESSION["id"], $_REQUEST["id"]);
