<?php
// the login state of user
session_start();
// the logot state of user
session_destroy();
// go to login page
header('Location: login.html');
?>