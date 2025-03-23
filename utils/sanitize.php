<?php

function isEmail($email): bool
{
    return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
}
