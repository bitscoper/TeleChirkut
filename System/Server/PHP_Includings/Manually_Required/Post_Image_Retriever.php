<?php
/* By Abdullah As-Sadeed */

function Retrieve_Post_Image($serial)
{
    $connection = $GLOBALS['connection'];
    $user_uploads_path = $GLOBALS['user_uploads_path'];

    $query_serial = pg_query($connection, "SELECT serial FROM feedline WHERE serial = '$serial' AND image = TRUE;");

    if (pg_num_rows($query_serial) == 1) {
        $file = $user_uploads_path . 'Post_Images/FeedLine_' . $serial . '.webp';

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

    return $return;
}