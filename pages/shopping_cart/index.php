<?php
require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";
root_include("/utils/dbutils.php");

assert_session();
component("header");
component("service");

try {
    $database = getSecureDB();

    $stmt = $database->prepare("
        SELECT 
            s.title AS service_title, 
            ss.id, 
            ss.title, 
            ss.description, 
            ss.price 
        FROM sub_services ss
        JOIN services s ON ss.service_id = s.id
    ");
    $stmt->execute();
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="en">
<?php
insertHeader("Shopping Cart");
?>

<body class="bg-light">
<div class="container py-5 text-center">
    <h1>This is the Shopping Cart for <?= htmlspecialchars($_SESSION['username']) ?></h1>

    <div class="row">
        <?php foreach ($services as $service): ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($service['service_title']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($service['description']) ?></p>
                        <p>$<?= number_format($service['price'], 2) ?></p>
                        <button class="btn btn-primary add-to-cart" data-price="<?= htmlspecialchars($service['price']) ?>">Add to Cart</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<a href="/pages/signout">Log out</a>

<script src="/assets/scripts/add_to_cart.js"></script>


</body>
</html>