<?php
/* By Abdullah As-Sadeed */

function End_Another_Session($serial)
{
    $connection = $GLOBALS['connection'];
    $my_profile_code = $GLOBALS['my_profile_code'];

    $token = Sanitize_String($_COOKIE['TeleChirkut_2']);

    $query_check_current_session = pg_query($connection, "SELECT serial FROM log_in_sessions WHERE serial = '$serial' AND profile_code = '$my_profile_code' AND token = '$token';");

    if (pg_num_rows($query_check_current_session) == 0) {
        pg_query($connection, "UPDATE log_in_sessions SET token = NULL, push_json = NULL WHERE profile_code = '$my_profile_code' AND serial = '$serial';");

        $ended = true;
        $error = '';


        $array = ['ended' => $ended, 'error' => $error];
        $json = json_encode($array);

        return $json;
    }
}