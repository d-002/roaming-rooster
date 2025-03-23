<!DOCTYPE html>
<html lang="en">
<?php
require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";

component("header");

insertHeader("Welcome", ["inputs", "containers"]);
?>

<body>

<h1>Login Page (Test only)</h1>

<div class="text-center">
    <?php
    component("logo");
    ?>
</div>

<form class="container">
    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="uname" id="uname" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

    <button type="submit">Login As Seller</button>
    <button type="submit">Login As Customer</button>
    <button type="submit">Login As Administrator</button>
</form>

</body>
</html>
