<?php
require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";

assert_session();
component("header");
component("search");
component("service");
root_include("/utils/dbutils.php");
root_include("/utils/search_helper.php");

?>
<!DOCTYPE html>
<html lang="en">
<?php
insertHeader("Results", ["inputs", "containers"]);
?>
<body>
<?php
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
    insert_search_widget();
}
?>

<script src="/assets/scripts/search.js"></script>

</body>
</html>
