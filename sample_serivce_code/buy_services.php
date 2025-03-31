<?php
// the login state of user
session_start();
// a php file named "db"
require 'db.php';

// if user is not login as customer, go to login page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 1) {
    header('Location: login.html');
    exit();
}
// Create objetc db
$db = new DB();

// get all services/seller_name/location from services_table and users_table and sort by service_id
$services = $db->query('
    SELECT s.*, u.display_name AS seller, u.latitude AS seller_lat, u.longitude AS seller_lng
    FROM services s LEFT JOIN users u ON s.user_id = u.id
    ORDER BY s.id DESC
');
?>

<!DOCTYPE html>
<html>
    <style>
    .service-card { border: 1px solid #ddd; padding: 15px; margin: 10px 0; border-radius: 8px; }
    .seller-info { color: #666; margin-top: 10px; }
    </style>
    
    <body>
        <h2>All Services</h2>
        <!--use while loop to return all data in the services_table-->
        <?php while ($service = $services->fetchArray(SQLITE3_ASSOC)): ?>
        <div class="service-card">
            <!-- the title and description of services -->
            <h3><?= htmlspecialchars($service['title']) ?></h3>
            <p><?= htmlspecialchars($service['description']) ?></p>                        
                        
            <div class="meta">
                <div class="seller-info">
                    <!-- the name and location of the seller -->
                    <span>Seller: <?= htmlspecialchars($service['seller']) ?></span>
                    <span>Location: <?= $service['seller_lat'] ?>, <?= $service['seller_lng'] ?></span>
                </div>
            </div>
        </div>
        <!-- end the while loop -->
        <?php endwhile; ?>
        <!-- Go back to dashboard-->
        <p><a href="dashboard.php">Back to the Dashboard</a></p>
    </body>
</html>