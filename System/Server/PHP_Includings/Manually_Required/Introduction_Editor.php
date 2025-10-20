<?php
/* By Abdullah As-Sadeed */

function Edit_Introduction($introduction)
{
    $connection = $GLOBALS['connection'];
    $my_profile_code = $GLOBALS['my_profile_code'];

    pg_query($connection, "UPDATE users SET introduction = '$introduction' WHERE profile_code = '$my_profile_code';");

    $array = ['edited' => true];
    $json = json_encode($array);

    return $json;
}