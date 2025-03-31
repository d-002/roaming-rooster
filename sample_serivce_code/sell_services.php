<?php
// the login state of user
session_start();
// a php file named "db"
require 'db.php';

// if user is not login as seller, go to login page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 0) {
    header('Location: login.html');
    exit();
}
// Create objetc db
$db = new DB();
$current_user_id = $_SESSION['user_id'];

$stmt = $db->prepare('SELECT latitude, longitude FROM users WHERE id = :id');
$stmt->bindValue(':id', $current_user_id, SQLITE3_INTEGER);
$user_info = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

// delete services
if (isset($_GET['delete'])) {
    $service_id = (int)$_GET['delete'];
    $stmt = $db->prepare('DELETE FROM services WHERE id = :id AND user_id = :uid');
    $stmt->bindValue(':id', $service_id, SQLITE3_INTEGER);
    $stmt->bindValue(':uid', $current_user_id, SQLITE3_INTEGER);
    if ($stmt->execute()) {
        header('Location: sell_services.php');
        exit();
    }
}

// add services
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = SQLite3::escapeString(trim($_POST['title']));
    $description = SQLite3::escapeString(trim($_POST['description']));

    // text length of title
    if (empty($title) || strlen($title) > 100) {
        die("Title must be 1-100 characters");
    }
    // text length of description
    if (empty($description) || strlen($description) > 300) {
        die("Description must be 1-300 characters");
    }

    // renew or create services
    if (!empty($_POST['service_id'])) {
        $stmt = $db->prepare(' UPDATE services SET title=:title, description=:desc, latitude=:lat, longitude=:lng WHERE id=:id AND user_id=:uid ');
        $stmt->bindValue(':id', (int)$_POST['service_id'], SQLITE3_INTEGER);
    } else {
        $stmt = $db->prepare(' INSERT INTO services (user_id, title, description, latitude, longitude) VALUES (:uid, :title, :desc, :lat, :lng) ');
    }

    // bind the value to the field in the service_table
    $stmt->bindValue(':uid', $current_user_id, SQLITE3_INTEGER);
    $stmt->bindValue(':title', $title, SQLITE3_TEXT);
    $stmt->bindValue(':desc', $description, SQLITE3_TEXT);
    $stmt->bindValue(':lat', $user_info['latitude'], SQLITE3_FLOAT);
    $stmt->bindValue(':lng', $user_info['longitude'], SQLITE3_FLOAT);

    if ($stmt->execute()) {
        // Refresh the page
        header('Location: sell_services.php');
        exit();
    } else {
        die("Failed" . $db->lastErrorMsg());
    }
}

// get all services from services_table where user_id is euqal to current_user_id and sort by id
$stmt = $db->prepare('SELECT * FROM services WHERE user_id = :uid ORDER BY id DESC');
$stmt->bindValue(':uid', $current_user_id, SQLITE3_INTEGER);
$services = $stmt->execute();
?>

<!DOCTYPE html>
<html>
    <head>
        <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 20px auto; padding: 0 20px; }
        form { margin: 30px 0; }
        input, textarea { width: 100%; padding: 8px; margin: 5px 0 15px; border: 1px solid #ddd; display: block; }
        button { background: #4CAF50; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        .service-item { margin: 20px 0; padding: 15px; border: 1px solid #eee; }
        .meta { margin-top: 10px; color: #666; }
        .meta a { color: #4CAF50; margin-left: 15px; }
        </style>
    </head>

    <body>
        <h2>My Services</h2>
        <!-- editing the services -->
        <form method="post" onsubmit="disableSubmit(this)">
            <input type="hidden" name="service_id" value="<?= $_GET['edit'] ?? '' ?>">
            <input type="text" name="title" placeholder="Title" required>
            <textarea name="description" placeholder="Description" rows="4" required></textarea>
            <button type="submit">Submit</button>
        </form>
        
        <!-- display the services -->
        <div>
            <?php while ($service = $services->fetchArray(SQLITE3_ASSOC)): ?>
                <div class="service-item">
                    <h3><?= htmlspecialchars($service['title']) ?></h3>
                    <p><?= htmlspecialchars($service['description']) ?></p>
                    <div class="meta">
                        <span>Location: <?= $service['latitude'] ?>, <?= $service['longitude'] ?></span>
                        <a href="?delete=<?= $service['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
                        <a href="?edit=<?= $service['id'] ?>">Edit</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <!-- no repeat submit at one time -->
        <script>
        function disableSubmit(form) { const btn = form.querySelector('button[type="submit"]'); 
                                       btn.disabled = true; btn.textContent = 'Submitting...';
                                       return true;
        }
        </script>
        <!-- Go back to dashboard-->
        <p style="margin-top:30px"><a href="dashboard.php">Back to the dashboard</a></p>
    </body>
</html>