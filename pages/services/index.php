<?php

require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";
root_include("/utils/dbutils.php");
component("search");

try {
    $database = getSecureDB();
    $services = service_request($database, "SELECT id FROM services", []);
} catch (PDOException $error) {
    die("Error: " . $error->getMessage());
}

?>
<!DOCTYPE html>
<html lang="en">
<?php
component("header");
insert_head("Services", array("containers", "inputs", "page-header"));
?>
<body>
<?php
component("common/page-header");
insert_header("Available Services");
?>
<div class="search-options">
    <?php
    insert_search_widget(page: false);
    ?>
</div>
<div class="widget-list">
    <?php
    component("service");
    foreach ($services as $service) {
        insert_service($service);
    }
    ?>
</div>
</body>
</html>
