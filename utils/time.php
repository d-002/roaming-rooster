<?php
function now(): int
{
    return (new DateTime("now"))->getTimestamp();
}
?>
