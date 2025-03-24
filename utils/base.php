<?php
function rootInclude($name): void
{
    include $_SERVER["DOCUMENT_ROOT"] . $name;
}

function component($name): void
{
    rootInclude("/components/" . $name . ".php");
}

