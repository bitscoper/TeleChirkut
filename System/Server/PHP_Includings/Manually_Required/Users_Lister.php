<?php
/* By Abdullah As-Sadeed */

function List_Users($users)
{
    $connection = $GLOBALS['connection'];
    $my_profile_code = $GLOBALS['my_profile_code'];

    $profile_codes = [];

    if ($users == 'Explore') {
        $query_users = pg_query($connection, "SELECT profile_code FROM users WHERE NOT profile_code = '$my_profile_code' ORDER BY full_name ASC;");
    }
    elseif ($users == 'Followings') {
        $query_users = pg_query($connection, "SELECT profile_code FROM users WHERE profile_code IN (SELECT to_profile_code FROM follows WHERE from_profile_code = '$my_profile_code') ORDER BY full_name ASC;");
    }
    elseif ($users == 'Followers') {
        $query_users = pg_query($connection, "SELECT profile_code FROM users WHERE profile_code IN (SELECT from_profile_code FROM follows WHERE to_profile_code = '$my_profile_code') ORDER BY full_name ASC;");
    }
    elseif ($users == 'Connections') {
        $query_users = pg_query($connection, "SELECT profile_code FROM users WHERE profile_code IN (SELECT to_profile_code FROM follows WHERE from_profile_code = '$my_profile_code') AND profile_code IN (SELECT from_profile_code FROM follows WHERE to_profile_code = '$my_profile_code') AND NOT profile_code = '$my_profile_code' ORDER BY full_name ASC;");
    }

    while ($data_users = pg_fetch_assoc($query_users)) {
        $profile_codes[] = $data_users['profile_code'];
    }

    $array = ['profile_codes' => $profile_codes];
    $json = json_encode($array);

    return $json;
}