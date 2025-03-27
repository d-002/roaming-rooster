<?php
require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";

assertSession();
component("header");
component("search");

?>
<!DOCTYPE html>
<html lang="en">
<?php
insertHeader("Results", ["inputs", "containers"]);
?>
<body>
<?php
if (isset($_REQUEST["s"])) {
    insertSearchWidget(content: $_REQUEST["s"]);
} else {
    insertSearchWidget();
}
?>

<script src="/assets/scripts/search.js"></script>

</body>
</html>
