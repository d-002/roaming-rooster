<?php

require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";

assertSession();
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
insertSearchWidget(page: false);
?>
</body>
</html>