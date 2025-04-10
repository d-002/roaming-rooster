<?php
session_start();

// User is login
if (!isset($_SESSION['username'])) {
    header("Location: /login.php");
    exit;
}

// All parameter should present
if (!isset($_POST['product_id']) || !isset($_POST['price'])) {
    $_SESSION['purchase_error'] = "Invalid request.";
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}

// the value of price, calculate in decimal
$price = (float)$_POST['price'];
$productId = (int)$_POST['product_id'];

// No services is negate price
if ($price <= 0) {
    $_SESSION['purchase_error'] = "This service cannot be purchased.";
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}

// Enough balance to buy services
if (!isset($_SESSION['money']) || $_SESSION['money'] < $price) {
    $_SESSION['purchase_error'] = "Insufficient balance. Current balance: $" . ($_SESSION['money'] ?? 0);
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}

// Take away money by price
$_SESSION['money'] -= $price;

// Purchase successed
$_SESSION['purchase_success'] = "Purchase successful! Deducted: $" . number_format($price, 2) . ". Remaining balance: $" . number_format($_SESSION['money'], 2);

// Go back to previous page
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
