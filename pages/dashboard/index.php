<?php

require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";

assert_session();
component("header");
component("search");

?>
<!DOCTYPE html>
<html lang="en">
<?php
insertHeader("Dashboard", ["inputs", "containers"]);
?>
<body>
<p>Hello world, you are connected</p>
<?php
insert_search_widget(page: false);
?>
</body>
</html>