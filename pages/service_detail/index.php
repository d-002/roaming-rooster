<?php

require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";

assert_session();
component("header");
component("service");
root_include("/utils/dbutils.php");

if (!isset($_GET['id'])) {
    header("Location: services.php");
    exit();
}

$serviceId = $_GET['id'];

try {
    $database = getSecureDB();

    $stmt = $database->prepare("SELECT * FROM services WHERE ID = ?");
    $stmt->execute([$serviceId]);
    $service = $stmt->fetch(PDO::FETCH_ASSOC);

    $subStmt = $database->prepare("SELECT * FROM sub_services WHERE service_id = ?");
    $subStmt->execute([$serviceId]);
    $subServices = $subStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<?php
insertHeader(htmlspecialchars($service['title'] . 'Details'));
?>

<body class="bg-light">
<div class="container py-5">
    <div class="card shadow">
        <div class="card-body">
            <h1 class="card-title mb-4"><?= htmlspecialchars($service['title']) ?></h1>
            <div class="alert alert-secondary">
                <small>
                    Provider: Seller<?= $service['user_id'] ?> |
                    Category: Customized Services<?= $service['theme_id'] ?>
                </small>
            </div>
            <p class="lead"><?= htmlspecialchars($service['description']) ?></p>
            <p class="text-muted">Coordinates: <?= $service['latitude'] ?>, <?= $service['longitude'] ?></p>

            <h3 class="mt-5 mb-3">Sub Services</h3>
            <div class="list-group">
                <?php foreach ($subServices as $sub): ?>
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5><?= htmlspecialchars($sub['title']) ?></h5>
                                <p class="mb-0"><?= htmlspecialchars($sub['description']) ?></p>
                            </div>
                            <span class="badge bg-success fs-6">$<?= number_format($sub['price'], 2) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <a href="/pages/services" class="btn btn-outline-secondary mt-4">Back to List</a>
        </div>
    </div>
</div>
</body>
</html>