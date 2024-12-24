<?php
/* By Abdullah As-Sadeed */

function Subscribe_Push($push_json)
{
    $connection = $GLOBALS['connection'];
    $my_profile_code = $GLOBALS['my_profile_code'];

    $token = Sanitize_String($_COOKIE['TeleChirkut_2']);

    pg_query($connection, "UPDATE log_in_sessions SET push_json = '$push_json' WHERE profile_code = '$my_profile_code' AND token = '$token';");
}
