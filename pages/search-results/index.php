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
    insert_search_widget(content: $_REQUEST["s"]);
    $database = getSecureDB();
    $results = search_service($database, $_REQUEST["s"]);

    ?>
    <div class="widget-list">
        <?php
        foreach ($results as $result) {
            insert_service($result);
        }
        ?>
    </div>
    <?php
} else {
    insert_search_widget();
}
?>

<script src="/assets/scripts/search.js"></script>

</body>
</html>
