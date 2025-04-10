<?php

require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";

assert_session();
component("header");
component("service");
root_include("/utils/dbutils.php");

if (!isset($_REQUEST["id"])) {
    header("Location: /pages/services");
    exit();
}

$service_id = $_REQUEST["id"];

try {
    $database = getSecureDB();

    $service = service_request($database, "SELECT id FROM services WHERE id = ?", [$service_id])[0];
    $product = products_from_service($database, $service_id);

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en" class="fill-page">

<?php
insert_head(htmlspecialchars($service["title"]) . " Details", ["containers", "inputs"]);
?>

<body class="fill-page main-column">
<header class="titles">
    <h1><?= htmlspecialchars($service["title"]) ?></h1>
</header>
<div class="card card-half-page root-content">
    <div class="card-body">
        <p class="lead"><?= htmlspecialchars($service["description"]) ?></p>
        <div class="alert alert-secondary">
            <p>Provider: <?= $service["display_name"] ?></p>
            <p class="text-muted">Coordinates: <?= $service["latitude"] ?>, <?= $service["longitude"] ?></p>
        </div>
        <div class="widget-list">
            <img class="search-result" src="<?= htmlspecialchars($service["img_main_url"]) ?>" alt="Main service image">
            <img class="search-result" src="<?= htmlspecialchars($service["img_banner_url"]) ?>"
                 alt="Banner service image">
        </div>
        <h3 class="mt-5 mb-3">Sub Services</h3>
        <div class="widget-list">
            <?php
            foreach ($product as $sub) {
                insert_product($sub);
            }
            ?>
        </div>
        <a href="/pages/services" class="btn btn-outline-secondary mt-4">Back to List</a>
    </div>
</div>
</body>
</html>
