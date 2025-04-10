<?php
session_start();

// Enter the movey
if (!isset($_POST['amount']) || empty($_POST['amount'])) {
  $_SESSION['error'] = "Enter money";
  header("Location: /profile.php");
  exit;
}

// Only number is allowed
$amount = floatval($_POST['amount']);
if ($amount <= 0) {
  $_SESSION['error'] = "The value must greater 0";
  header("Location: /profile.php");
  exit;
}

// Renew the amount of money
$_SESSION['money'] += $amount;

// Error message
unset($_SESSION['error']);

// Finished top up, go back to profile page
header("Location: /pages/profile");
exit;
