<?php
function root_include($name): void
{
    include $_SERVER["DOCUMENT_ROOT"] . $name;
}

function component($name): void
{
    root_include("/components/" . $name . ".php");
}

function assert_session(): void
{
    session_start();
    if (!isset($_SESSION["connected"]) || !$_SESSION["connected"]) {
        session_destroy();
        header("Location: /pages/login");
        die("You are not connected.");
    }
}

