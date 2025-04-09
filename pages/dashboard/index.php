<?php
require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";

assert_session();
component("header");
component("dashboard/widget-manager");
component("common/page-header");
component("common/notifications");
component("common/profile");

?>
<!DOCTYPE html>
<html lang="en">
<?php
insert_head("Dashboard", ["inputs", "containers", "widgets", "page-header"]);
?>
<script src="/assets/scripts/widget.js"></script>
<script src="/assets/scripts/notification.js" type="module"></script>

<body>
<?php

// initial username check, to not have to do it later
$db = getSecureDB();

$id = $_SESSION["id"];

insert_header("Dashboard", $id);
insert_all_widgets($db, $id);
?>

<a href="/pages/signout">Log out</a>

</body>
</html>
