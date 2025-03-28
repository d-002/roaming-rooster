<?php

require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";

try {
    root_include("/utils/dbutils.php");
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
insertHeader("Services");
?>
<body class="bg-light">
<div class="container py-5">
    <h1 class="mb-4 text-center">Available Services</h1>
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