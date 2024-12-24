<?php
/* By Abdullah As-Sadeed */

function Retrieve_Face_Logo_Time($profile_code)
{
    $connection = $GLOBALS['connection'];

    if (Check_User($profile_code)) {
        $query_last_face_logo_time = pg_query($connection, "SELECT last_face_logo FROM users WHERE profile_code = '$profile_code';");

        while ($data_last_face_logo_time = pg_fetch_assoc($query_last_face_logo_time)) {
            $last_face_logo_time = $data_last_face_logo_time['last_face_logo'];
        }

        return $last_face_logo_time;
    }
}
