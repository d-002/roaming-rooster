<?php
require 'db_connect.php';

try {
    $stmt = $pdo->query("SELECT * FROM services");
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h1 class="mb-4 text-center">Available Services</h1>
        <div class="row g-4">
            <?php foreach ($services as $service): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($service['title']) ?></h5>
                            <p class="card-text text-muted"><?= htmlspecialchars(substr($service['description'], 0, 80)) ?>...</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">Provider: Seller<?= $service['user_id'] ?></small>
                                <a href="service_detail.php?id=<?= $service['ID'] ?>" class="btn btn-sm btn-primary">Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>