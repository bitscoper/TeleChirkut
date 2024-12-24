<?php
/* By Abdullah As-Sadeed */

function Sanitize_String($string)
{
    $connection = $GLOBALS['connection'];

    $string = pg_escape_string($connection, $string);
    $string = trim($string);

    return $string;
}