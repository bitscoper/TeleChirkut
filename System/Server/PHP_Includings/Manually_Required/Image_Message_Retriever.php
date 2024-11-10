<?php
/* By Abdullah As-Sadeed */

function Retrieve_Image_Message($serial)
{
    $connection = $GLOBALS['connection'];
    $my_profile_code = $GLOBALS['my_profile_code'];
    $user_uploads_path = $GLOBALS['user_uploads_path'];

    $query_image_message = pg_query($connection, "SELECT profile_code, to_profile_code FROM messages WHERE serial = '$serial' AND type = 'image' AND (profile_code = '$my_profile_code' OR to_profile_code = '$my_profile_code');");

    if (pg_num_rows($query_image_message) == 1) {
        while ($data_image_message = pg_fetch_assoc($query_image_message)) {
            $from_profile_code = $data_image_message['profile_code'];
            $to_profile_code = $data_image_message['to_profile_code'];
        }

        if (Check_Users_Connection($my_profile_code, $from_profile_code) || Check_Users_Connection($my_profile_code, $to_profile_code)) {
            $file = $user_uploads_path . 'Image_Messages/Message_' . $serial . '.webp';

            if (file_exists($file)) {
                if (getimagesize($file)) {
                    $return = $file;
                } else {
                    $return = false;
                }
            } else {
                $return = false;
            }
        } else {
            $return = false;
        }

    } else {
        $return = false;
    }

    return $return;
}