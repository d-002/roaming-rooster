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
// get all user from users_table and sort by id
$users = $db->query('SELECT * FROM users ORDER BY id DESC');

// get role_id/user_id/username/role from roles_table and users_table and sort by role_id
$roles = $db->query('SELECT r.id as role_id, r.user_id, r.role, u.username
                     FROM roles r LEFT JOIN users u ON r.user_id = u.id
                     ORDER BY r.id DESC');
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Database View</title>
        <style>
        body { font-family: Arial, sans-serif; padding: 20px; overflow-x: auto;}
        h2 { color: #2c3e50; }
        .table-container { margin: 40px 0; box-shadow: 0 1px 3px rgba(0,0,0,0.12); 
                           background: white; border-radius: 8px; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin: 25px 0; min-width: 800px; }
        th { background: #3498db; color: white; padding: 15px; text-align: left; }
        td { padding: 12px 15px; border-bottom: 1px solid #ddd; }
        .role-color { display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 0.9em; }
        .role-0 { background: #e67e22; color: white; }
        .role-1 { background: #27ae60; color: white; }
        </style>
    </head>
    
    <body>
        <h1>Database View</h1>
        <b>Currently logged in user: <?= htmlspecialchars($_SESSION['user']) ?></b>
        
        <div class="table-container">
            <h2>Users_table</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>username</th>
                        <th>display_name</th>
                        <th>password</th>
                        <th>email</th>
                        <th>verified_email</th>
                        <th>phone</th>
                        <th>theme_id</th>
                        <th>latitude</th>
                        <th>longitude</th>
                        <th>banned</th>
                    </tr>
                </thead>
                
                <tbody>
                    <!--use while loop to return all data in the user_table-->
                    <?php while ($user = $users->fetchArray(SQLITE3_ASSOC)): ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['display_name']) ?></td>
                            <!-- ensure password won't overlap -->
                            <td style="max-width: 200px; word-break: break-all;">
                                <?= htmlspecialchars($user['password']) ?>
                            </td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= $user['verified_email'] ? 'YES' : 'NO' ?></td>
                            <td><?= $user['phone'] ? htmlspecialchars($user['phone']) : '-' ?></td>
                            <td>Theme value: <?= $user['theme_id'] ?></td>
                            <td><?= $user['latitude'] ?></td>
                            <td><?= $user['longitude'] ?></td>
                            <td><?= $user['banned'] ? 'YES' : 'NO' ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        
        <div class="table-container">
            <h2>Roles_table</h2>
            <table>
                <thead>
                    <tr>
                        <th>Role_id</th>
                        <th>user_id</th>
                        <th>role</th>
                    </tr>
                </thead>
                <tbody>
                    <!--use while loop to return all data in the roles_table-->
                    <?php while ($role = $roles->fetchArray(SQLITE3_ASSOC)): ?>
                        <tr>
                            <td><?= $role['role_id'] ?></td>
                            <td><?= $role['user_id'] ?></td>
                            <td>
                                <span class="role-color role-<?= $role['role'] ?>">
                                    <?= ($role['role'] == 0) ? 'Seller' : 'Customer' ?>
                                    (<?= $role['role'] ?>)
                                </span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        
        <div style="text-align: center; margin-top: 40px;">
            <a href="dashboard.php" style=" text-decoration: none; padding: 10px 20px;
                                            background: #3498db; color: white; border-radius: 4px;">
            Go back to dashboard</a>
        </div>
    </body>
</html>