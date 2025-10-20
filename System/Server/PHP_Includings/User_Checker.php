<?php
/* By Abdullah As-Sadeed */

function Check_User($profile_code)
{
    $connection = $GLOBALS['connection'];

    $query_check_user = pg_query($connection, "SELECT profile_code FROM users WHERE profile_code = '$profile_code';");
    $rows_count = pg_num_rows($query_check_user);

    if ($rows_count == 1) {
        return true;
    } elseif ($rows_count == 0) {
        return false;
    }
}