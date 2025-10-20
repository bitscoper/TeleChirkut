<?php
/* By Abdullah As-Sadeed */

function Report_Post($reported_post_serial)
{
    $connection = $GLOBALS['connection'];
    $my_profile_code = $GLOBALS['my_profile_code'];

    $at = time();

    pg_query($connection, "INSERT INTO reported_posts(from_profile_code, reported_post_serial, at) VALUES('$my_profile_code', '$reported_post_serial', '$at');");

    $array = ['status' => 'Reported'];
    $json = json_encode($array);

    return $json;
}