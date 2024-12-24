<?php
/* By Abdullah As-Sadeed */

function Evaluate_Registration()
{
    $connection = $GLOBALS['connection'];

    if (isset($_COOKIE['TeleChirkut_1']) && isset($_COOKIE['TeleChirkut_2'])) {
        $GLOBALS['my_profile_code'] = Sanitize_String($_COOKIE['TeleChirkut_1']);
        $my_profile_code = $GLOBALS['my_profile_code'];
        $token = Sanitize_String($_COOKIE['TeleChirkut_2']);

        $query_authentication = pg_query($connection, "SELECT profile_code FROM log_in_sessions WHERE profile_code = '$my_profile_code' AND token = '$token';");

        if (Check_User($my_profile_code) && pg_num_rows($query_authentication) == 1) {
            $return_value = true;
        } else {
            $includings_path = $GLOBALS['includings_path'];
            require_once $includings_path . 'Manually_Required/Logger_Out.php';

            Log_Out();
            $return_value = false;
        }
    } else {
        $return_value = false;
    }

    return $return_value;
}