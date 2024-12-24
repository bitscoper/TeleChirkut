<?php
/* By Abdullah As-Sadeed */

function Retrieve_Unseen_Counts($profile_code)
{
    $connection = $GLOBALS['connection'];

    $query_unseen_messages = pg_query($connection, "SELECT serial FROM messages WHERE to_profile_code = '$profile_code' AND NOT seen = TRUE;");
    $messages = pg_num_rows($query_unseen_messages);

    $query_unseen_follows = pg_query($connection, "SELECT serial FROM follows WHERE to_profile_code = '$profile_code' AND NOT seen = TRUE;");
    $notifications = pg_num_rows($query_unseen_follows);

    $query_unseen_post_reactions = pg_query($connection, "SELECT serial FROM post_reactions WHERE feedline_serial IN (SELECT serial FROM feedline WHERE profile_code = '$profile_code') AND NOT seen = TRUE;");
    $notifications += pg_num_rows($query_unseen_post_reactions);

    $array = ['messages' => $messages, 'notifications' => $notifications];
    $json = json_encode($array);

    return $json;
}