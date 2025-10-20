<?php
/* By Abdullah As-Sadeed */

function Retrieve_Post($serial)
{
    $connection = $GLOBALS['connection'];
    $registration = $GLOBALS['registration'];
    $my_profile_code = $GLOBALS['my_profile_code'];

    $query_post = pg_query($connection, "SELECT profile_code, text, image, at FROM feedline WHERE serial = '$serial';");

    while ($data_post = pg_fetch_assoc($query_post)) {
        $profile_code = $data_post['profile_code'];

        $query_full_name_verification = pg_query($connection, "SELECT full_name, verification FROM users WHERE profile_code = '$profile_code';");

        while ($data_full_name_verification = pg_fetch_assoc($query_full_name_verification)) {
            $full_name = $data_full_name_verification['full_name'];
            $verified = $data_full_name_verification['verification'];

            if ($verified == true) {
                $is_profile_verified = true;
            } else {
                $is_profile_verified = false;
            }
        }

        if ($registration) {
            if ($profile_code == $my_profile_code) {
                $owner = 'Me';
            } else {
                $owner = 'Other';
            }
        } else {
            $owner = '';
        }

        $text = $data_post['text'];

        if ($data_post['image'] == true) {
            $image_available = true;
        } else {
            $image_available = false;
        }

        $query_reactions = pg_query($connection, "SELECT type FROM post_reactions WHERE feedline_serial = '$serial';");

        $reactions_count = pg_num_rows($query_reactions);

        if ($reactions_count == 0) {
            $reactions_count = '';
        } elseif ($reactions_count == 1) {
            $reactions_count = '1 reaction';
        } else {
            $reactions_count .= ' reactions';
        }

        $date_time = Format_Date_Time($data_post['at']);

        if ($profile_code !== $my_profile_code) {
            $query_reacted = pg_query($connection, "SELECT type FROM post_reactions WHERE feedline_serial = '$serial' AND from_profile_code = '$my_profile_code';");

            while ($data_reacted = pg_fetch_assoc($query_reacted)) {
                $reacted = $data_reacted['type'];
            }
        } else {
            $reacted = '';
        }
    }

    $array = ['profile_code' => $profile_code, 'full_name' => $full_name, 'is_profile_verified' => $is_profile_verified, 'owner' => $owner, 'text' => $text, 'image_available' => $image_available, 'reactions_count' => $reactions_count, 'date_time' => $date_time, 'reacted' => $reacted];
    $json = json_encode($array);

    return $json;
}