<?php
function rootInclude($name)
{
    include $_SERVER["DOCUMENT_ROOT"] . $name;
}

function component($name)
{
    rootInclude("/components/" . $name . ".php");
}

