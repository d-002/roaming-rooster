<?php
function rootInclude($name)
{
    include $_SERVER["DOCUMENT_ROOT"] . $name;
}
