<?php

function Delete_Post($serial)
{
    $connection = $GLOBALS['connection'];
    $my_profile_code = $GLOBALS['my_profile_code'];
    $user_uploads_path = $GLOBALS['user_uploads_path'];

    $query_post_ownership = pg_query($connection, "SELECT serial FROM feedline WHERE serial = '$serial' AND profile_code = '$my_profile_code';");

    if (pg_num_rows($query_post_ownership) == 1) {
        pg_query($connection, "DELETE FROM feedline WHERE serial = '$serial' AND profile_code = '$my_profile_code';");

        if (file_exists($user_uploads_path . 'Post_Images/FeedLine_' . $serial . '.webp')) {
            unlink($user_uploads_path . 'Post_Images/FeedLine_' . $serial . '.webp');
        }

        $deleted = true;
    } else {
        $deleted = false;
    }

    $array = ['deleted' => $deleted];
    $json = json_encode($array);

    return $json;
}