<?php
/* By Abdullah As-Sadeed */

function Retrieve_Post_Details($serial)
{
    $connection = $GLOBALS['connection'];

    $reactions = [];

    $query_reacters = pg_query($connection, "SELECT type, from_profile_code, at FROM post_reactions WHERE feedline_serial = '$serial';");

    while ($data_reacters = pg_fetch_assoc($query_reacters)) {
        $reaction = $data_reacters['type'];
        $from_profile_code = $data_reacters['from_profile_code'];
        $date_time = Format_Date_Time($data_reacters['at']);

        $query_full_name = pg_query($connection, "SELECT full_name FROM users WHERE profile_code = '$from_profile_code';");

        while ($data_full_name = pg_fetch_assoc($query_full_name)) {
            $full_name = $data_full_name['full_name'];
        }

        $reactions[] = ['from_profile_code' => $from_profile_code, 'full_name' => $full_name, 'reaction' => $reaction, 'date_time' => $date_time];
    }

    $array = ['reactions' => $reactions];
    $json = json_encode($array);

    return $json;
}
