<?php
/* By Abdullah As-Sadeed */

function Report_User($reported_profile_code)
{
    $connection = $GLOBALS['connection'];
    $my_profile_code = $GLOBALS['my_profile_code'];

    $at = time();

    pg_query($connection, "INSERT INTO reported_users(from_profile_code, reported_profile_code, at) VALUES('$my_profile_code', '$reported_profile_code', '$at');");

    $array = ['status' => 'Reported'];
    $json = json_encode($array);

    return $json;
}