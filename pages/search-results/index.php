<?php
require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";

assert_session();
component("header");
component("search");
component("service");
component("common/page-header");
component("common/notifications");
component("common/profile");
root_include("/utils/dbutils.php");
root_include("/utils/search-helper.php");

?>
<!DOCTYPE html>
<html lang="en">
<?php
insert_head("Results", ["inputs", "containers", "page-header"]);
?>
<body>
<?php
insert_header("Search results", 0);
if (isset($_REQUEST["s"])) {
    ?>
    <div class="search-options">
        <?php
        insert_search_widget(content: $_REQUEST["s"]);
        ?>
        <div id="suggestions"></div>
    </div>
    <?php

    $database = getSecureDB();
    $results = search_service($database, $_REQUEST["s"]);
    $products = search_sub_service($database, $_REQUEST["s"]);

    ?>
    <h2 class="search-result">Services</h2>
    <div class="widget-list">
        <?php
        foreach ($results as $result) {
            insert_service($result);
        }
        ?>
    </div>
    <h2 class="search-result">Products</h2>
    <div class="widget-list">
        <?php
        foreach ($products as $product) {
            insert_product($product);
        }
        ?>
    </div>
    <?php
} else {
    ?>
    <div class="search-options">
        <?php
        insert_search_widget();
        ?>
        <div id="suggestions"></div>
    </div>
    <?php
}
?>

<script src="/assets/scripts/search.js"></script>

</body>
</html>
