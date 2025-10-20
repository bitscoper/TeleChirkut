<?php
/* By Abdullah As-Sadeed */

function Clean()
{
    $user_uploads_path = $GLOBALS['user_uploads_path'];

    $files_count = 0;

    foreach (glob($user_uploads_path . 'Faces_Logos/*.webp') as $faces_logos) {
        preg_match_all('/.*?(?<no>\d+).*?\.(?<ext>.*)/u', $faces_logos, $matches, PREG_SET_ORDER, 0);

        $file_name = $matches[0][0];

        $profile_code = $matches[0]['no'];

        if (!Check_User($profile_code)) {
            unlink($file_name);

            $files_count++;
        }
    }

    $matches = null;

    foreach (glob($user_uploads_path . 'Post_Images/*.webp') as $post_images) {
        preg_match_all('/.*?(?<no>\d+).*?\.(?<ext>.*)/u', $post_images, $matches, PREG_SET_ORDER, 0);

        $file_name = $matches[0][0];

        $serial = $matches[0]['no'];

        if (!Check_Post($serial)) {
            unlink($file_name);

            $fifiles_countles++;
        }
    }

    $array = ['files' => $files_count];
    $json = json_encode($array);

    return $json;
}