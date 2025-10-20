<?php
/* By Abdullah As-Sadeed */

function Retrieve_Face_Logo($profile_code)
{
    $user_uploads_path = $GLOBALS['user_uploads_path'];

    if (Check_User($profile_code)) {
        $file = $user_uploads_path . 'Faces_Logos/Face_' . $profile_code . '_' . Retrieve_Face_Logo_Time($profile_code) . '.webp';

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