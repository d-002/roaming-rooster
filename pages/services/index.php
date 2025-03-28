<?php

require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";

try {
    rootInclude("/utils/dbutils.php");
    $db = getSecureDB();
    $stmt = $db->query("SELECT * FROM services");
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<?php
component("header");
insertHeader("Services");

function insertService($service): void
{
    ?>
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($service['title']) ?></h5>
                <p class="card-text text-muted"><?= htmlspecialchars(substr($service['description'], 0, 80)) ?>...</p>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">Provider: Seller<?= $service['user_id'] ?></small>
                    <a href="/pages/service_detail?id=<?= $service['ID'] ?>" class="btn btn-sm btn-primary">Details</a>
                </div>
            </div>
        </div>
    </div>
    <?php
}

?>
<body class="bg-light">
<div class="container py-5">
    <h1 class="mb-4 text-center">Available Services</h1>
    <div class="row g-4">
        <?php
        foreach ($services as $service) {
            insertService($service);
        }
        ?>
    </div>
</div>
</body>
</html>