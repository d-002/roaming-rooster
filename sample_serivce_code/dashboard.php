<?php
// the login state of user
session_start();
// if user is not login, go to login page
if (!isset($_SESSION['user'])) {
    header('Location: login.html');
    exit();
}

// a php file named "db"
require 'db.php';
// Create objetc db
$db = new DB();

// if session don't have role, go to users_table
if (!isset($_SESSION['role'])) {
    // get the username, reduce ambiguity in quotes
    $username = SQLite3::escapeString($_SESSION['user']);
    // get user_id from users_table by the "user_name"
    $user = $db->querySingle("SELECT id FROM users WHERE username = '$username'", true);
    
    // if user present
    if ($user) {
        // get role from roles_table by the "user_id"
        $role = $db->querySingle("SELECT role FROM roles WHERE user_id = {$user['id']}");
        // session should have the role now
        $_SESSION['role'] = (int)$role;
        // session should have the user_id now
        $_SESSION['user_id'] = $user['id'];
    } else {
        // session cannot find the role, clear the state, go to login page
        session_destroy();
        header('Location: login.html');
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Dashboard</title>
        <style>
        .dashboard { max-width: 600px; margin: 50px auto; text-align: center; }
        .btn-group { display: grid; gap: 20px; margin-top: 30px; }
        .btn { padding: 15px 30px; border-radius: 5px; text-decoration: none; color: white; transition: opacity 0.3s; }
        .btn-primary { background: #4CAF50; }
        </style>
    </head>
    
    <body>
        <div class="dashboard">
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h2>            
            <div class="btn-group">
            <!-- go to databse page  -->            
            <a href="database.php" class="btn btn-primary">View All Users and Roles table</a>
            <!-- if session has role as seller(0), go to Sell Service page  -->            
            <?php if ($_SESSION['role'] === 0): ?>
            <a href="sell_services.php" class="btn btn-primary">Sell Services</a>
            <!-- if session has role as customer(1), go to Buy Service page  -->  
            <?php elseif ($_SESSION['role'] === 1): ?>
            <a href="buy_services.php" class="btn btn-primary">Buy Services</a>
            <!-- Administrator not exist -->
            <?php elseif ($_SESSION['role'] === 2): ?>
            <!-- if role other than 0,1,2 present-->
            <?php else: ?>
            <div class="btn btn-primary">Invalid role</div>
            <!-- stop -->
            <?php endif; ?>           
            </div>
            
            <p style="margin-top: 30px;"> <a href="logout.php" style="color: #666; text-decoration: none;">Logout</a></p>
        </div>
    </body>
</html>