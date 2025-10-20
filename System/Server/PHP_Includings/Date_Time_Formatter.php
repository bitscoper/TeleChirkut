<?php
/* By Abdullah As-Sadeed */

function Get_TimeZone_Offset($timezone)
{
    $user_timezone = new DateTimeZone($timezone);
    $current_time = new DateTime("now", new DateTimeZone("UTC"));
    return $user_timezone->getOffset($current_time);
}

function Format_Date_Time($given_time)
{
    $current_time = time();

    $connection = $GLOBALS['connection'];
    $my_profile_code = $GLOBALS['my_profile_code'];

    $query_timezone = pg_query($connection, "SELECT timezone FROM users WHERE profile_code = '$my_profile_code';");
    while ($data_timezone = pg_fetch_assoc($query_timezone)) {
        $timezone = $data_timezone["timezone"];
    }

    $seconds = $current_time - $given_time; /* Both in UTC */
    $minutes = round($seconds / 60);

    if ($seconds <= 1) {
        return 'Just now';
    } elseif ($seconds < 60) {
        return $seconds . ' seconds ago';
    } elseif ($minutes < 60) {
        if ($minutes == 1) {
            return '1 minute ago';
        } else {
            return $minutes . ' minutes ago';
        }
    } elseif (round($seconds / 3600) < 24) {
        $user_time = $given_time + Get_TimeZone_Offset($timezone);

        return date('g:i A', $user_time);
    } elseif (round($seconds / 86400) == 1) {
        $user_time = $given_time + Get_TimeZone_Offset($timezone);

        return 'Yesterday ' . date('g:i A', $user_time);
    } else {
        $user_time = $given_time + Get_TimeZone_Offset($timezone);

        return date('j M Y g:i A', $user_time);
    }
}