<?php
/* By Abdullah As-Sadeed */

function Receive_Post($text)
{
    $connection = $GLOBALS['connection'];
    $my_profile_code = $GLOBALS['my_profile_code'];
    $user_uploads_path = $GLOBALS['user_uploads_path'];

    if (is_uploaded_file($_FILES['image']['tmp_name'])) {
        $image_available = true;

        $image = $_FILES['image']['tmp_name'];

        if (getimagesize($image)) {
            $valid_image = true;
        } else {
            $valid_image = false;
        }
    } else {
        $image_available = false;
    }

    if (($image_available && $valid_image) || !$image_available) {
        $text = Censor_String($text);

        $at = time();

        if ($image_available && $valid_image) {
            $query = pg_query($connection, "INSERT INTO feedline(profile_code, image, text, at) VALUES('$my_profile_code', true, '$text', '$at') RETURNING serial;");
        } else {
            $query = pg_query($connection, "INSERT INTO feedline(profile_code, image, text, at) VALUES('$my_profile_code', NULL, '$text', '$at') RETURNING serial;");
        }

        $serial = pg_fetch_result($query, 0, 'serial');
    }

    if ($image_available && $valid_image) {
        Process_Image($image, 1024, -1, $user_uploads_path . 'Post_Images/FeedLine_' . $serial . '.webp');
    }

    if ($image_available && !$valid_image) {
        $success = false;
        $serial = '';
        $error = 'This file is not an image!';
    } else {
        $success = true;
        $error = '';
    }

    $array = ['success' => $success, 'serial' => $serial, 'error' => $error];
    $json = json_encode($array);

    return $json;
}