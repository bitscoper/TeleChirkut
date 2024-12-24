<?php
/* By Abdullah As-Sadeed */

function Check_Post($serial)
{
    $connection = $GLOBALS['connection'];

    $query_check_post = pg_query($connection, "SELECT serial FROM feedline WHERE serial = '$serial';");
    $rows_count = pg_num_rows($query_check_post);

    if ($rows_count == 1) {
        return true;
    } elseif ($rows_count == 0) {
        return false;
    }
}