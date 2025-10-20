<?php
/* By Abdullah As-Sadeed */

function Retrieve_Notifications()
{
    $connection = $GLOBALS['connection'];
    $my_profile_code = $GLOBALS['my_profile_code'];

    $notifications = [];

    $query_notifications = pg_query($connection, "SELECT 'followed' AS type, from_profile_code, NULL AS feedline_serial, at FROM follows WHERE to_profile_code = '$my_profile_code' UNION ALL SELECT type, from_profile_code, feedline_serial, at FROM post_reactions WHERE feedline_serial IN (SELECT serial FROM feedline WHERE profile_code = '$my_profile_code') ORDER BY at DESC;");

    if (pg_num_rows($query_notifications) !== 0) {
        while ($data_notifications = pg_fetch_assoc($query_notifications)) {
            $type = $data_notifications['type'];
            $from_profile_code = $data_notifications['from_profile_code'];
            $feedline_serial = $data_notifications['feedline_serial'];
            $date_time = Format_Date_Time($data_notifications['at']);

            $query_full_name = pg_query($connection, "SELECT full_name FROM users WHERE profile_code = '$from_profile_code';");

            while ($data_full_name = pg_fetch_assoc($query_full_name)) {
                $full_name = $data_full_name['full_name'];
            }

            $notifications[] = ['type' => $type, 'from_profile_code' => $from_profile_code, 'full_name' => $full_name, 'feedline_serial' => $feedline_serial, 'date_time' => $date_time];
        }
        pg_query($connection, "UPDATE follows SET seen = TRUE WHERE to_profile_code = '$my_profile_code';");
        pg_query($connection, "UPDATE post_reactions SET seen = TRUE WHERE feedline_serial IN (SELECT serial FROM feedline WHERE profile_code = '$my_profile_code');");
    }

    $array = ['notifications' => $notifications];
    $json = json_encode($array);

    return $json;
}