<?php
require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";

assertSession();
component("header");
component("search");
component("service");
rootInclude("/utils/dbutils.php");
rootInclude("/utils/search_helper.php");

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
    $database = getSecureDB();
    $results = search_service($database, $_REQUEST["s"]);
    foreach ($results as $result) {
        insert_service($result);
    }
} else {
    insertSearchWidget();
}
?>

<script src="/assets/scripts/search.js"></script>

</body>
</html>
