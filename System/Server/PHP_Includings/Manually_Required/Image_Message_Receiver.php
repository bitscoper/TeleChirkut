<?php
/* By Abdullah As-Sadeed */

function Receive_Image_Message($to_profile_code, $image)
{
    $connection = $GLOBALS['connection'];
    $my_profile_code = $GLOBALS['my_profile_code'];
    $user_uploads_path = $GLOBALS['user_uploads_path'];

    if (Check_Users_Connection($my_profile_code, $to_profile_code)) {
        if (getimagesize($image)) {
            $at = time();

            $query = pg_query($connection, "INSERT INTO messages(profile_code, to_profile_code, type, message, at) VALUES ('$my_profile_code', '$to_profile_code', 'image', '', '$at') RETURNING serial;");

            $serial = pg_fetch_result($query, 0, 'serial');

            Process_Image($image, 512, -1, $user_uploads_path . 'Image_Messages/Message_' . $serial . '.webp');

        } else {
            return 'It is not an image!';
        }
    }
}