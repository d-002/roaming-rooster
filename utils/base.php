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

function has_session(): bool {
    start_secure_session();
    return isset($_SESSION["connected"]) && $_SESSION["connected"];
}

function assert_session(): void
{
    if (!has_session()) {
        session_destroy();
        header("Location: /pages/login");
        die("You are not connected.");
    }
}

