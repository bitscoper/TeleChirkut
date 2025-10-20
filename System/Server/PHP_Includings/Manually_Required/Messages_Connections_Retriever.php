<?php
/* By Abdullah As-Sadeed */

function Retrieve_Messages_Connections()
{
    $connection = $GLOBALS['connection'];
    $my_profile_code = $GLOBALS['my_profile_code'];

    $connections = [];

    $query_connections = pg_query($connection, "SELECT profile_code, full_name FROM users WHERE profile_code IN (SELECT to_profile_code FROM follows WHERE from_profile_code = '$my_profile_code') AND profile_code IN (SELECT from_profile_code FROM follows WHERE to_profile_code = '$my_profile_code') AND NOT profile_code = '$my_profile_code' ORDER BY full_name ASC;");

    while ($data_user = pg_fetch_assoc($query_connections)) {
        $profile_code = $data_user['profile_code'];
        $full_name = $data_user['full_name'];

        $query_unseen_messages = pg_query($connection, "SELECT serial FROM messages WHERE to_profile_code = '$my_profile_code' AND profile_code = '$profile_code' AND NOT seen = TRUE;");
        $unseen_count = pg_num_rows($query_unseen_messages);

        $connections[] = ['profile_code' => $profile_code, 'full_name' => $full_name, 'unseen_count' => $unseen_count];
    }

    $array = ['connections' => $connections];
    $json = json_encode($array);

    return $json;
}