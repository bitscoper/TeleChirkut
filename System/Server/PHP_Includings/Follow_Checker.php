<?php
/* By Abdullah As-Sadeed */

function Check_Follow($from_profile_code, $to_profile_code)
{
    $connection = $GLOBALS['connection'];

    if ($from_profile_code !== $to_profile_code) {
        if (Check_User($from_profile_code) && Check_User($to_profile_code)) {

            $query_check_follow = pg_query($connection, "SELECT serial FROM follows WHERE from_profile_code = '$from_profile_code' AND to_profile_code = '$to_profile_code';");
            $rows_count = pg_num_rows($query_check_follow);

            if ($rows_count == 1) {
                return true;
            } elseif ($rows_count == 0) {
                return false;
            }
        }
    }
}