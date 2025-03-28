<?php

require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";
root_include("/utils/dbutils.php");
root_include("/utils/search_helper.php");

$database = getSecureDB();

$results = quick_service_search($database, $_REQUEST["s"]);

$answer = "";
for ($i = 0; $i < min(count($results, 5)); $i++) {
    $answer .= '°' . htmlspecialchars($results[$i]);
}

echo $answer;
