<?php

require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";
root_include("/utils/dbutils.php");

try {
    $database = getSecureDB();
    $prepared = $database->query("SELECT * FROM services");
    $services = $prepared->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    die("Error: " . $error->getMessage());
}

?>
<!DOCTYPE html>
<html lang="en">
<?php
component("header");
insert_head("Services", ["containers", "inputs", "page-header"]);
?>
<body>
<div class="container py-5">
    <?php
    component("common/page-header");
    insert_header("Available Services");
    ?>
    <div class="row g-4">
        <?php
        component("service");
        foreach ($services as $service) {
            insert_service($service);
        }
        ?>
    </div>
</div>
</body>
</html>