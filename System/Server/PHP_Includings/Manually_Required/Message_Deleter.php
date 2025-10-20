<?php
/* By Abdullah As-Sadeed */

function Delete_Message($serial)
{
    $connection = $GLOBALS['connection'];
    $my_profile_code = $GLOBALS['my_profile_code'];
    $user_uploads_path = $GLOBALS['user_uploads_path'];

    $query_message_association = pg_query($connection, "SELECT type FROM messages WHERE serial = '$serial' AND (profile_code = '$my_profile_code' OR to_profile_code = '$my_profile_code');");

    if (pg_num_rows($query_message_association) == 1) {
        pg_query($connection, "DELETE FROM messages WHERE serial = '$serial' AND (profile_code = '$my_profile_code' OR to_profile_code = '$my_profile_code');");

        if (file_exists($user_uploads_path . 'Image_Messages/Message_' . $serial . '.webp')) {
            unlink($user_uploads_path . 'Image_Messages/Message_' . $serial . '.webp');
        }
        $deleted = true;
    }
    else {
        $deleted = false;
    }

    $array = ['deleted' => $deleted];
    $json = json_encode($array);

    return $json;
}