<?php
require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";

if (session_status() === PHP_SESSION_NONE) session_start();
session_destroy();
header("Location: /pages/homepage");
?>
