<?php
/* By Abdullah As-Sadeed */

function Retrieve_Profile_Card($profile_code)
{
    $connection = $GLOBALS['connection'];
    $my_profile_code = $GLOBALS['my_profile_code'];

    $query_profile = pg_query($connection, "SELECT full_name, timezone, introduction, verification, note FROM users WHERE profile_code = '$profile_code';");

    while ($data_profile = pg_fetch_assoc($query_profile)) {
        $full_name = $data_profile['full_name'];
        $timezone = $data_profile['timezone'];
        $introduction = $data_profile['introduction'];

        if ($data_profile['verification'] == true) {
            $verification = true;
        } else {
            $verification = false;
        }

        $note = $data_profile['note'];
    }

    $query_followers_count = pg_query($connection, "SELECT serial FROM follows WHERE to_profile_code = '$profile_code';");
    $followers_count = pg_num_rows($query_followers_count);

    $query_posts_count = pg_query($connection, "SELECT serial FROM feedline WHERE profile_code = '$profile_code';");
    $posts_count = pg_num_rows($query_posts_count);

    $followed = Check_Follow($my_profile_code, $profile_code);

    $array = ['full_name' => $full_name, 'verified' => $verification, 'note' => $note, 'timezone' => $timezone, 'introduction' => $introduction, 'followers_count' => $followers_count, 'posts_count' => $posts_count, 'followed' => $followed];
    $json = json_encode($array);

    return $json;
}