<?php
/* By Abdullah As-Sadeed */

function Edit_Face_Logo()
{
    $connection = $GLOBALS['connection'];
    $my_profile_code = $GLOBALS['my_profile_code'];
    $user_uploads_path = $GLOBALS['user_uploads_path'];

    if (is_uploaded_file($_FILES['face_logo']['tmp_name'])) {
        $face_logo = $_FILES['face_logo']['tmp_name'];

        if (getimagesize($face_logo)) {
            unlink($user_uploads_path . 'Faces_Logos/Face_' . $my_profile_code . '_' . Retrieve_Face_Logo_Time($my_profile_code) . '.webp');

            $time = time();

            Process_Image($face_logo, 128, 128, $user_uploads_path . 'Faces_Logos/Face_' . $my_profile_code . '_' . $time . '.webp');

            pg_query($connection, "UPDATE users SET last_face_logo = '$time' WHERE profile_code = '$my_profile_code';");
        }
    }

    $array = ['edited' => true];
    $json = json_encode($array);

    return $json;
}