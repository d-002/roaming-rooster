<?php
// the login state of user
session_start();
// a php file named "db"
require 'db.php';

// send request to by POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create objetc db
    $db = new DB();
    
    // get the username enter, reduce ambiguity in quotes
    $username = SQLite3::escapeString($_POST['username']);
    // get the password enter
    $password = $_POST['password'];
    // find user from the users_table by the "username"
    $result = $db->query("SELECT * FROM users WHERE username='$username'");
    // get value return
    $user = $result->fetchArray(SQLITE3_ASSOC);

    // user and password are verified
    if ($user && password_verify($password, $user['password'])) {
        // session has the username as state
        $_SESSION['user'] = $user['username'];
        // session has the id as state
        $_SESSION['user_id'] = $user['id']; 
        
        // find role from roles_table by the "user_id"
        $role_result = $db->query("SELECT role FROM roles WHERE user_id = {$user['id']}");
        // get value return
        $role_data = $role_result->fetchArray(SQLITE3_ASSOC);
        
        // if role present in the table
        if ($role_data) {
            // ensure role is integer
            $_SESSION['role'] = (int)$role_data['role'];
            // go to dashboard page
            header('Location: dashboard.php');
        } else {
            // if role not present in the table
            session_destroy();
            die("role not exist");
        }
        exit();
    } else {
        echo "username or password incorrect";
    }
}
?>