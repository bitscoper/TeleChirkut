<?php
/* By Abdullah As-Sadeed */

function Log_Out()
{
    $connection = $GLOBALS['connection'];
    $my_profile_code = $GLOBALS['my_profile_code'];

    $token = Sanitize_String($_COOKIE['TeleChirkut_2']);
    pg_query($connection, "UPDATE log_in_sessions SET token = NULL, push_json = NULL WHERE profile_code = '$my_profile_code' AND token = '$token';");

    setcookie('TeleChirkut_1', '', time() - 86400, '/', 'telechirkut.bitscoper.dev', true, true);
    setcookie('TeleChirkut_2', '', time() - 86400, '/', 'telechirkut.bitscoper.dev', true, true);

    $array = ['logged_out' => true];
    $json = json_encode($array);

    return $json;
}
