<?php
class DB extends SQLite3 {
    function __construct() {
        // This will create a database named "users", it is in the folder called "db"
        $this->open('db/users.db');
        // This allows the database connect to others
        $this->exec('PRAGMA foreign_keys = ON;');

        // Create a table named "users"
        $this->exec('CREATE TABLE IF NOT EXISTS users(
            -- id, stored as Integer, Primary key, value increase automatically
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            -- username, stored as text, used to login, unique, cannot be empty
            username TEXT UNIQUE NOT NULL,
            -- the name shown in the webpage, stored as text
            display_name TEXT,
            -- password used to login, stored as text, cannot be empty
            password TEXT NOT NULL,
            -- email used to register, unique, cannot be empty
            email TEXT UNIQUE NOT NULL,
            -- check whether email is register already or not, stored as true or false, default value 0
            verified_email BOOLEAN DEFAULT 0,
            -- send message to user if necessary, stored as text, can be empty
            phone TEXT,
            -- the location of user, it should stored as float(24)
            latitude REAL DEFAULT (RANDOM() % 181),
            -- the location of user, it should stored as float(24)
            longitude REAL DEFAULT (RANDOM() % 181),
            -- the image of user, it should stored as Integer, it should connect to the theme_table
            theme_id INTEGER DEFAULT (RANDOM() % 10),
            -- check whether user is banned or not, stored as true or false, default value 0
            banned BOOLEAN DEFAULT 0
        )');

        // Create a table named "roles"
        $this->exec('CREATE TABLE IF NOT EXISTS roles(
            -- id, stored as Integer, Primary key, value increase automatically
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            -- user_id, connecting to the users_table
            user_id INTEGER NOT NULL UNIQUE,
            -- role stored as Integer, cannot be empty, 0 is seller, 1 is customer, adminitrator is not present yet
            role INTEGER NOT NULL CHECK(role IN (0, 1)),
            -- connect to user_table by users_id, delete role if user deleted
            FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
        )');

        // Create a table named "services"
        $this->exec('CREATE TABLE IF NOT EXISTS services(
            -- -- id, stored as Integer, Primary key, value increase automatically
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            -- user_id, connecting to the users_table, then connect to roles_table
            user_id INTEGER NOT NULL,
            -- the image of user, it should stored as Integer, it should connect to the theme_table
            theme_id INTEGER DEFAULT 1,
            -- title of service, stored as text, cannot be null
            title TEXT NOT NULL,
            -- description of service, stored as text, cannot be null
            description TEXT NOT NULL,
            -- location of seller
            latitude REAL NOT NULL,
            -- location of seller
            longitude REAL NOT NULL,
            -- connect to user_table by users_id, delete services if user deleted
            FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
        )');
    }
}
?>