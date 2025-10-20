<?php
/* By Abdullah As-Sadeed */

function Follow($to_profile_code)
{
    $connection = $GLOBALS['connection'];
    $my_profile_code = $GLOBALS['my_profile_code'];

    if (Check_Follow($my_profile_code, $to_profile_code)) {
        pg_query($connection, "DELETE FROM follows WHERE to_profile_code = '$to_profile_code' AND from_profile_code = '$my_profile_code';");

        $action = 'unfollowed';
    } else {
        $at = time();

        pg_query($connection, "INSERT INTO follows(to_profile_code, from_profile_code, at) VALUES('$to_profile_code', '$my_profile_code', '$at');");

        $action = 'followed';
    }

    $query_followers = pg_query($connection, "SELECT serial FROM follows WHERE to_profile_code = '$to_profile_code';");
    $followers_count = pg_num_rows($query_followers);

    if ($action == 'followed') {
        $query_follower_full_name = pg_query($connection, "SELECT full_name FROM users WHERE profile_code = '$my_profile_code';");
        while ($data_follower_full_name = pg_fetch_assoc($query_follower_full_name)) {
            $follower_full_name = $data_follower_full_name["full_name"];
        }

        Initiate_Push_Send($to_profile_code, 'Follower', $follower_full_name . ' followed you. Now you have ' . $followers_count . ' followers.', '', '');
    }

    $array = ['action' => $action, 'followers_count' => $followers_count];
    $json = json_encode($array);

    return $json;
}