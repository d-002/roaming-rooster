<?php
function root_include($name): void
{
    include $_SERVER["DOCUMENT_ROOT"] . $name;
}

function component($name): void
{
    root_include("/components/" . $name . ".php");
}

function start_secure_session(): void {
    if (session_status() === PHP_SESSION_NONE) session_start();
}

function assert_session(): void
{
    start_secure_session();

    if (!isset($_SESSION["connected"]) || !$_SESSION["connected"]) {
        session_destroy();
        header("Location: /pages/login");
        die("You are not connected.");
    }
}

