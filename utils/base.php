<?php
function rootInclude($name): void
{
    include $_SERVER["DOCUMENT_ROOT"] . $name;
}

function component($name): void
{
    rootInclude("/components/" . $name . ".php");
}

function assertSession(): void
{
    session_start();
    if (!isset($_SESSION["connected"]) || !$_SESSION["connected"]) {
        session_destroy();
        die("You are not connected.");
    }
}
