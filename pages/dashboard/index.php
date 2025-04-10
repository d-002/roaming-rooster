<?php
require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";

assert_session();
component("header");
component("scripts");
component("dashboard/widget-manager");
component("common/page-header");
component("common/notifications");
component("common/profile");

?>
<!DOCTYPE html>
<html lang="en" class="fill-page">
<?php
insert_head("Dashboard",
    array("inputs", "containers", "widgets", "page-header", "dashboard"));
?>

<body class="fill-page">
<?php

// initial username check, to not have to do it later
$db = getSecureDB();

$id = $_SESSION["id"];

insert_header("Dashboard", $id);
insert_all_widgets($db, $id);

insert_module("widget");
insert_script("notification");
?>

</body>
</html>
