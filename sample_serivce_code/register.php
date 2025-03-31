<?php
// a php file named "db"
require 'db.php';

// send request to by POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Create objetc db
        $db = new DB();
        
        // no space, reduce ambiguity in quotes for username
        $username = SQLite3::escapeString(trim($_POST['username']));
        // no space, reduce ambiguity in quotes foor display_name
        $display_name = SQLite3::escapeString(trim($_POST['display_name']));
        // no space, reduce ambiguity in quotes, all lower case for email
        $email = SQLite3::escapeString(strtolower(trim($_POST['email'])));
        // only number is allowed to input for phone
        $phone = preg_replace('/[^0-9]/', '', $_POST['phone']);
        // turn seller to 0, customer to 1, default value -1 for role
        $role = isset($_POST['role']) ? (int)$_POST['role'] : -1;

        // Generate the value for location
        $latitude = mt_rand(0, 180);
        $longitude = mt_rand(0, 180);
        
        // This should connect to the theme_table
        $theme_id = mt_rand(0, 10);

        // Password encryption
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // The email must in correct form
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email address");
        }

        // Seller is 0, Customer is 1, Administrator cannot be choose
        if (!in_array($role, [0, 1])) {
            throw new Exception("Choose your role: Seller/Customer");
        }
        // Phone number is necessary
        if (empty($phone)) {
            throw new Exception("You must enter the phone");
        }

        // username and email cannot repeat, it is unique
        $check_user = $db->querySingle("SELECT username FROM users WHERE username='$username'");
        $check_email = $db->querySingle("SELECT email FROM users WHERE email='$email'");
        
        //check duplication
        if ($check_user) throw new Exception("username already exist");
        //check duplication
        if ($check_email) throw new Exception("email already exist");

        // Start transaction
        $db->exec('BEGIN TRANSACTION');

        // Insert users_table
        $userStmt = $db->prepare('
            INSERT INTO users (username, display_name, password, email, phone, latitude, longitude, theme_id)
            VALUES (:user, :dname, :pass, :email, :phone, :lat, :lng, :theme)
        ');
        
        // bind the value to the field in the user_table
        $userStmt->bindValue(':user', $username, SQLITE3_TEXT);
        $userStmt->bindValue(':dname', $display_name, SQLITE3_TEXT);
        $userStmt->bindValue(':pass', $password, SQLITE3_TEXT);
        $userStmt->bindValue(':email', $email, SQLITE3_TEXT);
        $userStmt->bindValue(':phone', $phone, SQLITE3_TEXT);
        $userStmt->bindValue(':lat', $latitude, SQLITE3_FLOAT);
        $userStmt->bindValue(':lng', $longitude, SQLITE3_FLOAT);
        $userStmt->bindValue(':theme', $theme_id, SQLITE3_INTEGER);
        
        // insert user_table, failed if already exist
        if (!$userStmt->execute()) {
            throw new Exception("Register Failed" . $db->lastErrorMsg());
        }

        // get user_id last insert
        $user_id = $db->lastInsertRowID();

        // insert roles_table
        $roleStmt = $db->prepare('
            INSERT INTO roles (user_id, role) 
            VALUES (:uid, :role)
        ');
        // bind the value to the field in the roles_table
        $roleStmt->bindValue(':uid', $user_id, SQLITE3_INTEGER);
        $roleStmt->bindValue(':role', $role, SQLITE3_INTEGER);
        
        // if user_id is not available, failed to create role
        if (!$roleStmt->execute()) {
            throw new Exception("Failed to create role: " . $db->lastErrorMsg());
        }

        // Submite transaction
        $db->exec('COMMIT');

        // Go to login page if register successed
        header('Location: login.html');
        exit();

    } catch (Exception $e) {
        // Rollback if failed
        if ($db) $db->exec('ROLLBACK');
        die("Registed Failed: " . $e->getMessage());
    }
}
?>